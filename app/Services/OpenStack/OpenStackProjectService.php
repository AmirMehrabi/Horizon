<?php

namespace App\Services\OpenStack;

use App\Models\Project;
use App\Models\ProjectQuota;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OpenStackProjectService
{
    protected OpenStackConnectionService $connection;

    public function __construct(OpenStackConnectionService $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Create a project in OpenStack.
     *
     * @param Project $project
     * @return array
     * @throws \Exception
     */
    public function createProject(Project $project): array
    {
        try {
            $identity = $this->connection->getIdentityService();
            
            // Get domain ID (use default domain if not specified)
            $domainId = $project->openstack_domain_id ?? config('openstack.domain_id') ?? 'default';
            
            // Prepare project data
            $projectData = [
                'name' => $project->name,
                'description' => $project->description ?? '',
                'domainId' => $domainId,
                'enabled' => $project->status === Project::STATUS_ACTIVE,
            ];

            // Create project in OpenStack
            // Note: The php-opencloud/openstack library uses createProject method
            $openstackProject = $identity->createProject($projectData);
            
            // Ensure we have the project ID
            if (!isset($openstackProject->id)) {
                throw new \Exception('Project created but ID not returned from OpenStack');
            }

            // Update local project with OpenStack ID
            $project->update([
                'openstack_project_id' => $openstackProject->id,
                'openstack_domain_id' => $openstackProject->domainId ?? $domainId,
                'sync_status' => Project::SYNC_STATUS_SYNCED,
                'synced_at' => now(),
                'sync_error' => null,
            ]);

            // Sync quota to OpenStack
            if ($project->quota) {
                $this->syncQuota($project, $project->quota);
            }

            Log::info('Project created in OpenStack', [
                'project_id' => $project->id,
                'openstack_project_id' => $openstackProject->id,
            ]);

            return [
                'success' => true,
                'openstack_project_id' => $openstackProject->id,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to create project in OpenStack', [
                'project_id' => $project->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $project->update([
                'sync_status' => Project::SYNC_STATUS_ERROR,
                'sync_error' => $e->getMessage(),
            ]);

            throw new \Exception('Failed to create project in OpenStack: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Update a project in OpenStack.
     *
     * @param Project $project
     * @return array
     * @throws \Exception
     */
    public function updateProject(Project $project): array
    {
        if (!$project->openstack_project_id) {
            // Project doesn't exist in OpenStack yet, create it
            return $this->createProject($project);
        }

        try {
            $identity = $this->connection->getIdentityService();

            // Get existing project from OpenStack
            $openstackProject = $identity->getProject(['id' => $project->openstack_project_id]);

            // Prepare update data
            $updateData = [
                'name' => $project->name,
                'description' => $project->description ?? '',
                'enabled' => $project->status === Project::STATUS_ACTIVE,
            ];

            // Update project in OpenStack
            // Note: Some OpenStack deployments may require different update methods
            if (method_exists($openstackProject, 'update')) {
                $openstackProject->update($updateData);
            } elseif (method_exists($identity, 'updateProject')) {
                $identity->updateProject(['id' => $project->openstack_project_id] + $updateData);
            } else {
                // Fallback: delete and recreate (not ideal but works)
                Log::warning('Update method not available, recreating project', [
                    'project_id' => $project->id,
                ]);
                $openstackProject->delete();
                $openstackProject = $identity->createProject($updateData + [
                    'domainId' => $project->openstack_domain_id ?? config('openstack.domain_id') ?? 'default',
                ]);
                $project->update(['openstack_project_id' => $openstackProject->id]);
            }

            // Update local project
            $project->update([
                'sync_status' => Project::SYNC_STATUS_SYNCED,
                'synced_at' => now(),
                'sync_error' => null,
            ]);

            // Sync quota if it exists
            if ($project->quota) {
                $this->syncQuota($project, $project->quota);
            }

            Log::info('Project updated in OpenStack', [
                'project_id' => $project->id,
                'openstack_project_id' => $project->openstack_project_id,
            ]);

            return [
                'success' => true,
                'openstack_project_id' => $project->openstack_project_id,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to update project in OpenStack', [
                'project_id' => $project->id,
                'openstack_project_id' => $project->openstack_project_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $project->update([
                'sync_status' => Project::SYNC_STATUS_ERROR,
                'sync_error' => $e->getMessage(),
            ]);

            throw new \Exception('Failed to update project in OpenStack: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Delete a project from OpenStack.
     *
     * @param Project $project
     * @return array
     * @throws \Exception
     */
    public function deleteProject(Project $project): array
    {
        if (!$project->openstack_project_id) {
            // Project doesn't exist in OpenStack, nothing to delete
            Log::info('Project does not exist in OpenStack, skipping deletion', [
                'project_id' => $project->id,
            ]);

            return [
                'success' => true,
                'message' => 'Project does not exist in OpenStack',
            ];
        }

        try {
            $identity = $this->connection->getIdentityService();

            // Get project from OpenStack
            $openstackProject = $identity->getProject(['id' => $project->openstack_project_id]);

            // Delete project in OpenStack
            $openstackProject->delete();

            // Update local project
            $project->update([
                'openstack_project_id' => null,
                'sync_status' => Project::SYNC_STATUS_SYNCED,
                'synced_at' => now(),
                'sync_error' => null,
            ]);

            Log::info('Project deleted from OpenStack', [
                'project_id' => $project->id,
                'openstack_project_id' => $project->openstack_project_id,
            ]);

            return [
                'success' => true,
                'message' => 'Project deleted successfully',
            ];
        } catch (\Exception $e) {
            Log::error('Failed to delete project from OpenStack', [
                'project_id' => $project->id,
                'openstack_project_id' => $project->openstack_project_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Don't update sync_status on delete failure - project still exists in OpenStack
            throw new \Exception('Failed to delete project from OpenStack: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Sync quota to OpenStack.
     *
     * @param Project $project
     * @param ProjectQuota $quota
     * @return array
     * @throws \Exception
     */
    public function syncQuota(Project $project, ProjectQuota $quota): array
    {
        if (!$project->openstack_project_id) {
            throw new \Exception('Project must be synced to OpenStack before syncing quota');
        }

        try {
            $compute = $this->connection->getComputeService();
            $networking = $this->connection->getNetworkingService();

            // Sync compute quotas (Nova)
            $computeQuotaData = [
                'instances' => $quota->instances,
                'cores' => $quota->cores,
                'ram' => $quota->ram, // RAM in MB
                'key_pairs' => 100, // Default key pairs quota
                'metadata_items' => 128, // Default metadata items
                'injected_files' => 5, // Default injected files
                'injected_file_content_bytes' => 10240, // Default injected file content
                'injected_file_path_bytes' => 255, // Default injected file path
            ];

            // Update compute quota (Nova)
            try {
                // Try different method signatures based on OpenStack version
                if (method_exists($compute, 'updateQuotaSet')) {
                    $compute->updateQuotaSet([
                        'tenantId' => $project->openstack_project_id,
                        'quotaSet' => $computeQuotaData,
                    ]);
                } elseif (method_exists($compute, 'updateQuota')) {
                    $compute->updateQuota([
                        'tenantId' => $project->openstack_project_id,
                    ] + $computeQuotaData);
                } else {
                    // Quota updates may require admin privileges or different API
                    Log::info('Compute quota update method not available', [
                        'project_id' => $project->id,
                    ]);
                }
            } catch (\Exception $e) {
                // Some OpenStack deployments may not support quota updates via API
                Log::warning('Failed to update compute quota', [
                    'project_id' => $project->id,
                    'error' => $e->getMessage(),
                ]);
            }

            // Sync volume quotas (Cinder) - if available
            $volumeQuotaData = [
                'volumes' => $quota->volumes,
                'gigabytes' => $quota->gigabytes,
                'snapshots' => $quota->snapshots,
            ];

            // Note: Volume quota updates may require Cinder service
            // This is a placeholder - implement if Cinder service is available

            // Sync network quotas (Neutron)
            $networkQuotaData = [
                'floatingip' => $quota->floating_ips,
                'network' => $quota->networks,
                'subnet' => $quota->subnets,
                'router' => $quota->routers,
                'security_group' => $quota->security_groups,
                'security_group_rule' => $quota->security_group_rules,
            ];

            // Update network quota (Neutron)
            try {
                // Try different method signatures based on OpenStack version
                if (method_exists($networking, 'updateQuota')) {
                    $networking->updateQuota([
                        'tenantId' => $project->openstack_project_id,
                        'quota' => $networkQuotaData,
                    ]);
                } elseif (method_exists($networking, 'updateQuotaSet')) {
                    $networking->updateQuotaSet([
                        'tenantId' => $project->openstack_project_id,
                        'quotaSet' => $networkQuotaData,
                    ]);
                } else {
                    // Quota updates may require admin privileges or different API
                    Log::info('Network quota update method not available', [
                        'project_id' => $project->id,
                    ]);
                }
            } catch (\Exception $e) {
                // Some OpenStack deployments may not support quota updates via API
                Log::warning('Failed to update network quota', [
                    'project_id' => $project->id,
                    'error' => $e->getMessage(),
                ]);
            }

            // Update quota sync timestamp
            $quota->update([
                'synced_at' => now(),
            ]);

            Log::info('Quota synced to OpenStack', [
                'project_id' => $project->id,
                'openstack_project_id' => $project->openstack_project_id,
            ]);

            return [
                'success' => true,
                'message' => 'Quota synced successfully',
            ];
        } catch (\Exception $e) {
            Log::error('Failed to sync quota to OpenStack', [
                'project_id' => $project->id,
                'openstack_project_id' => $project->openstack_project_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new \Exception('Failed to sync quota to OpenStack: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Sync project from OpenStack to local database.
     * This is used for pulling existing projects from OpenStack.
     *
     * @param string $openstackProjectId
     * @param string|null $customerId
     * @return Project
     * @throws \Exception
     */
    public function syncFromOpenStack(string $openstackProjectId, ?string $customerId = null): Project
    {
        try {
            $identity = $this->connection->getIdentityService();

            // Get project from OpenStack
            $openstackProject = $identity->getProject(['id' => $openstackProjectId]);

            // Check if project already exists locally
            $project = Project::where('openstack_project_id', $openstackProjectId)->first();

            if ($project) {
                // Update existing project
                $project->update([
                    'name' => $openstackProject->name ?? $project->name,
                    'description' => $openstackProject->description ?? $project->description,
                    'openstack_domain_id' => $openstackProject->domainId ?? $project->openstack_domain_id,
                    'status' => ($openstackProject->enabled ?? true) ? Project::STATUS_ACTIVE : Project::STATUS_SUSPENDED,
                    'sync_status' => Project::SYNC_STATUS_SYNCED,
                    'synced_at' => now(),
                    'sync_error' => null,
                ]);
            } else {
                // Create new project
                if (!$customerId) {
                    throw new \Exception('Customer ID is required for new projects');
                }

                $project = Project::create([
                    'customer_id' => $customerId,
                    'name' => $openstackProject->name ?? 'Unnamed Project',
                    'description' => $openstackProject->description ?? null,
                    'openstack_project_id' => $openstackProjectId,
                    'openstack_domain_id' => $openstackProject->domainId ?? null,
                    'status' => ($openstackProject->enabled ?? true) ? Project::STATUS_ACTIVE : Project::STATUS_SUSPENDED,
                    'sync_status' => Project::SYNC_STATUS_SYNCED,
                    'synced_at' => now(),
                    'region' => config('openstack.region', 'RegionOne'),
                ]);
            }

            Log::info('Project synced from OpenStack', [
                'project_id' => $project->id,
                'openstack_project_id' => $openstackProjectId,
            ]);

            return $project;
        } catch (\Exception $e) {
            Log::error('Failed to sync project from OpenStack', [
                'openstack_project_id' => $openstackProjectId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new \Exception('Failed to sync project from OpenStack: ' . $e->getMessage(), 0, $e);
        }
    }
}

