<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectManagementController extends Controller
{
    /**
     * Show the project management page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.projects.index');
    }
}



