@php
    $direction = config('ui.direction', 'ltr');
    $language = config('ui.language', 'en');
    $isRtl = $direction === 'rtl';
    $isFarsi = $language === 'fa';
@endphp

<!DOCTYPE html>
<html lang="{{ $language === 'fa' ? 'fa' : 'en' }}" dir="{{ $direction }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ __('Customer Dashboard') }} - {{ config('app.name', 'آویاتو') }}</title>

        <!-- Fonts -->
        @if(!$isFarsi)
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @endif
    
        <!-- Pelak Font Face Declarations (Local) -->
        @if($isFarsi)
        <style>
            @font-face {
                font-family: 'Pelak';
                src: url('{{ asset('assets/fonts/pelak.woff2') }}') format('woff2'),
                     url('{{ asset('assets/fonts/pelak.woff') }}') format('woff');
                font-weight: 400;
                font-style: normal;
                font-display: swap;
            }
            
            @font-face {
                font-family: 'Pelak';
                src: url('{{ asset('assets/fonts/pelak.woff2') }}') format('woff2'),
                     url('{{ asset('assets/fonts/pelak.woff') }}') format('woff');
                font-weight: 500;
                font-style: normal;
                font-display: swap;
            }
            
            @font-face {
                font-family: 'Pelak';
                src: url('{{ asset('assets/fonts/pelak.woff2') }}') format('woff2'),
                     url('{{ asset('assets/fonts/pelak.woff') }}') format('woff');
                font-weight: 600;
                font-style: normal;
                font-display: swap;
            }
            
            @font-face {
                font-family: 'Pelak';
                src: url('{{ asset('assets/fonts/pelak.woff2') }}') format('woff2'),
                     url('{{ asset('assets/fonts/pelak.woff') }}') format('woff');
                font-weight: 700;
                font-style: normal;
                font-display: swap;
            }
            
            body, * {
                font-family: 'Pelak', 'Tahoma', 'Arial', sans-serif !important;
            }
        </style>
        @endif

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
            /* Tailwind CSS will be injected here */
            </style>
        @endif
    </head>
<body class="bg-white" style="direction: {{ $direction }};">
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden lg:hidden"></div>
    
    <!-- Fixed Sidebar -->
    <aside id="sidebar" class="fixed top-0 {{ $isRtl ? 'right-0' : 'left-0' }} z-50 w-64 h-screen bg-blue-600 transform {{ $isRtl ? 'translate-x-full lg:translate-x-0' : '-translate-x-full lg:translate-x-0' }} transition-transform duration-300">
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
                    <!-- Customer Section -->
                    <div class="mb-6">
                        <h3 class="px-3 text-xs font-semibold uppercase tracking-wider mb-2 text-white">{{ __('My Resources') }}</h3>
                    </div>
                    
                    <!-- Dashboard -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium bg-blue-700 text-white rounded-lg ">
                        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                        {{ __('Dashboard') }}
                    </a>
                    
                    <!-- My Machines -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
                        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                        </svg>
                        {{ __('My Machines') }}
                    </a>
                    
                    <!-- Monitoring -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
                        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('Monitoring') }}
                    </a>
                    
                    <!-- Billing -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
                        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        {{ __('Billing') }}
                    </a>
                </div>
                
                <!-- Divider -->
                <div class="my-6 border-t border-blue-700"></div>
                
                <!-- Account Section -->
                <div class="space-y-1">
                    <!-- Support -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
                        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        {{ __('Support') }}
                    </a>
                    
                    <!-- Account Settings -->
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
                        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('Account Settings') }}
                    </a>
                </div>
            </nav>
        </div>
    </aside>
    
    <!-- Main Content Area -->
    <div id="main-content-wrapper" class="{{ $isRtl ? 'pr-0 lg:pr-64' : 'pl-0 lg:pl-64' }}">
        <!-- Top Navigation Bar -->
        <header class="fixed top-0 h-[60px] bg-white border-b border-gray-200 z-30 {{ $isRtl ? 'right-0 left-0 lg:right-64' : 'right-0 left-0 lg:left-64' }}">
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
                
                <!-- Welcome Message -->
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <h1 class="text-lg font-medium text-gray-900">
                        {{ __('Welcome back, :name!', ['name' => $customer->first_name]) }}
                    </h1>
                </div>
                
                <!-- Right Side: User Menu -->
                <div class="flex items-center gap-4">
                    <!-- User Menu -->
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center gap-2 p-2 rounded-lg text-gray-700 hover:bg-gray-100 ">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-medium">
                                {{ strtoupper(substr($customer->first_name, 0, 1) . substr($customer->last_name, 0, 1)) }}
                            </div>
                            <span class="hidden md:block text-sm font-medium">{{ $customer->full_name }}</span>
                            <svg class="w-4 h-4 text-gray-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- User Dropdown Menu -->
                        <div id="user-menu" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Profile') }}</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Settings') }}</a>
                            <div class="border-t border-gray-200 my-1"></div>
                            <form method="POST" action="{{ route('customer.logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Sign out') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="pt-[75px] px-6 md:px-12 pb-8">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8 ">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ __('Dashboard') }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Overview of your cloud resources') }}</p>
                </div>
            </div>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Machines -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500">{{ __('Total Machines') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_machines'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Machines -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500">{{ __('Active Machines') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_machines'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Average CPU Usage -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500">{{ __('Avg CPU Usage') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['avg_cpu_usage'] }}%</p>
                        </div>
                    </div>
                </div>

                <!-- Monthly Cost -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500">{{ __('Monthly Cost') }}</p>
                            <p class="text-2xl font-semibold text-gray-900">${{ $stats['total_monthly_cost'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Machines Overview -->
            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Your Machines') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($machines as $machine)
                        <!-- Machine Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg 
                                        @if($machine->type === 'Droplet') bg-blue-100 @elseif($machine->type === 'Database') bg-purple-100 @else bg-green-100 @endif 
                                        flex items-center justify-center">
                                        @if($machine->type === 'Droplet')
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                        </svg>
                                        @elseif($machine->type === 'Database')
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                        </svg>
                                        @else
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $machine->name }}</h3>
                                        <p class="text-xs text-gray-500">{{ $machine->type }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if($machine->status === 'active') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($machine->status) }}
                                </span>
                            </div>
                            
                            <!-- Resource Usage -->
                            <div class="space-y-3">
                                <!-- CPU Usage -->
                                <div>
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>{{ __('CPU Usage') }}</span>
                                        <span>{{ $machine->cpu_usage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $machine->cpu_usage }}%"></div>
                                    </div>
                                </div>
                                
                                <!-- Memory Usage -->
                                <div>
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>{{ __('Memory Usage') }}</span>
                                        <span>{{ $machine->memory_usage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $machine->memory_usage }}%"></div>
                                    </div>
                                </div>
                                
                                <!-- Disk Usage -->
                                <div>
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>{{ __('Disk Usage') }}</span>
                                        <span>{{ $machine->disk_usage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ $machine->disk_usage }}%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">{{ __('Region') }}</span>
                                    <span class="text-gray-900 font-medium">{{ $machine->region }}</span>
                                </div>
                                <div class="flex justify-between text-sm mt-1">
                                    <span class="text-gray-500">{{ __('Created') }}</span>
                                    <span class="text-gray-900 font-medium">{{ $machine->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Custom JavaScript for Mobile Menu -->
    <script>
        // Check if RTL
        const isRtl = document.documentElement.dir === 'rtl' || document.body.style.direction === 'rtl';
        const translateClass = isRtl ? 'translate-x-full' : '-translate-x-full';
        
        // Mobile sidebar toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        
        function toggleSidebar() {
            // Only toggle on mobile screens (below lg breakpoint)
            if (window.innerWidth < 1024) {
                sidebar.classList.toggle(translateClass);
                sidebarOverlay.classList.toggle('hidden');
            }
        }
        
        // Ensure sidebar is visible on desktop on page load
        const mainContentWrapper = document.getElementById('main-content-wrapper');
        
        function checkSidebarVisibility() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove(translateClass);
                sidebarOverlay.classList.add('hidden');
                // Ensure main content has proper padding (256px = w-64)
                if (mainContentWrapper) {
                    if (isRtl) {
                        mainContentWrapper.style.paddingRight = '256px';
                        mainContentWrapper.style.paddingLeft = '0';
                    } else {
                        mainContentWrapper.style.paddingLeft = '256px';
                        mainContentWrapper.style.paddingRight = '0';
                    }
                }
            } else {
                sidebar.classList.add(translateClass);
                // Remove padding on mobile
                if (mainContentWrapper) {
                    mainContentWrapper.style.paddingLeft = '0';
                    mainContentWrapper.style.paddingRight = '0';
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
