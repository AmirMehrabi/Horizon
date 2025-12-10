@extends('layouts.admin')

@section('title', 'لاگ‌ها و نظارت')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.logs-monitoring.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">لاگ‌ها و نظارت</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت لاگ‌های سیستم و نظارت بر سلامت API ها</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">لاگ‌های امروز</p>
                <p class="text-2xl font-bold text-gray-900">1,247</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">خطاهای امروز</p>
                <p class="text-2xl font-bold text-gray-900">23</p>
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
                <p class="text-sm text-gray-500 font-medium mb-1">Provisioning های ناموفق</p>
                <p class="text-2xl font-bold text-gray-900">5</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">API های سالم</p>
                <p class="text-2xl font-bold text-gray-900">4/5</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <a href="{{ route('admin.logs-monitoring.system-logs') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">لاگ‌های سیستم</h3>
                <p class="text-sm text-gray-500">عملیات ادمین و کاربر</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.logs-monitoring.failed-provisioning') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Provisioning ناموفق</h3>
                <p class="text-sm text-gray-500">لاگ‌های خطا</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.logs-monitoring.openstack-logs') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">لاگ‌های OpenStack</h3>
                <p class="text-sm text-gray-500">رویدادها و خطاها</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.logs-monitoring.api-health') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">سلامت API</h3>
                <p class="text-sm text-gray-500">Nova, Neutron, Cinder</p>
            </div>
        </div>
    </a>
</div>

<!-- Recent Logs -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">لاگ‌های اخیر</h2>
    <div class="space-y-3">
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Instance ایجاد شد</p>
                    <p class="text-xs text-gray-500">web-server-01 توسط admin@example.com</p>
                </div>
            </div>
            <span class="text-xs text-gray-500">۲ دقیقه پیش</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">خطای Provisioning</p>
                    <p class="text-xs text-gray-500">Volume creation failed - Insufficient quota</p>
                </div>
            </div>
            <span class="text-xs text-gray-500">۱۵ دقیقه پیش</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">OpenStack Event</p>
                    <p class="text-xs text-gray-500">Nova API: High response time detected</p>
                </div>
            </div>
            <span class="text-xs text-gray-500">۱ ساعت پیش</span>
        </div>
    </div>
</div>
@endsection

