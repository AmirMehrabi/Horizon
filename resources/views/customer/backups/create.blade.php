@extends('layouts.customer')

@section('title', 'ایجاد Snapshot جدید')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <a href="{{ route('customer.backups.index') }}" class="text-blue-600 hover:text-blue-700 text-sm mb-2 inline-block">
        ← بازگشت به لیست Snapshotها
    </a>
    <h1 class="text-3xl font-bold text-gray-900">ایجاد Snapshot جدید</h1>
    <p class="mt-1 text-sm text-gray-500">ایجاد پشتیبان از سرور خود</p>
</div>

<!-- Create Snapshot Form -->
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('customer.backups.store') }}">
            @csrf
            
            <div class="space-y-6">
                <!-- Snapshot Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        نام Snapshot <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="مثال: Snapshot قبل از به‌روزرسانی"
                    >
                </div>
                
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        توضیحات (اختیاری)
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="توضیحات مربوط به این Snapshot..."
                    ></textarea>
                </div>
                
                <!-- Server Selection -->
                <div>
                    <label for="server_id" class="block text-sm font-medium text-gray-700 mb-2">
                        انتخاب ماشین مجازی <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="server_id" 
                        name="server_id" 
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">انتخاب کنید</option>
                        @foreach($servers as $server)
                        <option value="{{ $server['id'] }}">{{ $server['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Warning -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-900">توجه</p>
                            <p class="text-xs text-yellow-700 mt-1">
                                ایجاد Snapshot ممکن است چند دقیقه طول بکشد. در طول این مدت، عملکرد سرور ممکن است کمی کاهش یابد.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('customer.backups.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                    انصراف
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    ایجاد Snapshot
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

