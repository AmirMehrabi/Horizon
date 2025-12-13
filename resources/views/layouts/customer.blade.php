@php
    $direction = config('ui.direction', 'ltr');
    $language = config('ui.language', 'en');
    $isRtl = $direction === 'rtl';
    $isFarsi = $language === 'fa';
    $customer = auth('customer')->user();
    $wallet = $customer ? $customer->getOrCreateWallet() : null;
    $walletBalance = $wallet ? $wallet->balance : 0;
    $walletFormatted = $wallet ? $wallet->formatted_balance : '0 ریال';
    // Low balance threshold: less than 50,000 Rials (subtle warning)
    $isLowBalance = $walletBalance < 50000 && $walletBalance > 0;
    $isVeryLowBalance = $walletBalance <= 0;
@endphp

<!DOCTYPE html>
<html lang="{{ $language === 'fa' ? 'fa' : 'en' }}" dir="{{ $direction }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', __('Customer Dashboard')) - {{ config('app.name', 'آویاتو') }}</title>

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

        @stack('styles')
    </head>
<body class="bg-white" style="direction: {{ $direction }};">
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden lg:hidden"></div>
    
    <!-- Fixed Sidebar -->
    <aside id="sidebar" class="fixed top-0 {{ $isRtl ? 'right-0' : 'left-0' }} z-50 w-64 h-screen bg-blue-600 transform {{ $isRtl ? 'translate-x-full lg:translate-x-0' : '-translate-x-full lg:translate-x-0' }} transition-transform duration-300">
        <div class="h-full flex flex-col">
            <!-- Logo -->
            <div class="h-[60px] flex items-center px-6 border-b border-blue-700">
                <a href="{{ route('customer.dashboard') }}" class="text-xl font-semibold text-white">
                    {{ config('app.name', 'Cloud Platform') }}
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 sidebar-scroll">
                @include('customer.partials.sidebar')
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
                    <a href="{{ route('customer.dashboard') }}" class="text-lg font-semibold text-gray-900">
                        {{ config('app.name', 'Cloud Platform') }}
                    </a>
                </div>
                
                <!-- Header Content (Welcome Message or Breadcrumb) -->
                <div class="hidden md:flex flex-1 max-w-md mx-8 relative z-40  mr-64">
                    @hasSection('header_content')
                        @yield('header_content')
                    @else
                        <h1 class="text-lg font-medium text-gray-900">
                            {{ __('Welcome back, :name!', ['name' => $customer->first_name ?? '']) }}
                        </h1>
                    @endif
                </div>
                
                <!-- Right Side: Balance Indicator, Notifications & User Menu -->
                <div class="flex items-center gap-4">
                    <!-- Wallet Balance Indicator -->
                    <div class="relative">
                        <button id="wallet-balance-button" class="flex items-center gap-2 px-3 py-1.5 rounded-sm transition-all duration-200 hover:scale-[1.02] wallet-balance-button {{ $isVeryLowBalance ? 'bg-red-50 text-red-700 hover:bg-red-100' : ($isLowBalance ? 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' : 'bg-blue-50 text-blue-700 hover:bg-blue-100') }}" aria-label="منوی موجودی کیف پول" title="موجودی کیف پول شما">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <span id="wallet-balance-text" class="text-sm font-medium">{{ $walletFormatted }}</span>
                            @if($isLowBalance || $isVeryLowBalance)
                            <span class="inline-flex items-center justify-center w-2 h-2 rounded-full {{ $isVeryLowBalance ? 'bg-red-500' : 'bg-yellow-500' }} animate-pulse"></span>
                            @endif
                        </button>
                        
                        <!-- Wallet Balance Dropdown -->
                        <div id="wallet-balance-dropdown" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-[300px] bg-white rounded-lg shadow-lg border border-gray-200 z-50 overflow-hidden wallet-dropdown">
                            <!-- Header -->
                            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-sm font-semibold text-gray-900">کیف پول</h3>
                                <p class="text-xs text-gray-500 mt-0.5">موجود برای پرداخت و تمدید سرویس‌ها</p>
                            </div>
                            
                            <!-- Current Balance -->
                            <div class="px-4 py-4">
                                <p class="text-xs text-gray-500 mb-1">موجودی فعلی</p>
                                <p id="wallet-balance-large" class="text-2xl font-semibold {{ $isVeryLowBalance ? 'text-red-600' : ($isLowBalance ? 'text-yellow-600' : 'text-gray-900') }} wallet-balance-value">{{ $walletFormatted }}</p>
                                @if($isLowBalance || $isVeryLowBalance)
                                <div class="mt-2 p-2 rounded-lg {{ $isVeryLowBalance ? 'bg-red-50 border border-red-200' : 'bg-yellow-50 border border-yellow-200' }}">
                                    <p class="text-xs {{ $isVeryLowBalance ? 'text-red-700' : 'text-yellow-700' }}">
                                        @if($isVeryLowBalance)
                                        ⚠️ موجودی شما تمام شده است. لطفاً کیف پول خود را شارژ کنید.
                                        @else
                                        💡 موجودی شما در حال اتمام است. برای ادامه استفاده از سرویس‌ها، کیف پول خود را شارژ کنید.
                                        @endif
                                    </p>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="px-4 pb-3 space-y-2">
                                <a href="{{ route('customer.wallet.topup') }}" class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    شارژ کیف پول
                                </a>
                                <a href="{{ route('customer.wallet.index') }}" class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    مشاهده تراکنش‌ها
                                </a>
                            </div>
                            
                            <!-- Footer -->
                            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span>پرداخت‌ها به‌صورت آنی ثبت می‌شوند.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button id="notification-bell-button" class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" aria-label="اعلان‌ها" title="اعلان‌ها">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span id="notification-badge" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} top-0 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold leading-none text-white bg-red-600 rounded-full border-2 border-white">0</span>
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div id="notification-dropdown" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 overflow-hidden notification-dropdown">
                            <!-- Header -->
                            <div class="px-4 py-3 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-900">اعلان‌ها</h3>
                                <a href="{{ route('customer.notifications.index') }}" class="text-xs text-blue-600 hover:text-blue-700">مشاهده همه</a>
                            </div>
                            
                            <!-- Notifications List -->
                            <div id="notification-list" class="max-h-96 overflow-y-auto">
                                <div class="p-4 text-center text-sm text-gray-500">
                                    در حال بارگذاری...
                                </div>
                            </div>
                            
                            <!-- Footer -->
                            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 text-center">
                                <a href="{{ route('customer.notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                    مشاهده همه اعلان‌ها
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center gap-2 p-2 rounded-lg text-gray-700 hover:bg-gray-100 ">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-medium">
                                @yield('user_initials', strtoupper(substr($customer->first_name ?? 'C', 0, 1) . substr($customer->last_name ?? '', 0, 1)))
                            </div>
                            <span class="hidden md:block text-sm font-medium">{{ $customer->full_name ?? '' }}</span>
                            <svg class="w-4 h-4 text-gray-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- User Dropdown Menu -->
                        <div id="user-menu" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('پروفایل') }}</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('تنظیمات') }}</a>
                            <div class="border-t border-gray-200 my-1"></div>
                            <form method="POST" action="{{ route('customer.logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('خروج') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="pt-[75px] px-6 md:px-12 pb-8">
            @yield('content')
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
        
        // Notification bell toggle
        const notificationBellButton = document.getElementById('notification-bell-button');
        const notificationDropdown = document.getElementById('notification-dropdown');
        
        function toggleNotificationDropdown(show) {
            if (!notificationDropdown) return;
            
            if (show) {
                notificationDropdown.classList.remove('hidden');
                void notificationDropdown.offsetWidth;
                notificationDropdown.style.opacity = '1';
                notificationDropdown.style.transform = 'translateY(0)';
                loadNotifications();
            } else {
                notificationDropdown.style.opacity = '0';
                notificationDropdown.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    notificationDropdown.classList.add('hidden');
                }, 120);
            }
        }
        
        function loadNotifications() {
            fetch('{{ route("customer.notifications.api") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const notificationList = document.getElementById('notification-list');
                const notificationBadge = document.getElementById('notification-badge');
                
                // Update badge - only show if count is greater than 0
                if (data.unread_count && data.unread_count > 0) {
                    notificationBadge.textContent = data.unread_count > 9 ? '9+' : data.unread_count;
                    notificationBadge.classList.remove('hidden');
                } else {
                    notificationBadge.classList.add('hidden');
                    notificationBadge.textContent = '0'; // Reset to 0 when hiding
                }
                
                // Update list
                if (data.notifications && data.notifications.length > 0) {
                    notificationList.innerHTML = data.notifications.map(notif => {
                        const url = notif.action_url || '{{ route("customer.notifications.index") }}';
                        return `
                        <a href="${url}" data-notification-id="${notif.id}" data-read="${notif.read}" class="notification-item block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 ${!notif.read ? 'bg-blue-50' : ''}">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-2 h-2 rounded-full ${!notif.read ? 'bg-blue-600 mt-2' : 'bg-transparent'}"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">${notif.title}</p>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">${notif.description || ''}</p>
                                    <p class="text-xs text-gray-400 mt-1">${notif.time}</p>
                                </div>
                            </div>
                        </a>
                    `;
                    }).join('');
                    
                    // Add click handlers to mark as read
                    document.querySelectorAll('.notification-item').forEach(item => {
                        item.addEventListener('click', function(e) {
                            const notificationId = this.getAttribute('data-notification-id');
                            const isRead = this.getAttribute('data-read') === 'true';
                            
                            if (!isRead && notificationId) {
                                // Mark as read via AJAX
                                fetch(`/customer/notifications/${notificationId}/read`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'application/json'
                                    }
                                }).catch(err => console.error('Error marking notification as read:', err));
                            }
                        });
                    });
                } else {
                    notificationList.innerHTML = '<div class="p-4 text-center text-sm text-gray-500">اعلانی وجود ندارد</div>';
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                document.getElementById('notification-list').innerHTML = '<div class="p-4 text-center text-sm text-red-500">خطا در بارگذاری اعلان‌ها</div>';
            });
        }
        
        if (notificationBellButton && notificationDropdown) {
            notificationDropdown.style.opacity = '0';
            notificationDropdown.style.transform = 'translateY(-10px)';
            
            notificationBellButton.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = notificationDropdown.classList.contains('hidden');
                toggleNotificationDropdown(isHidden);
                if (walletBalanceDropdown) walletBalanceDropdown.classList.add('hidden');
                if (userMenu) userMenu.classList.add('hidden');
            });
            
            document.addEventListener('click', (e) => {
                if (!notificationBellButton.contains(e.target) && !notificationDropdown.contains(e.target)) {
                    toggleNotificationDropdown(false);
                }
            });
        }
        
        // Load notifications on page load
        if (notificationBellButton) {
            loadNotifications();
            // Refresh every 30 seconds
            setInterval(loadNotifications, 30000);
        }
        
        // Wallet balance dropdown toggle
        const walletBalanceButton = document.getElementById('wallet-balance-button');
        const walletBalanceDropdown = document.getElementById('wallet-balance-dropdown');
        
        function toggleWalletDropdown(show) {
            if (!walletBalanceDropdown) return;
            
            if (show) {
                walletBalanceDropdown.classList.remove('hidden');
                // Trigger reflow to ensure transition works
                void walletBalanceDropdown.offsetWidth;
                walletBalanceDropdown.style.opacity = '1';
                walletBalanceDropdown.style.transform = 'translateY(0)';
            } else {
                walletBalanceDropdown.style.opacity = '0';
                walletBalanceDropdown.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    walletBalanceDropdown.classList.add('hidden');
                }, 120);
            }
        }
        
        if (walletBalanceButton && walletBalanceDropdown) {
            // Initialize dropdown as hidden
            walletBalanceDropdown.style.opacity = '0';
            walletBalanceDropdown.style.transform = 'translateY(-10px)';
            
            walletBalanceButton.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = walletBalanceDropdown.classList.contains('hidden');
                toggleWalletDropdown(isHidden);
                if (notificationDropdown) notificationDropdown.classList.add('hidden');
                if (userMenu) userMenu.classList.add('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!walletBalanceButton.contains(e.target) && !walletBalanceDropdown.contains(e.target)) {
                    toggleWalletDropdown(false);
                }
            });
        }
        
        // User menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        
        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
                if (walletBalanceDropdown) walletBalanceDropdown.classList.add('hidden');
                if (notificationDropdown) notificationDropdown.classList.add('hidden');
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }
        
        // Auto-refresh wallet balance every 30 seconds
        function refreshWalletBalance() {
            fetch('{{ route("customer.wallet.balance") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const balanceText = document.getElementById('wallet-balance-text');
                const balanceLarge = document.getElementById('wallet-balance-large');
                const balanceButton = document.getElementById('wallet-balance-button');
                const balance = parseFloat(data.balance) || 0;
                const isLowBalance = balance < 50000 && balance > 0;
                const isVeryLowBalance = balance <= 0;
                
                // Add pulse animation
                if (balanceLarge) {
                    balanceLarge.classList.add('updating');
                    setTimeout(() => balanceLarge.classList.remove('updating'), 1000);
                }
                
                if (balanceText) balanceText.textContent = data.formatted_balance;
                if (balanceLarge) {
                    balanceLarge.textContent = data.formatted_balance;
                    // Update color based on balance
                    balanceLarge.className = 'text-2xl font-semibold wallet-balance-value ' + 
                        (isVeryLowBalance ? 'text-red-600' : (isLowBalance ? 'text-yellow-600' : 'text-gray-900'));
                }
                
                // Update button styling
                if (balanceButton) {
                    balanceButton.className = 'flex items-center gap-2 px-3 py-1.5 rounded-sm transition-all duration-200 hover:scale-[1.02] wallet-balance-button ' +
                        (isVeryLowBalance ? 'bg-red-50 text-red-700 hover:bg-red-100' : 
                         (isLowBalance ? 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' : 
                          'bg-blue-50 text-blue-700 hover:bg-blue-100'));
                    
                    // Update or add warning dot
                    let warningDot = balanceButton.querySelector('.animate-pulse');
                    if (isLowBalance || isVeryLowBalance) {
                        if (!warningDot) {
                            warningDot = document.createElement('span');
                            warningDot.className = 'inline-flex items-center justify-center w-2 h-2 rounded-full ' + 
                                (isVeryLowBalance ? 'bg-red-500' : 'bg-yellow-500') + ' animate-pulse';
                            balanceButton.appendChild(warningDot);
                        } else {
                            warningDot.className = 'inline-flex items-center justify-center w-2 h-2 rounded-full ' + 
                                (isVeryLowBalance ? 'bg-red-500' : 'bg-yellow-500') + ' animate-pulse';
                        }
                    } else if (warningDot) {
                        warningDot.remove();
                    }
                }
            })
            .catch(error => console.error('Error refreshing balance:', error));
        }
        
        // Initial balance load
        refreshWalletBalance();
        
        // Refresh balance every 30 seconds
        setInterval(refreshWalletBalance, 30000);
    </script>

    @stack('scripts')
    
    <style>
    /* Custom Scrollbar for Sidebar */
    .sidebar-scroll {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
    }
    
    .sidebar-scroll::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255, 255, 255, 0.5);
    }
    
    /* Hide scrollbar for Firefox */
    @-moz-document url-prefix() {
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }
    }
    
    /* Wallet Balance Dropdown Animation */
    .wallet-dropdown {
        transition: opacity 120ms ease-out, transform 120ms ease-out;
    }
    
    /* Notification Dropdown Animation */
    .notification-dropdown {
        transition: opacity 120ms ease-out, transform 120ms ease-out;
    }
    
    /* Balance Update Animation */
    @keyframes gentlePulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    .wallet-balance-value.updating {
        animation: gentlePulse 1s ease-in-out;
    }
    </style>
</body>
</html>



