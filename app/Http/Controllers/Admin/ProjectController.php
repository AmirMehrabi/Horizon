<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectQuota;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Project::with(['customer', 'quota'])
            ->withCount('users')
            ->latest();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by sync status
        if ($request->filled('sync_status')) {
            $query->where('sync_status', $request->sync_status);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $projects = $query->paginate(15)->withQueryString();

        // Get statistics
        $stats = [
            'total' => Project::count(),
            'active' => Project::where('status', Project::STATUS_ACTIVE)->count(),
            'synced' => Project::where('sync_status', Project::SYNC_STATUS_SYNCED)->count(),
            'total_users' => DB::table('project_user')->distinct('user_id')->count('user_id'),
        ];

        // Get customers for filter
        $customers = Customer::active()->orderBy('company_name')->orderBy('first_name')->get();

        return view('admin.projects.index', compact('projects', 'stats', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $customers = Customer::active()->orderBy('company_name')->orderBy('first_name')->get();
        return view('admin.projects.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'name' => 'required|string|max:255|unique:projects,name',
            'description' => 'nullable|string',
            'region' => 'nullable|string|max:100',
            'sync_immediately' => 'nullable|boolean',
            // Quota fields
            'quota_instances' => 'nullable|integer|min:1',
            'quota_cores' => 'nullable|integer|min:1',
            'quota_ram' => 'nullable|integer|min:1',
            'quota_volumes' => 'nullable|integer|min:1',
            'quota_gigabytes' => 'nullable|integer|min:1',
            'quota_floating_ips' => 'nullable|integer|min:1',
            'quota_networks' => 'nullable|integer|min:1',
            'quota_routers' => 'nullable|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Create project (local-first)
            $project = Project::create([
                'customer_id' => $validated['customer_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'region' => $validated['region'] ?? 'RegionOne',
                'status' => Project::STATUS_ACTIVE,
                'sync_status' => $validated['sync_immediately'] ?? false 
                    ? Project::SYNC_STATUS_PENDING 
                    : Project::SYNC_STATUS_PENDING,
            ]);

            // Create default quota
            ProjectQuota::create([
                'project_id' => $project->id,
                'instances' => $validated['quota_instances'] ?? 20,
                'cores' => $validated['quota_cores'] ?? 100,
                'ram' => $validated['quota_ram'] ?? 204800, // 200 GB in MB
                'volumes' => $validated['quota_volumes'] ?? 50,
                'gigabytes' => $validated['quota_gigabytes'] ?? 2048,
                'floating_ips' => $validated['quota_floating_ips'] ?? 50,
                'networks' => $validated['quota_networks'] ?? 10,
                'routers' => $validated['quota_routers'] ?? 5,
            ]);

            DB::commit();

            // TODO: Dispatch job to sync with OpenStack if sync_immediately is true

            return redirect()
                ->route('admin.projects.show', $project->id)
                ->with('success', 'پروژه با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'خطا در ایجاد پروژه: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $project = Project::with(['customer', 'quota', 'users'])
            ->withCount('instances')
            ->findOrFail($id);

        $resourceUsage = $project->getResourceUsage();

        return view('admin.projects.show', compact('project', 'resourceUsage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $project = Project::with(['customer', 'quota'])->findOrFail($id);
        $customers = Customer::active()->orderBy('company_name')->orderBy('first_name')->get();
        
        return view('admin.projects.edit', compact('project', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'name' => 'required|string|max:255|unique:projects,name,' . $id,
            'description' => 'nullable|string',
            'region' => 'nullable|string|max:100',
            'status' => 'required|in:' . implode(',', array_keys(Project::getStatuses())),
            // Quota fields
            'quota_instances' => 'nullable|integer|min:1',
            'quota_cores' => 'nullable|integer|min:1',
            'quota_ram' => 'nullable|integer|min:1',
            'quota_volumes' => 'nullable|integer|min:1',
            'quota_gigabytes' => 'nullable|integer|min:1',
            'quota_floating_ips' => 'nullable|integer|min:1',
            'quota_networks' => 'nullable|integer|min:1',
            'quota_routers' => 'nullable|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Update project
            $project->update([
                'customer_id' => $validated['customer_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'region' => $validated['region'] ?? $project->region,
                'status' => $validated['status'],
            ]);

            // Update quota
            $quota = $project->quota;
            if ($quota) {
                $quota->update([
                    'instances' => $validated['quota_instances'] ?? $quota->instances,
                    'cores' => $validated['quota_cores'] ?? $quota->cores,
                    'ram' => $validated['quota_ram'] ?? $quota->ram,
                    'volumes' => $validated['quota_volumes'] ?? $quota->volumes,
                    'gigabytes' => $validated['quota_gigabytes'] ?? $quota->gigabytes,
                    'floating_ips' => $validated['quota_floating_ips'] ?? $quota->floating_ips,
                    'networks' => $validated['quota_networks'] ?? $quota->networks,
                    'routers' => $validated['quota_routers'] ?? $quota->routers,
                ]);
            }

            DB::commit();

            // TODO: Dispatch job to sync with OpenStack

            return redirect()
                ->route('admin.projects.show', $project->id)
                ->with('success', 'پروژه با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'خطا در به‌روزرسانی پروژه: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        try {
            // Soft delete (local-first)
            $project->delete();

            // TODO: Dispatch job to delete from OpenStack

            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'پروژه با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'خطا در حذف پروژه: ' . $e->getMessage());
        }
    }

    /**
     * Sync project with OpenStack.
     */
    public function sync(string $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        try {
            $project->update([
                'sync_status' => Project::SYNC_STATUS_SYNCING,
                'sync_error' => null,
            ]);

            // TODO: Dispatch sync job

            return back()->with('success', 'همگام‌سازی پروژه شروع شد.');
        } catch (\Exception $e) {
            $project->update([
                'sync_status' => Project::SYNC_STATUS_ERROR,
                'sync_error' => $e->getMessage(),
            ]);

            return back()->with('error', 'خطا در همگام‌سازی: ' . $e->getMessage());
        }
    }

    /**
     * Update quota for a project.
     */
    public function updateQuota(Request $request, string $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'instances' => 'required|integer|min:1',
            'cores' => 'required|integer|min:1',
            'ram' => 'required|integer|min:1',
            'volumes' => 'required|integer|min:1',
            'gigabytes' => 'required|integer|min:1',
            'floating_ips' => 'required|integer|min:1',
            'networks' => 'required|integer|min:1',
            'routers' => 'required|integer|min:1',
        ]);

        $quota = $project->quota;
        if (!$quota) {
            $quota = ProjectQuota::create([
                'project_id' => $project->id,
                ...$validated,
            ]);
        } else {
            $quota->update($validated);
        }

        // TODO: Sync quota to OpenStack

        return back()->with('success', 'سهمیه با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Assign users to project.
     */
    public function assignUsers(Request $request, string $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'users' => 'required|array',
            'users.*.user_id' => 'required|exists:users,id',
            'users.*.role' => 'required|in:admin,member,viewer',
        ]);

        // Sync users
        $syncData = [];
        foreach ($validated['users'] as $userData) {
            $syncData[$userData['user_id']] = [
                'role' => $userData['role'],
            ];
        }

        $project->users()->sync($syncData);

        // TODO: Sync user assignments to OpenStack

        return back()->with('success', 'کاربران با موفقیت اختصاص داده شدند.');
    }
}
