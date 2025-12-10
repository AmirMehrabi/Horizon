<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComputeController extends Controller
{
    /**
     * Show the compute instances list page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.compute.index');
    }

    /**
     * Show the instance detail page.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        return view('admin.compute.show', compact('id'));
    }
}



