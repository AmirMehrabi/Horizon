@extends('layouts.customer')

@section('title', 'سرورهای من')

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
                'label' => 'سرورها',
                'active' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>'
            ]
        ]
    ])
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
@if($instances->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($instances as $instance)
            @php
                $publicIps = $instance->public_ips ?? [];
                $privateIps = $instance->private_ips ?? [];
                $publicIp = !empty($publicIps) ? $publicIps[0] : 'در حال اختصاص...';
                $osName = $instance->image->name ?? 'Unknown';
                $vcpu = $instance->flavor->vcpus ?? 0;
                $ram = $instance->flavor ? round($instance->flavor->ram / 1024, 1) : 0;
                $storage = $instance->flavor->disk ?? 0;
                
                // Status badge colors
                $statusConfig = [
                    'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'فعال'],
                    'building' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'در حال راه‌اندازی'],
                    'stopped' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'متوقف شده'],
                    'error' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'خطا'],
                    'pending' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'در انتظار'],
                ];
                $status = $instance->status ?? 'unknown';
                $statusInfo = $statusConfig[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => $status];
                
                // Icon colors based on status
                $iconColors = [
                    'active' => ['bg' => 'bg-green-100', 'icon' => 'text-green-600'],
                    'building' => ['bg' => 'bg-yellow-100', 'icon' => 'text-yellow-600'],
                    'stopped' => ['bg' => 'bg-gray-100', 'icon' => 'text-gray-600'],
                    'error' => ['bg' => 'bg-red-100', 'icon' => 'text-red-600'],
                    'pending' => ['bg' => 'bg-blue-100', 'icon' => 'text-blue-600'],
                ];
                $iconColor = $iconColors[$status] ?? ['bg' => 'bg-gray-100', 'icon' => 'text-gray-600'];
            @endphp
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                        <div class="w-10 h-10 {{ $iconColor['bg'] }} rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 {{ $iconColor['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">{{ $instance->name ?? 'Unnamed Server' }}</h3>
                            <p class="text-xs text-gray-500">{{ $osName }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusInfo['bg'] }} {{ $statusInfo['text'] }}">
                        {{ $statusInfo['label'] }}
                    </span>
                </div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-xs text-gray-600">
                        <span>vCPU:</span>
                        <span class="font-medium">{{ $vcpu }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-600">
                        <span>RAM:</span>
                        <span class="font-medium">{{ number_format($ram, 1) }} GB</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-600">
                        <span>Storage:</span>
                        <span class="font-medium">{{ $storage }} GB</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-600">
                        <span>IP:</span>
                        <span class="font-medium">{{ $publicIp }}</span>
                    </div>
                </div>
                
                <a href="{{ route('customer.servers.show', $instance->id) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                    مدیریت سرور
                </a>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    @if($instances->hasPages())
        <div class="mt-8">
            {{ $instances->links() }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">هیچ سروری یافت نشد</h3>
        <p class="mt-2 text-sm text-gray-500">شما هنوز سروری ایجاد نکرده‌اید. برای شروع، یک سرور جدید ایجاد کنید.</p>
        <div class="mt-6">
            <a href="{{ route('customer.servers.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                + ایجاد سرور جدید
            </a>
        </div>
    </div>
@endif
@endsection

