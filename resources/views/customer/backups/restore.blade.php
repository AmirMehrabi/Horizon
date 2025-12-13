@extends('layouts.customer')

@section('title', 'بازگردانی Snapshot')

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
                'label' => 'بکاپ‌ها',
                'url' => route('customer.backups.index'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>'
            ],
            [
                'label' => 'بازگردانی',
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <a href="{{ route('customer.backups.index') }}" class="text-blue-600 hover:text-blue-700 text-sm mb-2 inline-block">
        ← بازگشت به لیست Snapshotها
    </a>
    <h1 class="text-3xl font-bold text-gray-900">بازگردانی Snapshot</h1>
    <p class="mt-1 text-sm text-gray-500">بازگردانی سرور از Snapshot</p>
</div>

<!-- Restore Confirmation -->
<div class="w-full">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <!-- Info -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold text-yellow-900">اطلاعات مهم</h3>
                    <p class="text-sm text-yellow-700 mt-1">
                        یک سرور جدید از این Snapshot ایجاد خواهد شد. سرور اصلی "{{ $snapshot['server_name'] }}" بدون تغییر باقی می‌ماند.
                    </p>
                    <ul class="text-sm text-yellow-700 mt-2 list-disc list-inside space-y-1">
                        <li>سرور جدید با همان تنظیمات سرور اصلی ایجاد می‌شود</li>
                        <li>این عملیات ممکن است چند دقیقه تا چند ساعت طول بکشد</li>
                        <li>پس از ایجاد، می‌توانید سرور جدید را مدیریت کنید</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Snapshot Info -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">اطلاعات Snapshot</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">نام:</span>
                    <span class="font-medium text-gray-900">{{ $snapshot['name'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">سرور:</span>
                    <span class="font-medium text-gray-900">{{ $snapshot['server_name'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">تاریخ ایجاد:</span>
                    <span class="font-medium text-gray-900">{{ $snapshot['created_at'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">حجم:</span>
                    <span class="font-medium text-gray-900">{{ $snapshot['size'] }} {{ $snapshot['size_unit'] }}</span>
                </div>
            </div>
        </div>
        
        <!-- Confirmation Form -->
        <form method="POST" action="{{ route('customer.backups.restore', $snapshot['id']) }}">
            @csrf
            
            <!-- New Server Name -->
            <div class="mb-6">
                <label for="new_server_name" class="block text-sm font-medium text-gray-700 mb-2">
                    نام سرور جدید <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="new_server_name" 
                    name="new_server_name" 
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="مثال: سرور بازگردانی شده"
                    value="restored-{{ $snapshot['name'] }}"
                >
                <p class="mt-1 text-xs text-gray-500">یک سرور جدید از این Snapshot ایجاد خواهد شد</p>
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="confirm" value="1" required class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                    <span class="ml-2 text-sm text-gray-700">
                        من می‌فهمم که یک سرور جدید ایجاد خواهد شد و این عملیات ممکن است چند دقیقه طول بکشد.
                    </span>
                </label>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('customer.backups.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                    انصراف
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    ایجاد سرور جدید از Snapshot
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


