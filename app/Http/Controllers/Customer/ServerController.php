<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * Display the VPS purchase wizard
     */
    public function create()
    {
        return view('customer.servers.create');
    }

    /**
     * Store the new VPS instance
     */
    public function store(Request $request)
    {
        // TODO: Implement VPS creation logic
        // This will handle the form submission from the wizard
        
        return redirect()->route('customer.servers.index')
            ->with('success', 'سرور شما در حال راه‌اندازی است');
    }

    /**
     * Display list of customer servers
     */
    public function index()
    {
        return view('customer.servers.index');
    }
}

