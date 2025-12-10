<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImageManagementController extends Controller
{
    /**
     * Show the image management page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.images.index');
    }

    /**
     * Show the image detail/edit page.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        return view('admin.images.show', compact('id'));
    }
}



