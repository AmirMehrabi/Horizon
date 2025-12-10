@extends('layouts.admin')

@section('title', 'داشبورد صورتحساب')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.billing.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">داشبورد صورتحساب</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت کامل سیستم صورتحساب و پرداخت</p>
</div>

<!-- Revenue Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">درآمد روزانه</p>
                <p class="text-2xl font-bold text-gray-900">$12,450</p>
                <p class="text-xs text-green-600 mt-1">+12% از دیروز</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">درآمد ماهانه</p>
                <p class="text-2xl font-bold text-gray-900">$342,890</p>
                <p class="text-xs text-green-600 mt-1">+8% از ماه قبل</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">MRR</p>
                <p class="text-2xl font-bold text-gray-900">$285,600</p>
                <p class="text-xs text-green-600 mt-1">+15% رشد</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">ARPU</p>
                <p class="text-2xl font-bold text-gray-900">$89.50</p>
                <p class="text-xs text-blue-600 mt-1">میانگین هر کاربر</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Outstanding & Wallet Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">فاکتورهای معوق</p>
                <p class="text-2xl font-bold text-gray-900">$23,450</p>
                <p class="text-xs text-red-600 mt-1">45 فاکتور</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">کل موجودی کیف پول</p>
                <p class="text-2xl font-bold text-gray-900">$156,780</p>
                <p class="text-xs text-gray-600 mt-1">1,234 کیف پول</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">پرداخت‌های ناموفق</p>
                <p class="text-2xl font-bold text-gray-900">12</p>
                <p class="text-xs text-orange-600 mt-1">امروز</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Resource Consumption -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">مصرف منابع</h2>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">CPU (vCPU Hours)</span>
                    <span class="font-medium">12,456 ساعت</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">RAM (GB Hours)</span>
                    <span class="font-medium">45,678 GB ساعت</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 60%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Storage (TB)</span>
                    <span class="font-medium">234.5 TB</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Bandwidth (TB)</span>
                    <span class="font-medium">89.2 TB</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-600 h-2 rounded-full" style="width: 45%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">بهترین مشتریان</h2>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-900">ACME Corporation</p>
                    <p class="text-xs text-gray-500">acme@example.com</p>
                </div>
                <span class="text-sm font-bold text-green-600">$2,450/ماه</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-900">TechStart Inc</p>
                    <p class="text-xs text-gray-500">tech@example.com</p>
                </div>
                <span class="text-sm font-bold text-green-600">$1,890/ماه</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-900">Digital Solutions</p>
                    <p class="text-xs text-gray-500">digital@example.com</p>
                </div>
                <span class="text-sm font-bold text-green-600">$1,650/ماه</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions & Overdue Accounts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">تراکنش‌های اخیر</h2>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 border-l-4 border-green-500 bg-green-50 rounded">
                <div>
                    <p class="text-sm font-medium text-gray-900">پرداخت موفق</p>
                    <p class="text-xs text-gray-500">user@example.com - INV-2024-001</p>
                </div>
                <span class="text-sm font-bold text-green-600">+$89.50</span>
            </div>
            <div class="flex items-center justify-between p-3 border-l-4 border-blue-500 bg-blue-50 rounded">
                <div>
                    <p class="text-sm font-medium text-gray-900">شارژ کیف پول</p>
                    <p class="text-xs text-gray-500">admin@example.com</p>
                </div>
                <span class="text-sm font-bold text-blue-600">+$500.00</span>
            </div>
            <div class="flex items-center justify-between p-3 border-l-4 border-red-500 bg-red-50 rounded">
                <div>
                    <p class="text-sm font-medium text-gray-900">پرداخت ناموفق</p>
                    <p class="text-xs text-gray-500">failed@example.com</p>
                </div>
                <span class="text-sm font-bold text-red-600">-$125.00</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">حساب‌های معوق</h2>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                <div>
                    <p class="text-sm font-medium text-gray-900">overdue1@example.com</p>
                    <p class="text-xs text-red-600">معوق 15 روز</p>
                </div>
                <span class="text-sm font-bold text-red-600">$234.50</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-200">
                <div>
                    <p class="text-sm font-medium text-gray-900">overdue2@example.com</p>
                    <p class="text-xs text-orange-600">معوق 8 روز</p>
                </div>
                <span class="text-sm font-bold text-orange-600">$89.00</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                <div>
                    <p class="text-sm font-medium text-gray-900">overdue3@example.com</p>
                    <p class="text-xs text-yellow-600">معوق 3 روز</p>
                </div>
                <span class="text-sm font-bold text-yellow-600">$156.75</span>
            </div>
        </div>
    </div>
</div>
@endsection
