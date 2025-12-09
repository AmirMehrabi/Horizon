@extends('layouts.admin')

@section('title', 'داشبورد')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
<div class="space-y-1">
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium bg-blue-700 text-white rounded-lg mb-4">
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
    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium bg-blue-700 text-white rounded-lg ">
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
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">داشبورد</h1>
        <p class="mt-1 text-sm text-gray-500">نمای کلی سطح بالا برای اپراتورهای ابری</p>
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2 shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        ایجاد
    </button>
</div>

<!-- Dashboard Content -->
<div class="space-y-6">
    <!-- Overview Stats: VMs, Networks, Volumes -->
    <div>
        <h2 class="text-lg font-semibold text-gray-900 mb-4">نمای کلی زیرساخت</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Active VMs Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">ماشین‌های مجازی فعال</p>
                            <p class="text-2xl font-bold text-gray-900">1,247</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 {{ $isRtl ? 'ml-1.5' : 'mr-1.5' }}"></span>
                        فعال
                    </span>
                </div>
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">در حال اجرا</span>
                        <span class="font-semibold text-gray-900">1,198</span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-1">
                        <span class="text-gray-500">متوقف شده</span>
                        <span class="font-semibold text-gray-900">49</span>
                    </div>
                </div>
            </div>

            <!-- Active Networks Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">شبکه‌های فعال</p>
                            <p class="text-2xl font-bold text-gray-900">342</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 {{ $isRtl ? 'ml-1.5' : 'mr-1.5' }}"></span>
                        فعال
                    </span>
                </div>
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">خصوصی</span>
                        <span class="font-semibold text-gray-900">298</span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-1">
                        <span class="text-gray-500">عمومی</span>
                        <span class="font-semibold text-gray-900">44</span>
                    </div>
                </div>
            </div>

            <!-- Active Volumes Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">حجم‌های فعال</p>
                            <p class="text-2xl font-bold text-gray-900">856</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 {{ $isRtl ? 'ml-1.5' : 'mr-1.5' }}"></span>
                        فعال
                    </span>
                </div>
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">متصل شده</span>
                        <span class="font-semibold text-gray-900">812</span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-1">
                        <span class="text-gray-500">غیر متصل</span>
                        <span class="font-semibold text-gray-900">44</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hypervisor Status & Resource Capacity Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Hypervisor Status -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">وضعیت هایپروایزر</h2>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">مشاهده همه</a>
            </div>
            <div class="space-y-4">
                <!-- Online Hypervisors -->
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">آنلاین</p>
                            <p class="text-xs text-gray-500">هایپروایزرهای عملیاتی</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-green-600">24</p>
                        <p class="text-xs text-gray-500">۹۶٪ زمان فعالیت</p>
                    </div>
                </div>

                <!-- Offline Hypervisors -->
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">آفلاین</p>
                            <p class="text-xs text-gray-500">نیاز به توجه دارد</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-red-600">1</p>
                        <p class="text-xs text-gray-500">۴٪ زمان توقف</p>
                    </div>
                </div>

                <!-- Hypervisor List -->
                <div class="pt-4 border-t border-gray-100">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <span class="text-sm text-gray-900 font-medium">hv-nyc-01</span>
                            </div>
                            <span class="text-xs text-gray-500">NYC1</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <span class="text-sm text-gray-900 font-medium">hv-nyc-02</span>
                            </div>
                            <span class="text-xs text-gray-500">NYC1</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                <span class="text-sm text-gray-900 font-medium">hv-sfo-03</span>
                            </div>
                            <span class="text-xs text-gray-500">SFO3</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <span class="text-sm text-gray-900 font-medium">hv-ams-01</span>
                            </div>
                            <span class="text-xs text-gray-500">AMS3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resource Capacity -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">ظرفیت منابع</h2>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">مشاهده جزئیات</a>
            </div>
            <div class="space-y-6">
                <!-- vCPU Capacity -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900">vCPU</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">8,456 / 10,000</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 84.56%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">۸۴.۶٪ استفاده شده</p>
                </div>

                <!-- RAM Capacity -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900">RAM</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">32.4 TB / 40 TB</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-purple-600 h-2.5 rounded-full" style="width: 81%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">۸۱٪ استفاده شده</p>
                </div>

                <!-- Storage Capacity -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900">ذخیره‌سازی</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">245 PB / 300 PB</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-orange-600 h-2.5 rounded-full" style="width: 81.67%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">۸۱.۷٪ استفاده شده</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Metrics & New Signups Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Metrics -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">معیارهای درآمد</h2>
                <select class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>۳۰ روز گذشته</option>
                    <option>۷ روز گذشته</option>
                    <option>۹۰ روز گذشته</option>
                </select>
            </div>
            <div class="space-y-6">
                <!-- Total Revenue -->
                <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600 font-medium">درآمد کل</span>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full font-medium">+12.5%</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">$2,847,392</p>
                    <p class="text-xs text-gray-500 mt-1">در مقابل $۲,۵۳۰,۱۸۴ دوره قبلی</p>
                </div>

                <!-- Revenue Breakdown -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">ماهانه تکراری</p>
                        <p class="text-lg font-bold text-gray-900">$1,924,580</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">یکباره</p>
                        <p class="text-lg font-bold text-gray-900">$623,450</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">افزونه‌ها</p>
                        <p class="text-lg font-bold text-gray-900">$299,362</p>
                    </div>
                </div>

                <!-- Revenue Chart Placeholder -->
                <div class="h-32 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center">
                    <p class="text-sm text-gray-400">نمودار روند درآمد</p>
                </div>
            </div>
        </div>

        <!-- New Signups -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">ثبت‌نام‌های جدید</h2>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">مشاهده همه</a>
            </div>
            <div class="space-y-4">
                <!-- Today's Signups -->
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">امروز</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">47</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- This Week -->
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">این هفته</p>
                            <p class="text-xs text-gray-500">دوشنبه - یکشنبه</p>
                        </div>
                    </div>
                    <p class="text-lg font-bold text-gray-900">312</p>
                </div>

                <!-- This Month -->
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">این ماه</p>
                            <p class="text-xs text-gray-500">ماه جاری</p>
                        </div>
                    </div>
                    <p class="text-lg font-bold text-gray-900">1,247</p>
                </div>

                <!-- Recent Signups List -->
                <div class="pt-4 border-t border-gray-100">
                    <p class="text-sm font-semibold text-gray-900 mb-3">ثبت‌نام‌های اخیر</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-blue-600 text-white text-xs flex items-center justify-center font-medium">JD</div>
                                <span class="text-gray-900">John Doe</span>
                            </div>
                            <span class="text-xs text-gray-500">۲ ساعت پیش</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-green-600 text-white text-xs flex items-center justify-center font-medium">SM</div>
                                <span class="text-gray-900">Sarah Miller</span>
                            </div>
                            <span class="text-xs text-gray-500">۵ ساعت پیش</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-purple-600 text-white text-xs flex items-center justify-center font-medium">RJ</div>
                                <span class="text-gray-900">Robert Johnson</span>
                            </div>
                            <span class="text-xs text-gray-500">۱ روز پیش</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Support Tickets & Alerts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pending Support Tickets -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <h2 class="text-lg font-semibold text-gray-900">تیکت‌های پشتیبانی در انتظار</h2>
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-100 text-red-800 text-xs font-bold">8</span>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">مشاهده همه</a>
            </div>
            <div class="space-y-3">
                <!-- High Priority Ticket -->
                <div class="p-4 border border-red-200 bg-red-50 rounded-lg hover:bg-red-100 transition-colors cursor-pointer">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2 py-0.5 bg-red-600 text-white text-xs font-semibold rounded">بالا</span>
                                <span class="text-sm font-semibold text-gray-900">#TKT-4829</span>
                            </div>
                            <p class="text-sm text-gray-700 font-medium">خطا در ساخت ماشین مجازی - فوری</p>
                            <p class="text-xs text-gray-500 mt-1">مشتری: Acme Corp</p>
                        </div>
                        <span class="text-xs text-gray-500 whitespace-nowrap {{ $isRtl ? 'mr-2' : 'ml-2' }}">۲ ساعت پیش</span>
                    </div>
                </div>

                <!-- Medium Priority Ticket -->
                <div class="p-4 border border-orange-200 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors cursor-pointer">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2 py-0.5 bg-orange-600 text-white text-xs font-semibold rounded">متوسط</span>
                                <span class="text-sm font-semibold text-gray-900">#TKT-4828</span>
                            </div>
                            <p class="text-sm text-gray-700 font-medium">مشکلات اتصال شبکه</p>
                            <p class="text-xs text-gray-500 mt-1">مشتری: TechStart Inc</p>
                        </div>
                        <span class="text-xs text-gray-500 whitespace-nowrap {{ $isRtl ? 'mr-2' : 'ml-2' }}">۵ ساعت پیش</span>
                    </div>
                </div>

                <!-- Low Priority Ticket -->
                <div class="p-4 border border-gray-200 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2 py-0.5 bg-gray-600 text-white text-xs font-semibold rounded">پایین</span>
                                <span class="text-sm font-semibold text-gray-900">#TKT-4827</span>
                            </div>
                            <p class="text-sm text-gray-700 font-medium">استعلام صورتحساب</p>
                            <p class="text-xs text-gray-500 mt-1">مشتری: DevSolutions</p>
                        </div>
                        <span class="text-xs text-gray-500 whitespace-nowrap {{ $isRtl ? 'mr-2' : 'ml-2' }}">۱ روز پیش</span>
                    </div>
                </div>

                <!-- More Tickets Indicator -->
                <div class="pt-3 border-t border-gray-100">
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">+۵ تیکت دیگر</a>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <h2 class="text-lg font-semibold text-gray-900">هشدارهای سیستم</h2>
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100 text-yellow-800 text-xs font-bold">5</span>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">مشاهده همه</a>
            </div>
            <div class="space-y-3">
                <!-- Quota Full Alert -->
                <div class="p-4 border border-yellow-200 bg-yellow-50 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900 mb-1">سهمیه پر شده</p>
                            <p class="text-xs text-gray-600">مشتری "Enterprise Solutions" به حد سهمیه ذخیره‌سازی (۱۰ ترابایت) رسیده است</p>
                            <p class="text-xs text-gray-500 mt-1">۲ ساعت پیش</p>
                        </div>
                    </div>
                </div>

                <!-- Error Alert -->
                <div class="p-4 border border-red-200 bg-red-50 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900 mb-1">خطای سیستم</p>
                            <p class="text-xs text-gray-600">هایپروایزر hv-sfo-03 در حال تجربه مشکلات اتصال است</p>
                            <p class="text-xs text-gray-500 mt-1">۴ ساعت پیش</p>
                        </div>
                    </div>
                </div>

                <!-- Failed Build Alert -->
                <div class="p-4 border border-orange-200 bg-orange-50 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900 mb-1">ساخت ناموفق</p>
                            <p class="text-xs text-gray-600">۳ ساخت ماشین مجازی در ساعت گذشته ناموفق بود - منابع ناکافی</p>
                            <p class="text-xs text-gray-500 mt-1">۱ ساعت پیش</p>
                        </div>
                    </div>
                </div>

                <!-- Warning Alert -->
                <div class="p-4 border border-blue-200 bg-blue-50 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900 mb-1">هشدار ظرفیت</p>
                            <p class="text-xs text-gray-600">استفاده از vCPU به آستانه ۸۵٪ نزدیک می‌شود</p>
                            <p class="text-xs text-gray-500 mt-1">۶ ساعت پیش</p>
                        </div>
                    </div>
                </div>

                <!-- More Alerts Indicator -->
                <div class="pt-3 border-t border-gray-100">
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">+۱ هشدار دیگر</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection