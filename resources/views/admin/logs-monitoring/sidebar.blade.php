@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

<div class="space-y-1">
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg mb-4">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        داشبورد
    </a>
    
    <!-- Projects Section -->
    <div class="mb-6">
        <h3 class="px-3 text-xs font-semibold uppercase tracking-wider mb-2 text-white">پروژه‌ها</h3>
    </div>
    
    <!-- Droplets -->
    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
        </svg>
        قطرات
    </a>
    
    <!-- Kubernetes -->
    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        کوبرنتیز
    </a>
    
    <!-- Databases -->
    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
        </svg>
        پایگاه‌های داده
    </a>
    
    <!-- Volumes -->
    <a href="{{ route('admin.storage.volumes') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
        حجم‌ها
    </a>
    
    <!-- Networking -->
    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
        </svg>
        شبکه‌سازی
    </a>
    
    <!-- Monitoring -->
    <a href="{{ route('admin.logs-monitoring.index') }}" class="flex items-center px-3 py-2 text-sm font-medium bg-blue-700 text-white rounded-lg ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        نظارت
    </a>
    
    <!-- Compute Management -->
    <a href="{{ route('admin.compute.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
        </svg>
        مدیریت محاسبات
    </a>
</div>

<!-- Divider -->
<div class="my-6 border-t border-blue-700"></div>

<!-- Management Section -->
<div class="space-y-1">
    <div class="mb-6">
        <h3 class="px-3 text-xs font-semibold uppercase tracking-wider mb-2 text-white">مدیریت</h3>
    </div>
    
    <!-- User Management -->
    <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        مدیریت کاربران
    </a>
    
    <!-- Project Management -->
    <a href="{{ route('admin.projects.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        مدیریت پروژه‌ها
    </a>
    
    <!-- Image Management -->
    <a href="{{ route('admin.images.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        مدیریت Image ها
    </a>
    
    <!-- Network Management -->
    <a href="{{ route('admin.networks.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
        </svg>
        مدیریت شبکه
    </a>
    
    <!-- Storage Management -->
    <a href="{{ route('admin.storage.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
        مدیریت ذخیره‌سازی
    </a>
</div>

<!-- Divider -->
<div class="my-6 border-t border-blue-700"></div>

<!-- Account Section -->
<div class="space-y-1">
    <!-- Billing -->
    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
        </svg>
        صورتحساب
    </a>
    
    <!-- Account -->
    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        حساب کاربری
    </a>
    
    <!-- API Tokens -->
    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
        </svg>
        توکن‌های API
    </a>
</div>

