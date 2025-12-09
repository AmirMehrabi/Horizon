@extends('layouts.admin')

@section('title', 'جزئیات Instance')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
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
    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
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
    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-100 hover:bg-blue-700 hover:text-white rounded-lg transition-colors ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        نظارت
    </a>
    
    <!-- Compute Management -->
    <a href="{{ route('admin.compute.index') }}" class="flex items-center px-3 py-2 text-sm font-medium bg-blue-700 text-white rounded-lg ">
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
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.compute.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Instance ها
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 mr-1 md:mr-2">web-server-01</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">web-server-01</h1>
            <p class="mt-1 text-sm text-gray-500">Instance ID: abc123def456</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            <span class="w-2 h-2 rounded-full bg-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}"></span>
            در حال اجرا
        </span>
        <div class="relative">
            <button onclick="toggleActionsMenu()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium text-sm transition-colors flex items-center gap-2">
                عملیات
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="actionsMenu" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                <button onclick="openResizeModal()" class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">تغییر سایز</button>
                <button onclick="openMigrateModal()" class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">انتقال به هایپروایزر دیگر</button>
                <button onclick="openPasswordResetModal()" class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">بازنشانی رمز عبور</button>
                <div class="border-t border-gray-200 my-1"></div>
                <button onclick="forceShutdown()" class="block w-full text-right px-4 py-2 text-sm text-orange-700 hover:bg-orange-50">خاموش کردن اجباری</button>
                <button onclick="rebootInstance()" class="block w-full text-right px-4 py-2 text-sm text-blue-700 hover:bg-blue-50">راه‌اندازی مجدد</button>
                <div class="border-t border-gray-200 my-1"></div>
                <button onclick="deleteInstance()" class="block w-full text-right px-4 py-2 text-sm text-red-700 hover:bg-red-50">حذف Instance</button>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Overview Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">نمای کلی</h2>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">پروژه</p>
                    <p class="text-sm font-medium text-gray-900">project-acme-corp</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">مشتری</p>
                    <p class="text-sm font-medium text-gray-900">Acme Corporation</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Image</p>
                    <p class="text-sm font-medium text-gray-900">Ubuntu 22.04 LTS</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Flavor</p>
                    <p class="text-sm font-medium text-gray-900">s-2vcpu-4gb</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">هایپروایزر</p>
                    <p class="text-sm font-medium text-gray-900">hv-nyc-01 (NYC1)</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">تاریخ ایجاد</p>
                    <p class="text-sm font-medium text-gray-900">۱۴۰۳/۰۳/۱۵</p>
                </div>
            </div>
        </div>

        <!-- Networking Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">شبکه‌سازی</h2>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">IP عمومی</p>
                        <p class="text-sm text-gray-500 mt-1">45.67.89.123</p>
                    </div>
                    <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">کپی</button>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">IP خصوصی</p>
                        <p class="text-sm text-gray-500 mt-1">192.168.1.100</p>
                    </div>
                    <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">کپی</button>
                </div>
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500 mb-2">Network ها</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div>
                                <p class="text-sm font-medium text-gray-900">private-net</p>
                                <p class="text-xs text-gray-500">192.168.1.0/24</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">متصل</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Volumes Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">حجم‌ها</h2>
                <button onclick="openAttachVolumeModal()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">اتصال Volume</button>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">volume-boot-01</p>
                            <p class="text-xs text-gray-500">40 GB - Boot Disk</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">متصل</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">volume-data-01</p>
                            <p class="text-xs text-gray-500">100 GB - Data Disk</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">متصل</span>
                        <button onclick="detachVolume('volume-data-01')" class="text-red-600 hover:text-red-800 text-sm" title="جدا کردن">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logs Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">لاگ‌های Instance</h2>
                <button onclick="refreshLogs()" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    به‌روزرسانی
                </button>
            </div>
            <div class="bg-gray-900 rounded-lg p-4 font-mono text-sm text-green-400 max-h-96 overflow-y-auto">
                <div class="space-y-1">
                    <div>[2024-03-15 10:23:45] Instance started successfully</div>
                    <div>[2024-03-15 10:23:46] Network interface configured: eth0</div>
                    <div>[2024-03-15 10:23:47] Volume attached: volume-boot-01</div>
                    <div>[2024-03-15 10:23:48] SSH service started</div>
                    <div>[2024-03-15 10:23:50] System initialization complete</div>
                    <div>[2024-03-15 10:24:00] Health check passed</div>
                    <div>[2024-03-15 10:30:15] User login: root</div>
                    <div>[2024-03-15 11:45:22] Package update completed</div>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-4">
                <button onclick="downloadLogs()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">دانلود لاگ‌ها</button>
                <button onclick="clearLogs()" class="text-sm text-red-600 hover:text-red-800 font-medium">پاک کردن لاگ‌ها</button>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Resource Usage Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">استفاده از منابع</h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-500">vCPU</span>
                        <span class="font-medium text-gray-900">2 / 2</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-500">RAM</span>
                        <span class="font-medium text-gray-900">3.2 GB / 4 GB</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 80%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-500">Disk I/O</span>
                        <span class="font-medium text-gray-900">45 MB/s</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-600 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-500">Network I/O</span>
                        <span class="font-medium text-gray-900">12 MB/s</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 30%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">عملیات سریع</h2>
            <div class="space-y-2">
                <button onclick="openResizeModal()" class="w-full text-right px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg font-medium text-sm transition-colors flex items-center justify-between">
                    <span>تغییر سایز</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                    </svg>
                </button>
                <button onclick="openMigrateModal()" class="w-full text-right px-4 py-2.5 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg font-medium text-sm transition-colors flex items-center justify-between">
                    <span>انتقال</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </button>
                <button onclick="rebootInstance()" class="w-full text-right px-4 py-2.5 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 rounded-lg font-medium text-sm transition-colors flex items-center justify-between">
                    <span>راه‌اندازی مجدد</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
                <button onclick="openPasswordResetModal()" class="w-full text-right px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg font-medium text-sm transition-colors flex items-center justify-between">
                    <span>بازنشانی رمز عبور</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </button>
                <button onclick="forceShutdown()" class="w-full text-right px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-medium text-sm transition-colors flex items-center justify-between">
                    <span>خاموش کردن اجباری</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Metadata Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات تکمیلی</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Availability Zone</span>
                    <span class="font-medium text-gray-900">nova</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Key Pair</span>
                    <span class="font-medium text-gray-900">my-key</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Security Groups</span>
                    <span class="font-medium text-gray-900">default, web</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Uptime</span>
                    <span class="font-medium text-gray-900">15 روز</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Resize Modal -->
<div id="resizeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">تغییر سایز Instance</h3>
            <button onclick="closeResizeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">سایز فعلی</label>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-900">s-2vcpu-4gb (2 vCPU, 4 GB RAM)</p>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">سایز جدید</label>
                <div class="grid grid-cols-1 gap-3 max-h-64 overflow-y-auto">
                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500">
                        <input type="radio" name="newFlavor" value="s-1vcpu-2gb" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <div class="mr-3">
                            <p class="font-medium text-gray-900">s-1vcpu-2gb</p>
                            <p class="text-sm text-gray-500">1 vCPU, 2 GB RAM</p>
                        </div>
                    </label>
                    <label class="flex items-center p-4 border-2 border-blue-500 rounded-lg cursor-pointer bg-blue-50">
                        <input type="radio" name="newFlavor" value="s-2vcpu-4gb" class="h-4 w-4 text-blue-600 focus:ring-blue-500" checked>
                        <div class="mr-3">
                            <p class="font-medium text-gray-900">s-2vcpu-4gb</p>
                            <p class="text-sm text-gray-500">2 vCPU, 4 GB RAM (فعلی)</p>
                        </div>
                    </label>
                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500">
                        <input type="radio" name="newFlavor" value="s-4vcpu-8gb" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <div class="mr-3">
                            <p class="font-medium text-gray-900">s-4vcpu-8gb</p>
                            <p class="text-sm text-gray-500">4 vCPU, 8 GB RAM</p>
                        </div>
                    </label>
                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500">
                        <input type="radio" name="newFlavor" value="s-8vcpu-16gb" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <div class="mr-3">
                            <p class="font-medium text-gray-900">s-8vcpu-16gb</p>
                            <p class="text-sm text-gray-500">8 vCPU, 16 GB RAM</p>
                        </div>
                    </label>
                </div>
            </div>
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <strong>توجه:</strong> تغییر سایز نیاز به راه‌اندازی مجدد Instance دارد. تمام داده‌های در حافظه از دست خواهند رفت.
                </p>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeResizeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    تغییر سایز
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Migrate Modal -->
<div id="migrateModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">انتقال به هایپروایزر دیگر</h3>
            <button onclick="closeMigrateModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">هایپروایزر فعلی</label>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-900">hv-nyc-01 (NYC1)</p>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">هایپروایزر مقصد</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">انتخاب هایپروایزر</option>
                    <option value="hv-nyc-02">hv-nyc-02 (NYC1)</option>
                    <option value="hv-sfo-01">hv-sfo-01 (SFO3)</option>
                    <option value="hv-ams-01">hv-ams-01 (AMS3)</option>
                </select>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="mr-2 block text-sm text-gray-700">Live Migration (بدون توقف)</span>
                </label>
            </div>
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>نکته:</strong> Live Migration بدون توقف Instance انجام می‌شود. در صورت عدم پشتیبانی، Cold Migration انجام خواهد شد.
                </p>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeMigrateModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    انتقال
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Password Reset Modal -->
<div id="passwordModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">بازنشانی رمز عبور</h3>
            <button onclick="closePasswordModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">کاربر</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="root">root</option>
                    <option value="ubuntu">ubuntu</option>
                    <option value="admin">admin</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">رمز عبور جدید</label>
                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">تأیید رمز عبور</label>
                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <strong>هشدار:</strong> Instance برای اعمال تغییرات راه‌اندازی مجدد خواهد شد.
                </p>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closePasswordModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    بازنشانی رمز عبور
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Attach Volume Modal -->
<div id="attachVolumeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">اتصال Volume</h3>
            <button onclick="closeAttachVolumeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Volume</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">انتخاب Volume</option>
                    <option value="vol-001">volume-storage-01 (50 GB)</option>
                    <option value="vol-002">volume-backup-01 (200 GB)</option>
                    <option value="vol-003">volume-archive-01 (500 GB)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Device Name (اختیاری)</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="/dev/vdb">
                <p class="text-xs text-gray-500 mt-1">در صورت خالی بودن، به صورت خودکار اختصاص داده می‌شود</p>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAttachVolumeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    اتصال
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleActionsMenu() {
    document.getElementById('actionsMenu').classList.toggle('hidden');
}

function openResizeModal() {
    document.getElementById('resizeModal').classList.remove('hidden');
    document.getElementById('actionsMenu').classList.add('hidden');
}

function closeResizeModal() {
    document.getElementById('resizeModal').classList.add('hidden');
}

function openMigrateModal() {
    document.getElementById('migrateModal').classList.remove('hidden');
    document.getElementById('actionsMenu').classList.add('hidden');
}

function closeMigrateModal() {
    document.getElementById('migrateModal').classList.add('hidden');
}

function openPasswordResetModal() {
    document.getElementById('passwordModal').classList.remove('hidden');
    document.getElementById('actionsMenu').classList.add('hidden');
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
}

function openAttachVolumeModal() {
    document.getElementById('attachVolumeModal').classList.remove('hidden');
}

function closeAttachVolumeModal() {
    document.getElementById('attachVolumeModal').classList.add('hidden');
}

function detachVolume(volumeId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Volume را جدا کنید؟')) {
        // Detach logic here
        alert('Volume جدا شد');
    }
}

function forceShutdown() {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Instance را به صورت اجباری خاموش کنید؟')) {
        // Force shutdown logic here
        alert('Instance در حال خاموش شدن...');
    }
}

function rebootInstance() {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Instance را راه‌اندازی مجدد کنید؟')) {
        // Reboot logic here
        alert('Instance در حال راه‌اندازی مجدد...');
    }
}

function deleteInstance() {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Instance را حذف کنید؟ این عمل غیرقابل بازگشت است.')) {
        // Delete logic here
        window.location.href = "{{ route('admin.compute.index') }}";
    }
}

function refreshLogs() {
    // Refresh logs logic here
    alert('لاگ‌ها به‌روزرسانی شدند');
}

function downloadLogs() {
    // Download logs logic here
    alert('در حال دانلود لاگ‌ها...');
}

function clearLogs() {
    if (confirm('آیا مطمئن هستید که می‌خواهید لاگ‌ها را پاک کنید؟')) {
        // Clear logs logic here
        alert('لاگ‌ها پاک شدند');
    }
}

// Close menus when clicking outside
document.addEventListener('click', function(event) {
    const actionsMenu = document.getElementById('actionsMenu');
    if (actionsMenu && !event.target.closest('.relative')) {
        actionsMenu.classList.add('hidden');
    }
});
</script>
@endsection

