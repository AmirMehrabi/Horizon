@extends('layouts.customer')

@section('title', 'ایجاد تیکت جدید')

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
                'url' => route('customer.support.index'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>'
            ],
            [
                'label' => 'ایجاد تیکت',
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <a href="{{ route('customer.support.index') }}" class="text-blue-600 hover:text-blue-700 text-sm mb-2 inline-block">
        ← بازگشت به لیست تیکت‌ها
    </a>
    <h1 class="text-3xl font-bold text-gray-900">ایجاد تیکت جدید</h1>
    <p class="mt-1 text-sm text-gray-500">درخواست پشتیبانی خود را ثبت کنید</p>
</div>

<!-- Create Ticket Form -->
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('customer.support.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        عنوان تیکت <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="مثال: مشکل در اتصال به سرور"
                    >
                </div>
                
                <!-- Category and Priority -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            انتخاب دسته‌بندی <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="category" 
                            name="category" 
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">انتخاب کنید</option>
                            @foreach($categories as $category)
                            <option value="{{ $category['value'] }}">{{ $category['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                            اولویت <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="priority" 
                            name="priority" 
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">انتخاب کنید</option>
                            @foreach($priorities as $priority)
                            <option value="{{ $priority['value'] }}">{{ $priority['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Related Server -->
                <div>
                    <label for="server_id" class="block text-sm font-medium text-gray-700 mb-2">
                        انتخاب سرویس مرتبط (اختیاری)
                    </label>
                    <select 
                        id="server_id" 
                        name="server_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">هیچکدام</option>
                        @foreach($servers as $server)
                        <option value="{{ $server['id'] }}">{{ $server['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        متن توضیحات <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="8"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="لطفاً مشکل یا سوال خود را به طور کامل شرح دهید..."
                    ></textarea>
                    <p class="mt-1 text-xs text-gray-500">هرچه توضیحات شما کامل‌تر باشد، پاسخ سریع‌تری دریافت خواهید کرد.</p>
                </div>
                
                <!-- File Attachment -->
                <div>
                    <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                        ضمیمه فایل (اختیاری)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-4h-4m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="attachment" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>انتخاب فایل</span>
                                    <input id="attachment" name="attachment" type="file" class="sr-only" accept=".txt,.pdf,.doc,.docx,.jpg,.png,.zip">
                                </label>
                                <p class="pl-1">یا فایل را اینجا بکشید</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, PDF, DOC تا 10MB</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('customer.support.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                    انصراف
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    ارسال تیکت
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
