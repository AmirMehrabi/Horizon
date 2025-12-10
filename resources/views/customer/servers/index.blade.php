@extends('layouts.customer')

@section('title', 'سرورهای من')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('header_content')
    <nav class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}" aria-label="Breadcrumb">
        <!-- Dashboard -->
        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-all duration-200 group">
            <svg class="w-4 h-4 {{ $isRtl ? 'ml-1.5' : 'mr-1.5' }} text-gray-500 group-hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>داشبورد</span>
        </a>
        
        <!-- Arrow -->
        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $isRtl ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7' }}"></path>
        </svg>
        
        <!-- Servers (Current Page) -->
        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium text-gray-900 bg-gray-50">
            <svg class="w-4 h-4 {{ $isRtl ? 'ml-1.5' : 'mr-1.5' }} text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
            </svg>
            <span>سرورها</span>
        </span>
    </nav>
@endsection

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">سرورهای من</h1>
        <p class="mt-1 text-sm text-gray-500">مدیریت سرورهای مجازی شما</p>
    </div>
    <a href="{{ route('customer.servers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
        + ایجاد سرور جدید
    </a>
</div>

<!-- Servers List -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Server Card 1 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">وب سرور اصلی</h3>
                    <p class="text-xs text-gray-500">Ubuntu 22.04</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                فعال
            </span>
        </div>
        
        <div class="space-y-2 mb-4">
            <div class="flex justify-between text-xs text-gray-600">
                <span>vCPU:</span>
                <span class="font-medium">۴</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>RAM:</span>
                <span class="font-medium">۸ GB</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>Storage:</span>
                <span class="font-medium">۸۰ GB</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>IP:</span>
                <span class="font-medium">185.123.45.67</span>
            </div>
        </div>
        
        <a href="{{ route('customer.servers.show', 1) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-medium py-2 px-4 rounded-lg transition-colors text-sm">
            مدیریت سرور
        </a>
    </div>

    <!-- Server Card 2 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">پایگاه داده</h3>
                    <p class="text-xs text-gray-500">MySQL 8.0</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                فعال
            </span>
        </div>
        
        <div class="space-y-2 mb-4">
            <div class="flex justify-between text-xs text-gray-600">
                <span>vCPU:</span>
                <span class="font-medium">۲</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>RAM:</span>
                <span class="font-medium">۴ GB</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>Storage:</span>
                <span class="font-medium">۴۰ GB</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>IP:</span>
                <span class="font-medium">185.123.45.68</span>
            </div>
        </div>
        
        <a href="{{ route('customer.servers.show', 2) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-medium py-2 px-4 rounded-lg transition-colors text-sm">
            مدیریت سرور
        </a>
    </div>

    <!-- Server Card 3 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">سرور فایل</h3>
                    <p class="text-xs text-gray-500">CentOS 8</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                فعال
            </span>
        </div>
        
        <div class="space-y-2 mb-4">
            <div class="flex justify-between text-xs text-gray-600">
                <span>vCPU:</span>
                <span class="font-medium">۱</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>RAM:</span>
                <span class="font-medium">۲ GB</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>Storage:</span>
                <span class="font-medium">۲۰ GB</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>IP:</span>
                <span class="font-medium">185.123.45.69</span>
            </div>
        </div>
        
        <a href="{{ route('customer.servers.show', 3) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-medium py-2 px-4 rounded-lg transition-colors text-sm">
            مدیریت سرور
        </a>
    </div>
</div>
@endsection

