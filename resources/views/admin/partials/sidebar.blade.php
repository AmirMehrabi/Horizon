@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
    $isBillingSection = request()->routeIs('admin.billing.*');
@endphp

@if($isBillingSection)
    <!-- Billing Sidebar -->
    <div class="w-64 bg-blue-800 text-white min-h-screen {{ $isRtl ? 'border-l' : 'border-r' }} border-blue-700">
        <!-- Logo/Header -->
        <div class="p-6 border-b border-blue-700">
            <h2 class="text-xl font-bold">سیستم صورتحساب</h2>
            <p class="text-blue-200 text-sm mt-1">مدیریت مالی</p>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 px-3 space-y-1 max-h-[calc(100vh-120px)] overflow-y-auto scrollbar-thin scrollbar-thumb-blue-600 scrollbar-track-blue-800">
            <!-- Dashboard -->
            <a href="{{ route('admin.billing.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.index') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7zm0 0a2 2 0 012-2h6l2 2h6a2 2 0 012 2z"></path>
                </svg>
                داشبورد صورتحساب
            </a>

            <!-- Billing Settings -->
            <a href="{{ route('admin.billing.settings') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.settings') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                تنظیمات صورتحساب
            </a>

            <!-- Pricing Plans -->
            <a href="{{ route('admin.billing.plans') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.plans*') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                پلن‌های قیمت‌گذاری
            </a>

            <!-- Usage Metrics -->
            <a href="{{ route('admin.billing.usage-metrics') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.usage-metrics') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                متریک‌های مصرف
            </a>

            <!-- Quotas Pricing -->
            <a href="{{ route('admin.billing.quotas') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.quotas') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                </svg>
                قیمت‌گذاری کوتا
            </a>

            <!-- Coupons -->
            <a href="{{ route('admin.billing.coupons') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.coupons') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                کوپن‌های تخفیف
            </a>

            <!-- Wallets -->
            <a href="{{ route('admin.billing.wallets') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.wallets') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                کیف پول‌ها
            </a>

            <!-- Invoices -->
            <a href="{{ route('admin.billing.invoices') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.invoices*') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                فاکتورها
            </a>

            <!-- Transactions -->
            <a href="{{ route('admin.billing.transactions') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.transactions') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
                تراکنش‌ها
            </a>

            <!-- Payment Gateways -->
            <a href="{{ route('admin.billing.payment-gateways') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.payment-gateways') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                درگاه‌های پرداخت
            </a>

            <!-- Automations -->
            <a href="{{ route('admin.billing.automations') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.automations') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                اتوماسیون‌ها
            </a>

            <!-- Credit System -->
            <a href="{{ route('admin.billing.credit-system') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.credit-system') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                سیستم اعتبار
            </a>

            <!-- Usage Reports -->
            <a href="{{ route('admin.billing.usage-reports') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.billing.usage-reports') ? 'bg-blue-700 text-white' : '' }}">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                گزارشات مصرف
            </a>

            <!-- Back to Main Dashboard -->
            <div class="pt-4 mt-4 border-t border-blue-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-200 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
                    <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    بازگشت به داشبورد اصلی
                </a>
            </div>
        </nav>
    </div>

    <style>
    /* Custom scrollbar for sidebar */
    .scrollbar-thin {
        scrollbar-width: thin;
    }

    .scrollbar-thumb-blue-600::-webkit-scrollbar-thumb {
        background-color: #2563eb;
        border-radius: 0.25rem;
    }

    .scrollbar-track-blue-800::-webkit-scrollbar-track {
        background-color: #1e40af;
    }

    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }
    </style>
@else
    <!-- Main Sidebar -->
    <div class="space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg mb-4 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 text-white' : '' }}">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            داشبورد
        </a>
        
        <!-- Cloud Resources Section -->
        <div class="mb-4">
            <h3 class="px-3 text-xs font-semibold uppercase tracking-wider mb-2 text-blue-200">منابع ابری</h3>
        </div>
        
        <!-- Compute Management -->
        <a href="{{ route('admin.compute.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.compute.*') ? 'bg-blue-700 text-white' : '' }}">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
            </svg>
            مدیریت محاسبات
        </a>
        
        <!-- Storage Management -->
        <a href="{{ route('admin.storage.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.storage.*') ? 'bg-blue-700 text-white' : '' }}">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            مدیریت ذخیره‌سازی
        </a>
        
        <!-- Network Management -->
        <a href="{{ route('admin.networks.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.networks.*') ? 'bg-blue-700 text-white' : '' }}">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
            </svg>
            مدیریت شبکه
        </a>
        
        <!-- Image Management -->
        <a href="{{ route('admin.images.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.images.*') ? 'bg-blue-700 text-white' : '' }}">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            مدیریت Image ها
        </a>
    </div>

    <!-- Divider -->
    <div class="my-6 border-t border-blue-700"></div>

    <!-- Management Section -->
    <div class="space-y-1">
        <div class="mb-4">
            <h3 class="px-3 text-xs font-semibold uppercase tracking-wider mb-2 text-blue-200">مدیریت سیستم</h3>
        </div>
        
        <!-- User Management -->
        <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-700 text-white' : '' }}">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            مدیریت کاربران
        </a>
        
        <!-- Project Management -->
        <a href="{{ route('admin.projects.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.projects.*') ? 'bg-blue-700 text-white' : '' }}">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            مدیریت پروژه‌ها
        </a>
        
        <!-- Billing System -->
        <a href="{{ route('admin.billing.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            سیستم صورتحساب
        </a>
        
        <!-- Monitoring -->
        <a href="{{ route('admin.logs-monitoring.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.logs-monitoring.*') ? 'bg-blue-700 text-white' : '' }}">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            نظارت و لاگ‌ها
        </a>
        
        <!-- Notifications -->
        <a href="{{ route('admin.notifications.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.notifications.*') ? 'bg-blue-700 text-white' : '' }}">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            اعلان‌ها
        </a>
    </div>

    <!-- Divider -->
    <div class="my-6 border-t border-blue-700"></div>

    <!-- Account Section -->
    <div class="space-y-1">
        <div class="mb-4">
            <h3 class="px-3 text-xs font-semibold uppercase tracking-wider mb-2 text-blue-200">حساب کاربری</h3>
        </div>
        
        <!-- Account Settings -->
        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            تنظیمات حساب
        </a>
        
        <!-- API Tokens -->
        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors">
            <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
            توکن‌های API
        </a>
    </div>
@endif

