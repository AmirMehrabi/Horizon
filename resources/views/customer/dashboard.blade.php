@extends('layouts.customer')

@section('title', 'داشبورد')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
    $customer = auth('customer')->user();
@endphp

@section('header_content')
    <h1 class="text-lg font-medium text-gray-900">
        {{ __('Welcome back, :name!', ['name' => $customer->first_name ?? '']) }}
    </h1>
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">داشبورد</h1>
    <p class="mt-1 text-sm text-gray-500">نمای کلی از منابع ابری شما</p>
</div>

<!-- Quick Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
    <!-- Active VPS -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                    </svg>
                </div>
            </div>
            <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                <p class="text-sm font-medium text-gray-500">سرورهای فعال</p>
                <p class="text-2xl font-semibold text-gray-900">۳</p>
            </div>
        </div>
    </div>

    <!-- Pending/Deploying Servers -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                <p class="text-sm font-medium text-gray-500">در حال راه‌اندازی</p>
                <p class="text-2xl font-semibold text-gray-900">۱</p>
            </div>
        </div>
    </div>

    <!-- Wallet Balance -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                <p class="text-sm font-medium text-gray-500">موجودی کیف پول</p>
                <p class="text-2xl font-semibold text-gray-900">۱,۲۵۰,۰۰۰ تومان</p>
            </div>
        </div>
    </div>

    <!-- Bandwidth Usage -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
            </div>
            <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                <p class="text-sm font-medium text-gray-500">مصرف پهنای باند</p>
                <p class="text-2xl font-semibold text-gray-900">۲۸۵ GB</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Active VPS -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">سرورهای فعال</h2>
                <a href="{{ route('customer.servers.index') }}" class="text-sm text-blue-600 hover:text-blue-700">مشاهده همه</a>
            </div>
            <div class="space-y-4">
                <!-- Server 1 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">وب سرور اصلی</h3>
                            <p class="text-xs text-gray-500">Ubuntu 22.04 • ۴ vCPU • ۸GB RAM</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            فعال
                        </span>
                        <div class="text-{{ $isRtl ? 'left' : 'right' }} text-xs text-gray-500">
                            CPU: ۲۳%
                        </div>
                    </div>
                </div>

                <!-- Server 2 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">پایگاه داده</h3>
                            <p class="text-xs text-gray-500">MySQL 8.0 • ۲ vCPU • ۴GB RAM</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            فعال
                        </span>
                        <div class="text-{{ $isRtl ? 'left' : 'right' }} text-xs text-gray-500">
                            CPU: ۱۲%
                        </div>
                    </div>
                </div>

                <!-- Server 3 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">سرور فایل</h3>
                            <p class="text-xs text-gray-500">CentOS 8 • ۱ vCPU • ۲GB RAM</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            فعال
                        </span>
                        <div class="text-{{ $isRtl ? 'left' : 'right' }} text-xs text-gray-500">
                            CPU: ۵%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending/Deploying Servers -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">سرورهای در حال راه‌اندازی</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">سرور تست</h3>
                            <p class="text-xs text-gray-500">Ubuntu 22.04 • ۲ vCPU • ۴GB RAM</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            در حال نصب
                        </span>
                        <div class="text-{{ $isRtl ? 'left' : 'right' }} text-xs text-gray-500">
                            ۷۵%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bandwidth Usage Chart -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">مصرف پهنای باند (۳۰ روز گذشته)</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">مصرف کل:</span>
                    <span class="text-sm font-medium text-gray-900">۲۸۵ GB از ۵۰۰ GB</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full" style="width: 57%"></div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">ورودی:</span>
                        <span class="font-medium text-gray-900">۱۲۰ GB</span>
                    </div>
                    <div>
                        <span class="text-gray-600">خروجی:</span>
                        <span class="font-medium text-gray-900">۱۶۵ GB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Recent Invoices -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">فاکتورهای اخیر</h2>
                <a href="{{ route('customer.invoices.index') }}" class="text-sm text-blue-600 hover:text-blue-700">مشاهده همه</a>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">#INV-2024-001</p>
                        <p class="text-xs text-gray-500">۱۴۰۳/۰۹/۱۵</p>
                    </div>
                    <div class="text-{{ $isRtl ? 'left' : 'right' }}">
                        <p class="text-sm font-medium text-gray-900">۸۵۰,۰۰۰ تومان</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            پرداخت شده
                        </span>
                    </div>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">#INV-2024-002</p>
                        <p class="text-xs text-gray-500">۱۴۰۳/۰۹/۲۰</p>
                    </div>
                    <div class="text-{{ $isRtl ? 'left' : 'right' }}">
                        <p class="text-sm font-medium text-gray-900">۹۲۰,۰۰۰ تومان</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            در انتظار
                        </span>
                    </div>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">#INV-2024-003</p>
                        <p class="text-xs text-gray-500">۱۴۰۳/۰۹/۲۵</p>
                    </div>
                    <div class="text-{{ $isRtl ? 'left' : 'right' }}">
                        <p class="text-sm font-medium text-gray-900">۷۵۰,۰۰۰ تومان</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            پرداخت شده
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">اعلان‌ها</h2>
            <div class="space-y-3">
                <div class="flex items-start space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }} p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">سرور جدید آماده است</p>
                        <p class="text-xs text-gray-500 mt-1">سرور تست شما با موفقیت راه‌اندازی شد</p>
                        <p class="text-xs text-gray-400 mt-1">۲ ساعت پیش</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }} p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">فاکتور جدید</p>
                        <p class="text-xs text-gray-500 mt-1">فاکتور ماهانه شما آماده شده است</p>
                        <p class="text-xs text-gray-400 mt-1">۱ روز پیش</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }} p-3 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">پرداخت موفق</p>
                        <p class="text-xs text-gray-500 mt-1">پرداخت فاکتور #INV-2024-001 انجام شد</p>
                        <p class="text-xs text-gray-400 mt-1">۳ روز پیش</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">عملیات سریع</h2>
            <div class="space-y-3">
                <a href="{{ route('customer.servers.create') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center block">
                    ایجاد سرور جدید
                </a>
                <a href="{{ route('customer.wallet.topup') }}" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center block">
                    شارژ کیف پول
                </a>
                <a href="{{ route('customer.support.create') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center block">
                    تیکت پشتیبانی
                </a>
            </div>
        </div>
    </div>
</div>
@endsection