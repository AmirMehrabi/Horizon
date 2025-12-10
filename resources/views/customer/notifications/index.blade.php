@extends('layouts.customer')

@section('title', 'اعلان‌ها')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">اعلان‌ها</h1>
        <p class="mt-1 text-sm text-gray-500">همه اعلان‌های شما در یک مکان</p>
    </div>
    @if($unreadCount > 0)
    <form method="POST" action="{{ route('customer.notifications.read-all') }}" class="inline">
        @csrf
        <button type="submit" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition-colors">
            علامت‌گذاری همه به عنوان خوانده شده
        </button>
    </form>
    @endif
</div>

<!-- Filters -->
<div class="border-b border-gray-200 mb-6">
    <nav class="-mb-px flex space-x-8 {{ $isRtl ? 'space-x-reverse' : '' }}" aria-label="Tabs">
        <a href="{{ route('customer.notifications.index', ['filter' => 'all']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $filter === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            همه
        </a>
        <a href="{{ route('customer.notifications.index', ['filter' => 'unread']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $filter === 'unread' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            خوانده نشده
            @if($unreadCount > 0)
            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                {{ $unreadCount }}
            </span>
            @endif
        </a>
        <a href="{{ route('customer.notifications.index', ['filter' => 'billing']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $filter === 'billing' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            صورتحساب
        </a>
        <a href="{{ route('customer.notifications.index', ['filter' => 'technical']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $filter === 'technical' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            فنی
        </a>
        <a href="{{ route('customer.notifications.index', ['filter' => 'security']) }}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $filter === 'security' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            امنیت
        </a>
    </nav>
</div>

<!-- Notifications List -->
<div class="space-y-4">
    @forelse($notifications as $notification)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 {{ !$notification['read'] ? 'border-l-4 border-l-blue-500' : '' }}">
        <div class="flex items-start gap-4">
            <!-- Icon -->
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full flex items-center justify-center
                    @if($notification['type'] === 'billing') bg-green-100 text-green-600
                    @elseif($notification['type'] === 'security') bg-red-100 text-red-600
                    @elseif($notification['type'] === 'technical') bg-blue-100 text-blue-600
                    @else bg-gray-100 text-gray-600
                    @endif">
                    @if($notification['type_icon'] === 'dollar')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    @elseif($notification['type_icon'] === 'shield')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    @elseif($notification['type_icon'] === 'message')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    @elseif($notification['type_icon'] === 'check')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    @endif
                </div>
            </div>
            
            <!-- Content -->
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-semibold text-gray-900">{{ $notification['title'] }}</h3>
                            @if(!$notification['read'])
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                جدید
                            </span>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-gray-600">{{ $notification['description'] }}</p>
                        <div class="mt-2 flex items-center gap-4 text-xs text-gray-500">
                            <span>{{ $notification['time'] }}</span>
                            <span>{{ $notification['timestamp'] }}</span>
                            <span class="px-2 py-0.5 rounded bg-gray-100">{{ $notification['type_label'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">اعلانی وجود ندارد</h3>
        <p class="mt-1 text-sm text-gray-500">هیچ اعلانی در این دسته‌بندی یافت نشد.</p>
    </div>
    @endforelse
</div>
@endsection

