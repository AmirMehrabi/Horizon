@extends('layouts.admin')

@section('title', 'مدیریت کاربران')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
<div class="space-y-1">
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
</div>

<!-- Divider -->
<div class="my-6 border-t border-blue-700"></div>

<!-- Management Section -->
<div class="space-y-1">
    <div class="mb-6">
        <h3 class="px-3 text-xs font-semibold uppercase tracking-wider mb-2 text-white">مدیریت</h3>
    </div>
    
    <!-- User Management -->
    <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-sm font-medium bg-blue-700 text-white rounded-lg ">
        <svg class="w-5 h-5 {{ $isRtl ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        مدیریت کاربران
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
        <h1 class="text-3xl font-bold text-gray-900">مدیریت کاربران</h1>
        <p class="mt-1 text-sm text-gray-500">ایجاد، ویرایش و مدیریت کاربران سیستم</p>
    </div>
    <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2 shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        ایجاد کاربر جدید
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">کل کاربران</p>
                <p class="text-2xl font-bold text-gray-900">1,247</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">کاربران فعال</p>
                <p class="text-2xl font-bold text-gray-900">1,198</p>
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
                <p class="text-sm text-gray-500 font-medium mb-1">کاربران تعلیق شده</p>
                <p class="text-2xl font-bold text-gray-900">32</p>
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
                <p class="text-sm text-gray-500 font-medium mb-1">کاربران امروز</p>
                <p class="text-2xl font-bold text-gray-900">47</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
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
                <input type="text" placeholder="جستجو بر اساس نام، ایمیل یا شماره تلفن..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        
        <!-- Role Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">نقش</label>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه نقش‌ها</option>
                <option value="admin">مدیر</option>
                <option value="support">پشتیبانی</option>
                <option value="billing">صورتحساب</option>
                <option value="customer">مشتری</option>
            </select>
        </div>
        
        <!-- Status Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">وضعیت</label>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه وضعیت‌ها</option>
                <option value="active">فعال</option>
                <option value="suspended">تعلیق شده</option>
                <option value="inactive">غیرفعال</option>
            </select>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">کاربر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ایمیل</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نقش</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">آخرین فعالیت</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- User Row 1 -->
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold text-sm">
                                JD
                            </div>
                            <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                                <div class="text-sm font-medium text-gray-900">جان دو</div>
                                <div class="text-sm text-gray-500">+98 912 345 6789</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">john.doe@example.com</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">مدیر</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ۲ ساعت پیش
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <button onclick="openEditModal(1)" class="text-blue-600 hover:text-blue-900" title="ویرایش">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="openActivityLogModal(1)" class="text-indigo-600 hover:text-indigo-900" title="لاگ فعالیت">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </button>
                            <button onclick="impersonateUser(1)" class="text-orange-600 hover:text-orange-900" title="جعل هویت">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </button>
                            <button onclick="suspendUser(1)" class="text-red-600 hover:text-red-900" title="تعلیق">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                            </button>
                            <button onclick="deleteUser(1)" class="text-gray-600 hover:text-gray-900" title="حذف">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- User Row 2 -->
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center font-semibold text-sm">
                                SM
                            </div>
                            <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                                <div class="text-sm font-medium text-gray-900">سارا میلر</div>
                                <div class="text-sm text-gray-500">+98 912 345 6788</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">sarah.miller@example.com</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">پشتیبانی</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ۵ ساعت پیش
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <button onclick="openEditModal(2)" class="text-blue-600 hover:text-blue-900" title="ویرایش">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="openActivityLogModal(2)" class="text-indigo-600 hover:text-indigo-900" title="لاگ فعالیت">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </button>
                            <button onclick="impersonateUser(2)" class="text-orange-600 hover:text-orange-900" title="جعل هویت">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </button>
                            <button onclick="suspendUser(2)" class="text-red-600 hover:text-red-900" title="تعلیق">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                            </button>
                            <button onclick="deleteUser(2)" class="text-gray-600 hover:text-gray-900" title="حذف">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- User Row 3 - Suspended -->
                <tr class="hover:bg-gray-50 transition-colors bg-red-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-400 text-white flex items-center justify-center font-semibold text-sm">
                                RJ
                            </div>
                            <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                                <div class="text-sm font-medium text-gray-900">رابرت جانسون</div>
                                <div class="text-sm text-gray-500">+98 912 345 6787</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">robert.johnson@example.com</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">صورتحساب</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">تعلیق شده</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ۳ روز پیش
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <button onclick="openEditModal(3)" class="text-blue-600 hover:text-blue-900" title="ویرایش">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="openActivityLogModal(3)" class="text-indigo-600 hover:text-indigo-900" title="لاگ فعالیت">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </button>
                            <button onclick="reactivateUser(3)" class="text-green-600 hover:text-green-900" title="فعال‌سازی مجدد">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                            <button onclick="deleteUser(3)" class="text-gray-600 hover:text-gray-900" title="حذف">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
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
                    <span class="font-medium">10</span>
                    از
                    <span class="font-medium">1,247</span>
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
</div>

<!-- Create/Edit User Modal -->
<div id="userModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900" id="modalTitle">ایجاد کاربر جدید</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">نام</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">نام خانوادگی</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ایمیل</label>
                <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">شماره تلفن</label>
                <input type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">نقش</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">انتخاب نقش</option>
                    <option value="admin">مدیر</option>
                    <option value="support">پشتیبانی</option>
                    <option value="billing">صورتحساب</option>
                    <option value="customer">مشتری</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">رمز عبور</label>
                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label class="mr-2 block text-sm text-gray-700">ارسال ایمیل خوش‌آمدگویی</label>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    ذخیره
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Activity Log Modal -->
<div id="activityLogModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[80vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">لاگ فعالیت کاربر</h3>
            <button onclick="closeActivityLogModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="space-y-4">
            <div class="border-l-4 border-blue-500 pl-4 py-2">
                <p class="text-sm font-medium text-gray-900">ورود به سیستم</p>
                <p class="text-xs text-gray-500">۲ ساعت پیش - IP: 192.168.1.1</p>
            </div>
            <div class="border-l-4 border-green-500 pl-4 py-2">
                <p class="text-sm font-medium text-gray-900">ایجاد VM جدید</p>
                <p class="text-xs text-gray-500">۵ ساعت پیش</p>
            </div>
            <div class="border-l-4 border-yellow-500 pl-4 py-2">
                <p class="text-sm font-medium text-gray-900">تغییر رمز عبور</p>
                <p class="text-xs text-gray-500">۱ روز پیش</p>
            </div>
            <div class="border-l-4 border-purple-500 pl-4 py-2">
                <p class="text-sm font-medium text-gray-900">به‌روزرسانی پروفایل</p>
                <p class="text-xs text-gray-500">۳ روز پیش</p>
            </div>
        </div>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('userModal').classList.remove('hidden');
    document.getElementById('modalTitle').textContent = 'ایجاد کاربر جدید';
}

function openEditModal(userId) {
    document.getElementById('userModal').classList.remove('hidden');
    document.getElementById('modalTitle').textContent = 'ویرایش کاربر';
    // Load user data here
}

function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
}

function openActivityLogModal(userId) {
    document.getElementById('activityLogModal').classList.remove('hidden');
}

function closeActivityLogModal() {
    document.getElementById('activityLogModal').classList.add('hidden');
}

function impersonateUser(userId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید به عنوان این کاربر وارد شوید؟')) {
        // Impersonate logic here
        alert('در حال ورود به عنوان کاربر...');
    }
}

function suspendUser(userId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این کاربر را تعلیق کنید؟')) {
        // Suspend logic here
        alert('کاربر تعلیق شد');
    }
}

function reactivateUser(userId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این کاربر را فعال کنید؟')) {
        // Reactivate logic here
        alert('کاربر فعال شد');
    }
}

function deleteUser(userId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این کاربر را حذف کنید؟ این عمل غیرقابل بازگشت است.')) {
        // Delete logic here
        alert('کاربر حذف شد');
    }
}
</script>
@endsection

