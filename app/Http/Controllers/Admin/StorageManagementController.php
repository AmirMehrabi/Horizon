<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorageManagementController extends Controller
{
    /**
     * Show the storage management index page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.storage.index');
    }

    /**
     * Show the volumes page.
     *
     * @return View
     */
    public function volumes(): View
    {
        return view('admin.storage.volumes');
    }

    /**
     * Show the volume detail page.
     *
     * @param string $id
     * @return View
     */
    public function showVolume(string $id): View
    {
        return view('admin.storage.volume-show', compact('id'));
    }

    /**
     * Show the volume types page.
     *
     * @return View
     */
    public function volumeTypes(): View
    {
        return view('admin.storage.volume-types');
    }

    /**
     * Show the snapshots page.
     *
     * @return View
     */
    public function snapshots(): View
    {
        return view('admin.storage.snapshots');
    }

    /**
     * Show the containers page (Swift).
     *
     * @return View
     */
    public function containers(): View
    {
        return view('admin.storage.containers');
    }

    /**
     * Show the container detail page.
     *
     * @param string $id
     * @return View
     */
    public function showContainer(string $id): View
    {
        return view('admin.storage.container-show', compact('id'));
    }
}

