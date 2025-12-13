<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpenStackImage;
use App\Services\OpenStack\OpenStackImageService;
use App\Services\OpenStack\OpenStackConnectionService;
use App\Http\Requests\Admin\StoreImageRequest;
use App\Http\Requests\Admin\UpdateImageRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ImageManagementController extends Controller
{
    protected OpenStackImageService $imageService;
    protected OpenStackConnectionService $connection;

    public function __construct(
        OpenStackImageService $imageService,
        OpenStackConnectionService $connection
    ) {
        $this->imageService = $imageService;
        $this->connection = $connection;
    }

    /**
     * Show the image management page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = OpenStackImage::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('openstack_id', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Type filter (based on metadata or name patterns)
        if ($request->filled('type')) {
            $type = $request->get('type');
            if ($type === 'os') {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%Ubuntu%')
                      ->orWhere('name', 'like', '%Debian%')
                      ->orWhere('name', 'like', '%CentOS%')
                      ->orWhere('name', 'like', '%Windows%')
                      ->orWhere('name', 'like', '%AlmaLinux%');
                });
            } elseif ($type === 'custom') {
                $query->whereNot(function ($q) {
                    $q->where('name', 'like', '%Ubuntu%')
                      ->orWhere('name', 'like', '%Debian%')
                      ->orWhere('name', 'like', '%CentOS%')
                      ->orWhere('name', 'like', '%Windows%')
                      ->orWhere('name', 'like', '%AlmaLinux%');
                });
            }
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('status', 'active');
            } elseif ($status === 'disabled') {
                $query->where('status', '!=', 'active');
            } elseif ($status === 'error') {
                $query->whereIn('status', ['killed', 'deleted', 'error']);
            }
        }

        // Order by
        $query->orderBy('created_at', 'desc');

        // Paginate
        $images = $query->paginate(12)->withQueryString();

        // Statistics
        $stats = [
            'total' => OpenStackImage::count(),
            'active' => OpenStackImage::where('status', 'active')->count(),
            'disabled' => OpenStackImage::where('status', '!=', 'active')->count(),
            'public' => OpenStackImage::where('visibility', 'public')->count(),
        ];

        $filters = [
            'search' => $request->get('search'),
            'type' => $request->get('type'),
            'status' => $request->get('status'),
        ];

        return view('admin.images.index', compact('images', 'stats', 'filters'));
    }

    /**
     * Show the create image page.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.images.create');
    }

    /**
     * Store a newly created image.
     *
     * @param StoreImageRequest $request
     * @return RedirectResponse
     */
    public function store(StoreImageRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            if ($request->input('upload_method') === 'file') {
                $file = $request->file('image_file');
                $image = $this->imageService->uploadFromFile($data, $file);
            } else {
                $url = $request->input('image_url');
                $image = $this->imageService->uploadFromUrl($data, $url);
            }

            Session::flash('success', 'Image با موفقیت آپلود شد.');

            return redirect()->route('admin.images.show', $image->id);
        } catch (\Exception $e) {
            Log::error('Failed to store image', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'خطا در آپلود Image: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the image detail/edit page.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $image = OpenStackImage::findOrFail($id);
        
        // Get usage statistics
        $usageStats = [
            'active_instances' => $image->instances()->where('status', 'active')->count(),
            'total_instances' => $image->instances()->count(),
        ];

        return view('admin.images.show', compact('image', 'usageStats'));
    }

    /**
     * Update an image.
     *
     * @param UpdateImageRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(UpdateImageRequest $request, string $id): RedirectResponse
    {
        try {
            $image = OpenStackImage::findOrFail($id);
            $data = $request->validated();

            $this->imageService->update($image, $data);

            Session::flash('success', 'Image با موفقیت به‌روزرسانی شد.');

            return redirect()->route('admin.images.show', $image->id);
        } catch (\Exception $e) {
            Log::error('Failed to update image', [
                'error' => $e->getMessage(),
                'image_id' => $id,
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'خطا در به‌روزرسانی Image: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete an image.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $image = OpenStackImage::findOrFail($id);

            $this->imageService->delete($image);

            Session::flash('success', 'Image با موفقیت حذف شد.');

            return redirect()->route('admin.images.index');
        } catch (\Exception $e) {
            Log::error('Failed to delete image', [
                'error' => $e->getMessage(),
                'image_id' => $id,
            ]);

            return back()
                ->withErrors(['error' => 'خطا در حذف Image: ' . $e->getMessage()]);
        }
    }

    /**
     * Toggle image status.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function toggleStatus(string $id): RedirectResponse
    {
        try {
            $image = OpenStackImage::findOrFail($id);

            $this->imageService->toggleStatus($image);

            $status = $image->status === 'active' ? 'فعال' : 'غیرفعال';
            Session::flash('success', "وضعیت Image به {$status} تغییر کرد.");

            return back();
        } catch (\Exception $e) {
            Log::error('Failed to toggle image status', [
                'error' => $e->getMessage(),
                'image_id' => $id,
            ]);

            return back()
                ->withErrors(['error' => 'خطا در تغییر وضعیت Image: ' . $e->getMessage()]);
        }
    }
}



