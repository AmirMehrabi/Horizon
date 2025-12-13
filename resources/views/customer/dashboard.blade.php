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
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_machines'] ?? 0 }}</p>
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
                <p class="text-2xl font-semibold text-gray-900">{{ ($stats['pending_machines'] ?? 0) + ($stats['building_machines'] ?? 0) }}</p>
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
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($wallet->balance ?? 0, 0) }} {{ $wallet->currency ?? 'ریال' }}</p>
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
                <p class="text-2xl font-semibold text-gray-900">{{ $bandwidthUsage['used'] ?? 0 }} GB</p>
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
            @if($activeInstances->count() > 0)
                <div class="space-y-4">
                    @foreach($activeInstances as $instance)
                        <a href="{{ route('customer.servers.show', $instance->id) }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">{{ $instance->name }}</h3>
                                    <p class="text-xs text-gray-500">
                                        @if($instance->image)
                                            {{ $instance->image->name }}
                                        @endif
                                        @if($instance->flavor)
                                            • {{ $instance->flavor->vcpus }} vCPU • {{ number_format($instance->flavor->ram / 1024, 0) }}GB RAM
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    فعال
                                </span>
                                @if($instance->public_ips && count($instance->public_ips) > 0)
                                    <div class="text-{{ $isRtl ? 'left' : 'right' }} text-xs text-gray-500">
                                        {{ $instance->public_ips[0] }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">هیچ سرور فعالی وجود ندارد</h3>
                    <p class="mt-1 text-sm text-gray-500">شروع کنید با ایجاد یک سرور جدید</p>
                    <div class="mt-6">
                        <a href="{{ route('customer.servers.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            ایجاد سرور جدید
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pending/Deploying Servers -->
        @if($pendingInstances->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">سرورهای در حال راه‌اندازی</h2>
                <div class="space-y-4">
                    @foreach($pendingInstances as $instance)
                        <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">{{ $instance->name }}</h3>
                                    <p class="text-xs text-gray-500">
                                        @if($instance->image)
                                            {{ $instance->image->name }}
                                        @endif
                                        @if($instance->flavor)
                                            • {{ $instance->flavor->vcpus }} vCPU • {{ number_format($instance->flavor->ram / 1024, 0) }}GB RAM
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    @if($instance->status === 'building')
                                        در حال نصب
                                    @else
                                        در انتظار
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Bandwidth Usage Chart -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">مصرف پهنای باند (۳۰ روز گذشته)</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">مصرف کل:</span>
                    <span class="text-sm font-medium text-gray-900">{{ $bandwidthUsage['used'] ?? 0 }} GB از {{ $bandwidthUsage['limit'] ?? 500 }} GB</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all" style="width: {{ min(($bandwidthUsage['percentage'] ?? 0), 100) }}%"></div>
                </div>
                @if(($bandwidthUsage['percentage'] ?? 0) > 0)
                    <p class="text-xs text-gray-500 mt-1">{{ number_format($bandwidthUsage['percentage'] ?? 0, 1) }}% استفاده شده</p>
                @endif
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">ورودی:</span>
                        <span class="font-medium text-gray-900">{{ $bandwidthUsage['incoming'] ?? 0 }} GB</span>
                    </div>
                    <div>
                        <span class="text-gray-600">خروجی:</span>
                        <span class="font-medium text-gray-900">{{ $bandwidthUsage['outgoing'] ?? 0 }} GB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Recent Invoices -->
        @if($recentInvoices->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">فاکتورهای اخیر</h2>
                    <a href="{{ route('customer.invoices.index') }}" class="text-sm text-blue-600 hover:text-blue-700">مشاهده همه</a>
                </div>
                <div class="space-y-3">
                    @foreach($recentInvoices as $invoice)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $invoice->number ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $invoice->created_at->format('Y/m/d') ?? '' }}</p>
                            </div>
                            <div class="text-{{ $isRtl ? 'left' : 'right' }}">
                                <p class="text-sm font-medium text-gray-900">{{ number_format($invoice->amount ?? 0, 0) }} ریال</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $invoice->status === 'paid' ? 'پرداخت شده' : 'در انتظار' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Notifications -->
        @if($notifications->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">اعلان‌ها</h2>
                <div class="space-y-3">
                    @foreach($notifications as $notification)
                        <div class="flex items-start space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }} p-3 bg-{{ $notification['color'] ?? 'blue' }}-50 rounded-lg border border-{{ $notification['color'] ?? 'blue' }}-200">
                            <div class="flex-shrink-0">
                                @if($notification['icon'] === 'check')
                                    <svg class="w-5 h-5 text-{{ $notification['color'] ?? 'green' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @elseif($notification['icon'] === 'alert')
                                    <svg class="w-5 h-5 text-{{ $notification['color'] ?? 'red' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-{{ $notification['color'] ?? 'blue' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $notification['title'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $notification['description'] }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notification['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

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
