@extends('layouts.admin')

@section('title', 'مدیریت Image ها')

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
    <a href="{{ route('admin.images.index') }}" class="flex items-center px-3 py-2 text-sm font-medium bg-blue-700 text-white rounded-lg ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        مدیریت Image ها
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
        <h1 class="text-3xl font-bold text-gray-900">مدیریت Image ها</h1>
        <p class="mt-1 text-sm text-gray-500">آپلود و مدیریت Image های Glance</p>
    </div>
    <button onclick="openUploadModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2 shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
        </svg>
        آپلود Image جدید
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">کل Image ها</p>
                <p class="text-2xl font-bold text-gray-900">156</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">Image های فعال</p>
                <p class="text-2xl font-bold text-gray-900">142</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">غیرفعال شده</p>
                <p class="text-2xl font-bold text-gray-900">8</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">Image های عمومی</p>
                <p class="text-2xl font-bold text-gray-900">98</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Search -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">جستجو</label>
            <div class="relative">
                <input type="text" placeholder="جستجو بر اساس نام، OS یا ID..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        
        <!-- Type Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">نوع</label>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه</option>
                <option value="os">OS Template</option>
                <option value="custom">Custom Image</option>
                <option value="snapshot">Snapshot</option>
            </select>
        </div>
        
        <!-- Status Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">وضعیت</label>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه وضعیت‌ها</option>
                <option value="active">فعال</option>
                <option value="disabled">غیرفعال</option>
                <option value="error">خطا</option>
            </select>
        </div>
    </div>
</div>

<!-- Images Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <!-- Image Card 1 - Ubuntu -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Ubuntu 22.04 LTS</h3>
                    <p class="text-xs text-gray-500">OS Template</p>
                </div>
            </div>
            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
        </div>
        <div class="space-y-2 text-sm mb-4">
            <div class="flex justify-between">
                <span class="text-gray-500">ID</span>
                <span class="font-medium text-gray-900">ubuntu-22.04-lts</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">حجم</span>
                <span class="font-medium text-gray-900">2.4 GB</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Format</span>
                <span class="font-medium text-gray-900">QCOW2</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">دسترسی</span>
                <span class="font-medium text-gray-900">عمومی</span>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.images.show', 'ubuntu-22.04-lts') }}" class="flex-1 text-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm font-medium transition-colors">
                ویرایش
            </a>
            <button onclick="toggleImageStatus('ubuntu-22.04-lts')" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium transition-colors">
                غیرفعال
            </button>
        </div>
    </div>

    <!-- Image Card 2 - CentOS -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">CentOS 8</h3>
                    <p class="text-xs text-gray-500">OS Template</p>
                </div>
            </div>
            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
        </div>
        <div class="space-y-2 text-sm mb-4">
            <div class="flex justify-between">
                <span class="text-gray-500">ID</span>
                <span class="font-medium text-gray-900">centos-8</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">حجم</span>
                <span class="font-medium text-gray-900">1.8 GB</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Format</span>
                <span class="font-medium text-gray-900">QCOW2</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">دسترسی</span>
                <span class="font-medium text-gray-900">عمومی</span>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.images.show', 'centos-8') }}" class="flex-1 text-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm font-medium transition-colors">
                ویرایش
            </a>
            <button onclick="toggleImageStatus('centos-8')" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium transition-colors">
                غیرفعال
            </button>
        </div>
    </div>

    <!-- Image Card 3 - Windows -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Windows Server 2022</h3>
                    <p class="text-xs text-gray-500">OS Template</p>
                </div>
            </div>
            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
        </div>
        <div class="space-y-2 text-sm mb-4">
            <div class="flex justify-between">
                <span class="text-gray-500">ID</span>
                <span class="font-medium text-gray-900">windows-server-2022</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">حجم</span>
                <span class="font-medium text-gray-900">8.5 GB</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Format</span>
                <span class="font-medium text-gray-900">VHD</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">دسترسی</span>
                <span class="font-medium text-gray-900">محدود</span>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.images.show', 'windows-server-2022') }}" class="flex-1 text-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm font-medium transition-colors">
                ویرایش
            </a>
            <button onclick="toggleImageStatus('windows-server-2022')" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium transition-colors">
                غیرفعال
            </button>
        </div>
    </div>

    <!-- Image Card 4 - Custom Image -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">custom-app-image</h3>
                    <p class="text-xs text-gray-500">Custom Image</p>
                </div>
            </div>
            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
        </div>
        <div class="space-y-2 text-sm mb-4">
            <div class="flex justify-between">
                <span class="text-gray-500">ID</span>
                <span class="font-medium text-gray-900">custom-app-001</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">حجم</span>
                <span class="font-medium text-gray-900">5.2 GB</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Format</span>
                <span class="font-medium text-gray-900">QCOW2</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">دسترسی</span>
                <span class="font-medium text-gray-900">خصوصی</span>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.images.show', 'custom-app-001') }}" class="flex-1 text-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm font-medium transition-colors">
                ویرایش
            </a>
            <button onclick="toggleImageStatus('custom-app-001')" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium transition-colors">
                غیرفعال
            </button>
        </div>
    </div>

    <!-- Image Card 5 - Disabled/Broken -->
    <div class="bg-white rounded-lg shadow-sm border border-red-200 p-6 hover:shadow-md transition-shadow bg-red-50">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">broken-image-v1</h3>
                    <p class="text-xs text-gray-500">Custom Image</p>
                </div>
            </div>
            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">غیرفعال</span>
        </div>
        <div class="space-y-2 text-sm mb-4">
            <div class="flex justify-between">
                <span class="text-gray-500">ID</span>
                <span class="font-medium text-gray-900">broken-img-001</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">حجم</span>
                <span class="font-medium text-gray-900">-</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Format</span>
                <span class="font-medium text-gray-900">QCOW2</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">وضعیت</span>
                <span class="font-medium text-red-600">خطا در آپلود</span>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.images.show', 'broken-img-001') }}" class="flex-1 text-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm font-medium transition-colors">
                ویرایش
            </a>
            <button onclick="deleteImage('broken-img-001')" class="px-3 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 text-sm font-medium transition-colors">
                حذف
            </button>
        </div>
    </div>

    <!-- Image Card 6 - Debian -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Debian 11</h3>
                    <p class="text-xs text-gray-500">OS Template</p>
                </div>
            </div>
            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
        </div>
        <div class="space-y-2 text-sm mb-4">
            <div class="flex justify-between">
                <span class="text-gray-500">ID</span>
                <span class="font-medium text-gray-900">debian-11</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">حجم</span>
                <span class="font-medium text-gray-900">1.5 GB</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Format</span>
                <span class="font-medium text-gray-900">QCOW2</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">دسترسی</span>
                <span class="font-medium text-gray-900">عمومی</span>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.images.show', 'debian-11') }}" class="flex-1 text-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm font-medium transition-colors">
                ویرایش
            </a>
            <button onclick="toggleImageStatus('debian-11')" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium transition-colors">
                غیرفعال
            </button>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3 flex items-center justify-between">
    <div class="flex-1 flex justify-between sm:hidden">
        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            قبلی
        </a>
        <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            بعدی
        </a>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-700">
                نمایش
                <span class="font-medium">1</span>
                تا
                <span class="font-medium">6</span>
                از
                <span class="font-medium">156</span>
                نتیجه
            </p>
        </div>
        <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">قبلی</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">1</a>
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">بعدی</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </nav>
        </div>
    </div>
</div>

<!-- Upload Image Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-3/4 shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">آپلود Image جدید</h3>
            <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام Image</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="ubuntu-22.04-lts" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نوع Image</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">انتخاب نوع</option>
                        <option value="os">OS Template</option>
                        <option value="custom">Custom Image</option>
                        <option value="snapshot">Snapshot</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">فایل Image</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>انتخاب فایل</span>
                                <input id="file-upload" name="file-upload" type="file" class="sr-only" accept=".qcow2,.vhd,.vmdk,.raw,.iso">
                            </label>
                            <p class="mr-1">یا فایل را اینجا بکشید</p>
                        </div>
                        <p class="text-xs text-gray-500">QCOW2, VHD, VMDK, RAW, ISO تا 10 GB</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">انتخاب Format</option>
                        <option value="qcow2">QCOW2</option>
                        <option value="vhd">VHD</option>
                        <option value="vmdk">VMDK</option>
                        <option value="raw">RAW</option>
                        <option value="iso">ISO</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">حداقل Disk (GB)</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="20" min="1">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">حداقل RAM (GB)</label>
                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="2" min="1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
                <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="توضیحات Image..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">دسترسی</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="visibility" value="public" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                        <span class="mr-2 block text-sm text-gray-700">عمومی (همه کاربران)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="visibility" value="private" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="mr-2 block text-sm text-gray-700">خصوصی (فقط پروژه‌های انتخاب شده)</span>
                    </label>
                </div>
            </div>
            <div id="projectSelection" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">پروژه‌های مجاز</label>
                <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3">
                    <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 text-sm text-gray-700">project-acme-corp</span>
                    </label>
                    <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 text-sm text-gray-700">project-techstart</span>
                    </label>
                    <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 text-sm text-gray-700">project-devsolutions</span>
                    </label>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeUploadModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    آپلود Image
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openUploadModal() {
    document.getElementById('uploadModal').classList.remove('hidden');
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.add('hidden');
}

function toggleImageStatus(imageId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید وضعیت این Image را تغییر دهید؟')) {
        // Toggle status logic here
        alert('وضعیت Image تغییر کرد');
    }
}

function deleteImage(imageId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Image را حذف کنید؟ این عمل غیرقابل بازگشت است.')) {
        // Delete logic here
        alert('Image حذف شد');
    }
}

// Show/hide project selection based on visibility
document.addEventListener('DOMContentLoaded', function() {
    const visibilityRadios = document.querySelectorAll('input[name="visibility"]');
    const projectSelection = document.getElementById('projectSelection');
    
    visibilityRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'private') {
                projectSelection.classList.remove('hidden');
            } else {
                projectSelection.classList.add('hidden');
            }
        });
    });
});
</script>
@endsection

