@extends('layouts.customer')

@section('title', 'پشتیبانی و تیکت‌ها')

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
                'label' => 'پشتیبانی',
                'active' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>'
            ]
        ]
    ])
@endsection

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">پشتیبانی و تیکت‌ها</h1>
        <p class="mt-1 text-sm text-gray-500">همه درخواست‌های پشتیبانی شما در یک مکان</p>
    </div>
    <div>
        <a href="{{ route('customer.support.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            ایجاد تیکت جدید
        </a>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Status Filter -->
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">وضعیت</label>
            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه</option>
                <option value="open">باز</option>
                <option value="in_progress">در حال بررسی</option>
                <option value="answered">پاسخ داده شده</option>
                <option value="closed">بسته شده</option>
            </select>
        </div>
        
        <!-- Category Filter -->
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">دسته‌بندی</label>
            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه</option>
                @foreach($categories as $category)
                <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Date Range Filter -->
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">بازه زمانی</label>
            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه</option>
                <option value="today">امروز</option>
                <option value="week">این هفته</option>
                <option value="month">این ماه</option>
                <option value="year">این سال</option>
            </select>
        </div>
        
        <!-- Search -->
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">جستجو در عنوان</label>
            <div class="relative">
                <input type="text" placeholder="جستجو..." class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm focus:ring-blue-500 focus:border-blue-500">
                <svg class="w-4 h-4 absolute {{ $isRtl ? 'left-3' : 'right-3' }} top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Tickets Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">شماره</th>
                    <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">عنوان تیکت</th>
                    <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                    <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">دسته‌بندی</th>
                    <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">آخرین بروزرسانی</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tickets as $ticket)
                <tr class="hover:bg-gray-50 cursor-pointer transition-colors" onclick="window.location.href='{{ route('customer.support.show', $ticket['id']) }}'">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-medium text-gray-900">#{{ $ticket['id'] }}</span>
                        @if($ticket['unread_messages'] > 0)
                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            {{ $ticket['unread_messages'] }} جدید
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $ticket['title'] }}</div>
                        <div class="text-xs text-gray-500 mt-1">اولویت: {{ $ticket['priority_label'] }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            @if($ticket['status_color'] === 'green') bg-green-100 text-green-800
                            @elseif($ticket['status_color'] === 'yellow') bg-yellow-100 text-yellow-800
                            @elseif($ticket['status_color'] === 'blue') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $ticket['status_label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $ticket['category'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $ticket['last_update'] }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">تیکتی وجود ندارد</h3>
                        <p class="mt-1 text-sm text-gray-500">برای ایجاد تیکت جدید، روی دکمه "ایجاد تیکت جدید" کلیک کنید.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if(count($tickets) > 0)
    <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
        <div class="text-sm text-gray-700">
            نمایش <span class="font-medium">1</span> تا <span class="font-medium">{{ count($tickets) }}</span> از <span class="font-medium">{{ count($tickets) }}</span> تیکت
        </div>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                قبلی
            </button>
            <button class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                بعدی
            </button>
        </div>
    </div>
    @endif
</div>
@endsection
