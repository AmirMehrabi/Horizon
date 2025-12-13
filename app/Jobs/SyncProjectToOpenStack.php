<?php

namespace App\Jobs;

use App\Models\Project;
use App\Services\OpenStack\OpenStackProjectService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncProjectToOpenStack implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30; // seconds between retries

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Project $project,
        public string $action = 'sync' // 'create', 'update', 'delete', 'sync'
    ) {
        // Set queue name for better organization
        $this->onQueue('openstack-sync');
    }

    /**
     * Execute the job.
     */
    public function handle(OpenStackProjectService $projectService): void
    {
        try {
            // Refresh project to get latest data
            $this->project->refresh();

            // Update sync status to syncing
            $this->project->update([
                'sync_status' => Project::SYNC_STATUS_SYNCING,
                'sync_error' => null,
            ]);

            // Perform the appropriate action
            match ($this->action) {
                'create' => $this->handleCreate($projectService),
                'update' => $this->handleUpdate($projectService),
                'delete' => $this->handleDelete($projectService),
                'sync' => $this->handleSync($projectService),
                default => throw new \Exception("Unknown action: {$this->action}"),
            };

            Log::info('Project sync completed', [
                'project_id' => $this->project->id,
                'action' => $this->action,
                'openstack_project_id' => $this->project->openstack_project_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Project sync failed', [
                'project_id' => $this->project->id,
                'action' => $this->action,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Update project with error status
            $this->project->update([
                'sync_status' => Project::SYNC_STATUS_ERROR,
                'sync_error' => $e->getMessage(),
            ]);

            // Re-throw to trigger retry mechanism
            throw $e;
        }
    }

    /**
     * Handle project creation.
     */
    protected function handleCreate(OpenStackProjectService $projectService): void
    {
        $result = $projectService->createProject($this->project);
        
        // Refresh project to get updated data
        $this->project->refresh();
        
        Log::info('Project created in OpenStack', [
            'project_id' => $this->project->id,
            'openstack_project_id' => $this->project->openstack_project_id,
        ]);
    }

    /**
     * Handle project update.
     */
    protected function handleUpdate(OpenStackProjectService $projectService): void
    {
        $result = $projectService->updateProject($this->project);
        
        // Refresh project to get updated data
        $this->project->refresh();
        
        Log::info('Project updated in OpenStack', [
            'project_id' => $this->project->id,
            'openstack_project_id' => $this->project->openstack_project_id,
        ]);
    }

    /**
     * Handle project deletion.
     */
    protected function handleDelete(OpenStackProjectService $projectService): void
    {
        $result = $projectService->deleteProject($this->project);
        
        // Refresh project to get updated data
        $this->project->refresh();
        
        Log::info('Project deleted from OpenStack', [
            'project_id' => $this->project->id,
        ]);
    }

    /**
     * Handle project sync (create if doesn't exist, update if exists).
     */
    protected function handleSync(OpenStackProjectService $projectService): void
    {
        if ($this->project->openstack_project_id) {
            // Project exists in OpenStack, update it
            $this->handleUpdate($projectService);
        } else {
            // Project doesn't exist in OpenStack, create it
            $this->handleCreate($projectService);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Project sync job failed permanently', [
            'project_id' => $this->project->id,
            'action' => $this->action,
            'error' => $exception->getMessage(),
        ]);

        // Update project with final error status
        $this->project->update([
            'sync_status' => Project::SYNC_STATUS_ERROR,
            'sync_error' => $exception->getMessage(),
        ]);
    }
}
