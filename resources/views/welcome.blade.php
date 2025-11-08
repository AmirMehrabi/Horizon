<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Horizon') }} - Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
            /* Tailwind CSS will be injected here */
            </style>
        @endif
    </head>
<body class="bg-white">
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden lg:hidden"></div>
    
    <!-- Fixed Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 z-50 w-64 h-screen bg-blue-600 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="h-full flex flex-col">
            <!-- Logo -->
            <div class="h-[60px] flex items-center px-6 border-b border-blue-700">
                <a href="/" class="text-xl font-semibold text-white">
                    {{ config('app.name', 'Cloud Platform') }}
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 px-4">
                <div class="space-y-1">
                    <!-- Projects Section -->
                    <div class="mb-6">
                        <h3 class="px-3 text-xs font-semibold text-blue-200 uppercase tracking-wider mb-2">Projects</h3>
                    </div>
                    
                    <!-- Droplets -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium bg-blue-700 text-white rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                        </svg>
                        Droplets
                    </a>
                    
                    <!-- Kubernetes -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Kubernetes
                    </a>
                    
                    <!-- Databases -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                        </svg>
                        Databases
                    </a>
                    
                    <!-- Volumes -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Volumes
                    </a>
                    
                    <!-- Networking -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        Networking
                    </a>
                    
                    <!-- Monitoring -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Monitoring
                    </a>
                </div>
                
                <!-- Divider -->
                <div class="my-6 border-t border-blue-700"></div>
                
                <!-- Account Section -->
                <div class="space-y-1">
                    <!-- Billing -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Billing
                    </a>
                    
                    <!-- Account -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Account
                    </a>
                    
                    <!-- API Tokens -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        API Tokens
                    </a>
                </div>
                </nav>
        </div>
    </aside>
    
    <!-- Main Content Area -->
    <div id="main-content-wrapper" class="pl-0 lg:pl-64">
        <!-- Top Navigation Bar -->
        <header class="fixed top-0 right-0 left-0 lg:left-64 h-[60px] bg-white border-b border-gray-200 z-30">
            <div class="h-full flex items-center justify-between px-6">
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <!-- Logo (Mobile) -->
                <div class="lg:hidden">
                    <a href="/" class="text-lg font-semibold text-gray-900">
                        {{ config('app.name', 'Cloud Platform') }}
                    </a>
                </div>
                
                <!-- Search Input (Centered) -->
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="search-input" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Search resources...">
                    </div>
                </div>
                
                <!-- Right Side: Notifications + User Menu -->
                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <button class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-blue-600 ring-2 ring-white"></span>
                    </button>
                    
                    <!-- User Menu -->
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center gap-2 p-2 rounded-lg text-gray-700 hover:bg-gray-100">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-medium">
                                JD
                            </div>
                            <svg class="w-4 h-4 text-gray-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- User Dropdown Menu -->
                        <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>
                            <div class="border-t border-gray-200 my-1"></div>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Sign out</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="pt-[60px] px-6 md:px-12 py-8">
            <!-- Page Header with Create Button -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
                    <p class="mt-1 text-sm text-gray-500">Welcome back! Here's what's happening with your resources.</p>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create
                </button>
            </div>
            
            <!-- Recent Resources Section -->
            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Resources</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Resource Card 1 -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">web-server-01</h3>
                                        <p class="text-xs text-gray-500">Droplet</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Region</span>
                                    <span class="text-gray-900 font-medium">NYC1</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Size</span>
                                    <span class="text-gray-900 font-medium">s-2vcpu-4gb</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Created</span>
                                    <span class="text-gray-900 font-medium">2 days ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resource Card 2 -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">postgres-main</h3>
                                        <p class="text-xs text-gray-500">Database</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                            </span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Type</span>
                                    <span class="text-gray-900 font-medium">PostgreSQL</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Version</span>
                                    <span class="text-gray-900 font-medium">15.2</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Created</span>
                                    <span class="text-gray-900 font-medium">1 week ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resource Card 3 -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">k8s-cluster-prod</h3>
                                        <p class="text-xs text-gray-500">Kubernetes</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                            </span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Nodes</span>
                                    <span class="text-gray-900 font-medium">3</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Version</span>
                                    <span class="text-gray-900 font-medium">1.28.2</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Created</span>
                                    <span class="text-gray-900 font-medium">3 weeks ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resource Card 4 -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">storage-volume-01</h3>
                                        <p class="text-xs text-gray-500">Volume</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Size</span>
                                    <span class="text-gray-900 font-medium">100 GB</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Region</span>
                                    <span class="text-gray-900 font-medium">NYC1</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Created</span>
                                    <span class="text-gray-900 font-medium">5 days ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resource Card 5 -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">load-balancer-01</h3>
                                        <p class="text-xs text-gray-500">Load Balancer</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                            </span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Algorithm</span>
                                    <span class="text-gray-900 font-medium">Round Robin</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Health Checks</span>
                                    <span class="text-gray-900 font-medium">Enabled</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Created</span>
                                    <span class="text-gray-900 font-medium">1 week ago</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resource Card 6 -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">monitoring-dashboard</h3>
                                        <p class="text-xs text-gray-500">Monitoring</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                            </span>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Alerts</span>
                                    <span class="text-gray-900 font-medium">5 Active</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Metrics</span>
                                    <span class="text-gray-900 font-medium">24/7</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Created</span>
                                    <span class="text-gray-900 font-medium">2 weeks ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Get Started Checklist -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Get Started</h2>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">Create your first Droplet</h3>
                                <p class="text-sm text-gray-500 mt-1">Deploy a virtual machine in seconds with our simple interface.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">Set up a database</h3>
                                <p class="text-sm text-gray-500 mt-1">Choose from PostgreSQL, MySQL, or Redis managed databases.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">Configure networking</h3>
                                <p class="text-sm text-gray-500 mt-1">Set up VPCs, firewalls, and load balancers for your infrastructure.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">Enable monitoring</h3>
                                <p class="text-sm text-gray-500 mt-1">Track performance and set up alerts for your resources.</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </main>
        </div>

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    
    <!-- Custom JavaScript for Mobile Menu -->
    <script>
        // Mobile sidebar toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        
        function toggleSidebar() {
            // Only toggle on mobile screens (below lg breakpoint)
            if (window.innerWidth < 1024) {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            }
        }
        
        // Ensure sidebar is visible on desktop on page load
        const mainContentWrapper = document.getElementById('main-content-wrapper');
        
        function checkSidebarVisibility() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                // Ensure main content has proper padding (256px = w-64)
                if (mainContentWrapper) {
                    mainContentWrapper.style.paddingLeft = '256px';
                }
            } else {
                sidebar.classList.add('-translate-x-full');
                // Remove padding on mobile
                if (mainContentWrapper) {
                    mainContentWrapper.style.paddingLeft = '0';
                }
            }
        }
        
        // Check on load and resize
        checkSidebarVisibility();
        window.addEventListener('resize', checkSidebarVisibility);
        
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', toggleSidebar);
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }
        
        // User menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        
        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }
    </script>
    </body>
</html>
