@extends('layouts.admin')

@section('title', 'جزئیات Image')

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
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.images.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Image ها
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 mr-1 md:mr-2">Ubuntu 22.04 LTS</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-lg bg-orange-100 flex items-center justify-center">
            <svg class="w-9 h-9 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Ubuntu 22.04 LTS</h1>
            <p class="mt-1 text-sm text-gray-500">Image ID: ubuntu-22.04-lts</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            <span class="w-2 h-2 rounded-full bg-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}"></span>
            فعال
        </span>
        <button onclick="toggleImageStatus()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium text-sm transition-colors">
            غیرفعال کردن
        </button>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Image Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">جزئیات Image</h2>
            <form class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نام Image</label>
                        <input type="text" value="Ubuntu 22.04 LTS" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نوع</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="os" selected>OS Template</option>
                            <option value="custom">Custom Image</option>
                            <option value="snapshot">Snapshot</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
                    <textarea rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">Ubuntu 22.04 LTS (Jammy Jellyfish) - Long Term Support release with security updates until 2027.</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">حجم (GB)</label>
                        <input type="text" value="2.4" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                        <input type="text" value="QCOW2" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">حداقل Disk (GB)</label>
                        <input type="number" value="20" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">حداقل RAM (GB)</label>
                        <input type="number" value="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Architecture</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="x86_64" selected>x86_64</option>
                            <option value="aarch64">ARM64</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        انصراف
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        ذخیره تغییرات
                    </button>
                </div>
            </form>
        </div>

        <!-- Access Control Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">کنترل دسترسی</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">دسترسی Image</label>
                    <div class="space-y-2">
                        <label class="flex items-center p-3 border-2 border-blue-500 rounded-lg bg-blue-50 cursor-pointer">
                            <input type="radio" name="access" value="public" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                            <div class="mr-3">
                                <p class="text-sm font-medium text-gray-900">عمومی</p>
                                <p class="text-xs text-gray-500">همه کاربران و پروژه‌ها می‌توانند از این Image استفاده کنند</p>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer">
                            <input type="radio" name="access" value="private" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <div class="mr-3">
                                <p class="text-sm font-medium text-gray-900">خصوصی</p>
                                <p class="text-xs text-gray-500">فقط پروژه‌های انتخاب شده می‌توانند از این Image استفاده کنند</p>
                            </div>
                        </label>
                    </div>
                </div>
                <div id="projectAccessList" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-3">پروژه‌های مجاز</label>
                    <div class="space-y-2 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-3">
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                            <div class="mr-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">project-acme-corp</p>
                                <p class="text-xs text-gray-500">Acme Corporation</p>
                            </div>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <div class="mr-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">project-techstart</p>
                                <p class="text-xs text-gray-500">TechStart Inc</p>
                            </div>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                            <div class="mr-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">project-devsolutions</p>
                                <p class="text-xs text-gray-500">DevSolutions</p>
                            </div>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <div class="mr-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">project-enterprise</p>
                                <p class="text-xs text-gray-500">Enterprise Solutions</p>
                            </div>
                        </label>
                    </div>
                    <button type="button" class="mt-3 text-sm text-blue-600 hover:text-blue-800 font-medium">+ افزودن پروژه</button>
                </div>
            </div>
        </div>

        <!-- Usage Statistics Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">آمار استفاده</h2>
            <div class="grid grid-cols-2 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">247</p>
                    <p class="text-sm text-gray-500 mt-1">Instance های فعال</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">1,523</p>
                    <p class="text-sm text-gray-500 mt-1">کل Instance های ایجاد شده</p>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-sm font-medium text-gray-700 mb-3">استفاده بر اساس پروژه</p>
                <div class="space-y-2">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">project-acme-corp</p>
                            <p class="text-xs text-gray-500">Acme Corporation</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900">89 Instance</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">project-techstart</p>
                            <p class="text-xs text-gray-500">TechStart Inc</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900">156 Instance</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">project-devsolutions</p>
                            <p class="text-xs text-gray-500">DevSolutions</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900">2 Instance</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات سریع</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Glance ID</span>
                    <span class="font-medium text-gray-900">img-abc123def456</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Checksum</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">a1b2c3d4...</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">تاریخ آپلود</span>
                    <span class="font-medium text-gray-900">۱۴۰۳/۰۱/۱۵</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">آخرین به‌روزرسانی</span>
                    <span class="font-medium text-gray-900">۱۴۰۳/۰۳/۱۰</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">وضعیت</span>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">عملیات</h2>
            <div class="space-y-2">
                <button onclick="downloadImage()" class="w-full text-right px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg font-medium text-sm transition-colors flex items-center justify-between">
                    <span>دانلود Image</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                </button>
                <button onclick="createSnapshot()" class="w-full text-right px-4 py-2.5 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg font-medium text-sm transition-colors flex items-center justify-between">
                    <span>ایجاد Snapshot</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </button>
                <button onclick="toggleImageStatus()" class="w-full text-right px-4 py-2.5 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 rounded-lg font-medium text-sm transition-colors flex items-center justify-between">
                    <span>غیرفعال کردن</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </button>
                <button onclick="deleteImage()" class="w-full text-right px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-medium text-sm transition-colors flex items-center justify-between">
                    <span>حذف Image</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Properties Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">ویژگی‌ها</h2>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                    <span class="text-gray-600">OS Type</span>
                    <span class="font-medium text-gray-900">Linux</span>
                </div>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                    <span class="text-gray-600">OS Version</span>
                    <span class="font-medium text-gray-900">22.04</span>
                </div>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                    <span class="text-gray-600">Hypervisor Type</span>
                    <span class="font-medium text-gray-900">KVM</span>
                </div>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                    <span class="text-gray-600">Disk Format</span>
                    <span class="font-medium text-gray-900">QCOW2</span>
                </div>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                    <span class="text-gray-600">Container Format</span>
                    <span class="font-medium text-gray-900">bare</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleImageStatus() {
    if (confirm('آیا مطمئن هستید که می‌خواهید وضعیت این Image را تغییر دهید؟')) {
        // Toggle status logic here
        alert('وضعیت Image تغییر کرد');
    }
}

function downloadImage() {
    // Download logic here
    alert('در حال دانلود Image...');
}

function createSnapshot() {
    if (confirm('آیا می‌خواهید یک Snapshot از این Image ایجاد کنید؟')) {
        // Create snapshot logic here
        alert('Snapshot در حال ایجاد...');
    }
}

function deleteImage() {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Image را حذف کنید؟ این عمل غیرقابل بازگشت است.')) {
        // Delete logic here
        window.location.href = "{{ route('admin.images.index') }}";
    }
}

// Show/hide project access list based on access type
document.addEventListener('DOMContentLoaded', function() {
    const accessRadios = document.querySelectorAll('input[name="access"]');
    const projectAccessList = document.getElementById('projectAccessList');
    
    accessRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'private') {
                projectAccessList.classList.remove('hidden');
            } else {
                projectAccessList.classList.add('hidden');
            }
        });
    });
});
</script>
@endsection



