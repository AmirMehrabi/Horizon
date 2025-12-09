<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Show the main landing page with portal selection.
     *
     * @return View
     */
    public function index(): View
    {
        return view('landing.index');
    }

    /**
     * Show the portal selection page.
     *
     * @return View
     */
    public function choosePortal(): View
    {
        return view('landing.choose-portal');
    }
}
