<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * Show the user management page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.users.index');
    }
}



