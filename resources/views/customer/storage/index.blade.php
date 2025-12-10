@extends('layouts.customer')

@section('title', 'فضای ذخیره‌سازی')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('header_content')
    @include('customer.partials.breadcrumb', [
        'items' => [
            [
                'label' => 'داشبورد',
                'url' => route('customer.dashboard'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>'
            ],
            [
                'label' => 'فضای ذخیره‌سازی',
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
<!-- Page Header -->
<div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
    <h1 class="text-3xl font-bold text-gray-900">فضای ذخیره‌سازی</h1>
                <p class="mt-1 text-sm text-gray-500">مدیریت حجم‌های ذخیره‌سازی و اسنپ‌شات‌های شما</p>
            </div>
            <button onclick="openCreateVolumeModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                ایجاد حجم جدید
            </button>
        </div>
    </div>

    <!-- Storage Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Storage -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">کل فضای ذخیره‌سازی</p>
                    <p class="text-2xl font-semibold text-gray-900">۲۸۰ GB</p>
                </div>
            </div>
        </div>

        <!-- Active Volumes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">حجم‌های فعال</p>
                    <p class="text-2xl font-semibold text-gray-900">۵</p>
                </div>
            </div>
        </div>

        <!-- Snapshots -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">اسنپ‌شات‌ها</p>
                    <p class="text-2xl font-semibold text-gray-900">۸</p>
                </div>
            </div>
        </div>

        <!-- Monthly Cost -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">هزینه ماهانه</p>
                    <p class="text-2xl font-semibold text-gray-900">۴۲۰,۰۰۰ تومان</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Storage Usage Chart -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">مصرف فضای ذخیره‌سازی</h2>
            <div class="flex items-center gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-gray-600">استفاده شده</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                    <span class="text-gray-600">خالی</span>
                </div>
            </div>
        </div>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">مصرف کل:</span>
                <span class="text-sm font-medium text-gray-900">۲۸۰ GB از ۵۰۰ GB</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-4 rounded-full" style="width: 56%"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">حجم‌های متصل:</span>
                    <span class="font-medium text-gray-900">۲۱۰ GB</span>
                </div>
                <div>
                    <span class="text-gray-600">اسنپ‌شات‌ها:</span>
                    <span class="font-medium text-gray-900">۷۰ GB</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <!-- Search -->
                <div class="relative">
                    <input type="text" placeholder="جستجو در حجم‌ها..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                
                <!-- Status Filter -->
                <select class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="available">در دسترس</option>
                    <option value="in-use">در حال استفاده</option>
                    <option value="creating">در حال ایجاد</option>
                    <option value="deleting">در حال حذف</option>
                </select>

                <!-- Type Filter -->
                <select class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">همه انواع</option>
                    <option value="ssd">SSD</option>
                    <option value="hdd">HDD</option>
                    <option value="nvme">NVMe</option>
                </select>
            </div>

            <!-- View Options -->
            <div class="flex items-center gap-2">
                <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg" title="نمایش جدولی">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </button>
                <button class="p-2 text-blue-600 bg-blue-50 rounded-lg" title="نمایش کارتی">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Volumes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Volume 1 - Attached -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">database-storage</h3>
                        <p class="text-sm text-gray-500">۱۰۰ GB • SSD</p>
                    </div>
                </div>
                <div class="relative">
                    <button onclick="toggleVolumeMenu('volume-1')" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                    <div id="volume-1-menu" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                        <button class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">جدا کردن</button>
                        <button class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">تغییر اندازه</button>
                        <button class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">ایجاد اسنپ‌شات</button>
                        <div class="border-t border-gray-200 my-1"></div>
                        <button class="block w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50">حذف</button>
                    </div>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        متصل
                    </span>
                    <span class="text-sm text-gray-500">به وب سرور اصلی</span>
                </div>
                
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">استفاده:</span>
                        <span class="font-medium">۷۵ GB از ۱۰۰ GB</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
                
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">هزینه ماهانه:</span>
                    <span class="font-medium text-gray-900">۲۰۰,۰۰۰ تومان</span>
                </div>
                
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">ایجاد شده:</span>
                    <span class="text-gray-500">۱۴۰۳/۰۹/۱۵</span>
                </div>
            </div>
        </div>

        <!-- Volume 2 - Available -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">backup-storage</h3>
                        <p class="text-sm text-gray-500">۵۰ GB • HDD</p>
                    </div>
                </div>
                <div class="relative">
                    <button onclick="toggleVolumeMenu('volume-2')" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                    <div id="volume-2-menu" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                        <button class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">متصل کردن</button>
                        <button class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">تغییر اندازه</button>
                        <button class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">ایجاد اسنپ‌شات</button>
                        <div class="border-t border-gray-200 my-1"></div>
                        <button class="block w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50">حذف</button>
                    </div>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        در دسترس
                    </span>
                    <button onclick="attachVolume('volume-2')" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        متصل کردن
                    </button>
                </div>
                
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">استفاده:</span>
                        <span class="font-medium">۰ GB از ۵۰ GB</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gray-300 h-2 rounded-full" style="width: 0%"></div>
                    </div>
                </div>
                
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">هزینه ماهانه:</span>
                    <span class="font-medium text-gray-900">۷۵,۰۰۰ تومان</span>
                </div>
                
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">ایجاد شده:</span>
                    <span class="text-gray-500">۱۴۰۳/۰۹/۲۰</span>
                </div>
            </div>
        </div>

        <!-- Volume 3 - Creating -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">logs-storage</h3>
                        <p class="text-sm text-gray-500">۳۰ GB • NVMe</p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        در حال ایجاد
                    </span>
                    <span class="text-sm text-gray-500">۸۵%</span>
                </div>
                
                <div class="space-y-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full transition-all duration-300" style="width: 85%"></div>
                    </div>
                    <p class="text-sm text-gray-600">تخمین زمان باقی‌مانده: ۲ دقیقه</p>
                </div>
                
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">هزینه ماهانه:</span>
                    <span class="font-medium text-gray-900">۱۲۰,۰۰۰ تومان</span>
                </div>
                
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">شروع ایجاد:</span>
                    <span class="text-gray-500">۱۴۰۳/۰۹/۲۵</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Snapshots Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">اسنپ‌شات‌های اخیر</h2>
            <a href="{{ route('customer.storage.snapshots') }}" class="text-sm text-blue-600 hover:text-blue-700">مشاهده همه</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نام</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">حجم مبدأ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اندازه</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ ایجاد</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">database-backup-daily</div>
                                    <div class="text-sm text-gray-500">پشتیبان‌گیری روزانه</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">database-storage</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۲۵ GB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۹/۲۵</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <button class="text-blue-600 hover:text-blue-900">بازگردانی</button>
                                <button class="text-red-600 hover:text-red-900">حذف</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">web-files-backup</div>
                                    <div class="text-sm text-gray-500">پشتیبان فایل‌های وب</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">web-storage</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۱۵ GB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۹/۲۳</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <button class="text-blue-600 hover:text-blue-900">بازگردانی</button>
                                <button class="text-red-600 hover:text-red-900">حذف</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Volume Modal -->
<div id="createVolumeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">ایجاد حجم جدید</h3>
            </div>
            
            <form class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام حجم</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="my-storage-volume">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اندازه (GB)</label>
                    <input type="number" min="10" max="1000" value="50" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نوع ذخیره‌سازی</label>
                    <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="ssd">SSD (سریع)</option>
                        <option value="hdd">HDD (اقتصادی)</option>
                        <option value="nvme">NVMe (فوق سریع)</option>
                    </select>
                </div>
                
                <div class="p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-700">
                        <span class="font-medium">هزینه تخمینی:</span>
                        <span class="text-lg font-bold text-blue-600">۱۰۰,۰۰۰ تومان/ماه</span>
                    </p>
                </div>
            </form>
            
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeCreateVolumeModal()" class="px-4 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">
                    انصراف
                </button>
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    ایجاد حجم
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Attach Volume Modal -->
<div id="attachVolumeModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">متصل کردن حجم</h3>
            </div>
            
            <form class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">انتخاب سرور</label>
                    <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">انتخاب سرور...</option>
                        <option value="server-1">وب سرور اصلی</option>
                        <option value="server-2">پایگاه داده</option>
                        <option value="server-3">سرور فایل</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نقطه اتصال</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="/mnt/storage" value="/mnt/storage">
                    <p class="text-xs text-gray-500 mt-1">مسیری که حجم در آن متصل خواهد شد</p>
                </div>
                
                <div class="p-4 bg-yellow-50 rounded-lg">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <p class="text-sm text-yellow-800">حجم پس از اتصال باید در سرور mount شود.</p>
                    </div>
                </div>
            </form>
            
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeAttachVolumeModal()" class="px-4 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">
                    انصراف
                </button>
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    متصل کردن
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Modal functions
function openCreateVolumeModal() {
    document.getElementById('createVolumeModal').classList.remove('hidden');
}

function closeCreateVolumeModal() {
    document.getElementById('createVolumeModal').classList.add('hidden');
}

function attachVolume(volumeId) {
    document.getElementById('attachVolumeModal').classList.remove('hidden');
}

function closeAttachVolumeModal() {
    document.getElementById('attachVolumeModal').classList.add('hidden');
}

// Volume menu toggle
function toggleVolumeMenu(volumeId) {
    const menu = document.getElementById(volumeId + '-menu');
    const allMenus = document.querySelectorAll('[id$="-menu"]');
    
    // Close all other menus
    allMenus.forEach(m => {
        if (m.id !== volumeId + '-menu') {
            m.classList.add('hidden');
        }
    });
    
    // Toggle current menu
    menu.classList.toggle('hidden');
}

// Close menus when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick*="toggleVolumeMenu"]') && !event.target.closest('[id$="-menu"]')) {
        document.querySelectorAll('[id$="-menu"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});

// Close modals when clicking outside
document.getElementById('createVolumeModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeCreateVolumeModal();
    }
});

document.getElementById('attachVolumeModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeAttachVolumeModal();
    }
});
</script>
@endsection