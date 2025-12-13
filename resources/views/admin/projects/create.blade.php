@extends('layouts.admin')

@section('title', 'ایجاد پروژه جدید')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Breadcrumb -->
<nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
    <a href="{{ route('admin.projects.index') }}" class="hover:text-gray-700">پروژه‌ها</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    <span class="text-gray-900">ایجاد پروژه جدید</span>
</nav>

<!-- Header -->
<div class="mb-6 md:mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">ایجاد پروژه جدید</h1>
    <p class="mt-1 text-sm text-gray-500">ایجاد یک پروژه جدید به صورت محلی (Local-First)</p>
</div>

<!-- Form -->
<form action="{{ route('admin.projects.store') }}" method="POST" class="space-y-6">
    @csrf
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">اطلاعات پایه</h2>
        
        <!-- Customer -->
        <div>
            <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">مشتری <span class="text-red-500">*</span></label>
            <select name="customer_id" id="customer_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">انتخاب مشتری</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->company_name ?: $customer->full_name }} 
                        @if($customer->email) - {{ $customer->email }} @endif
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Project Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">نام پروژه <span class="text-red-500">*</span></label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="{{ old('name') }}"
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="project-name"
            >
            <p class="mt-1 text-xs text-gray-500">نام پروژه باید یکتا باشد و فقط شامل حروف، اعداد و خط تیره باشد</p>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
            <textarea 
                name="description" 
                id="description" 
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="توضیحات پروژه..."
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Region -->
        <div>
            <label for="region" class="block text-sm font-medium text-gray-700 mb-2">منطقه</label>
            <input 
                type="text" 
                name="region" 
                id="region" 
                value="{{ old('region', 'RegionOne') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="RegionOne"
            >
            @error('region')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Sync Immediately -->
        <div class="flex items-center">
            <input 
                type="checkbox" 
                name="sync_immediately" 
                id="sync_immediately" 
                value="1"
                {{ old('sync_immediately') ? 'checked' : '' }}
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
            >
            <label for="sync_immediately" class="{{ $isRtl ? 'mr-2' : 'ml-2' }} block text-sm text-gray-700">
                همگام‌سازی فوری با OpenStack
            </label>
        </div>
    </div>

    <!-- Quota Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">تنظیمات سهمیه (Quota)</h2>
        <p class="text-sm text-gray-500 mb-6">می‌توانید بعداً این مقادیر را تغییر دهید</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="quota_instances" class="block text-sm font-medium text-gray-700 mb-2">Instance ها</label>
                <input 
                    type="number" 
                    name="quota_instances" 
                    id="quota_instances" 
                    value="{{ old('quota_instances', 20) }}"
                    min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <label for="quota_cores" class="block text-sm font-medium text-gray-700 mb-2">vCPU (تعداد هسته)</label>
                <input 
                    type="number" 
                    name="quota_cores" 
                    id="quota_cores" 
                    value="{{ old('quota_cores', 100) }}"
                    min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <label for="quota_ram" class="block text-sm font-medium text-gray-700 mb-2">RAM (مگابایت)</label>
                <input 
                    type="number" 
                    name="quota_ram" 
                    id="quota_ram" 
                    value="{{ old('quota_ram', 204800) }}"
                    min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                <p class="mt-1 text-xs text-gray-500">204800 MB = 200 GB</p>
            </div>
            <div>
                <label for="quota_gigabytes" class="block text-sm font-medium text-gray-700 mb-2">ذخیره‌سازی (گیگابایت)</label>
                <input 
                    type="number" 
                    name="quota_gigabytes" 
                    id="quota_gigabytes" 
                    value="{{ old('quota_gigabytes', 2048) }}"
                    min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <label for="quota_floating_ips" class="block text-sm font-medium text-gray-700 mb-2">Floating IP</label>
                <input 
                    type="number" 
                    name="quota_floating_ips" 
                    id="quota_floating_ips" 
                    value="{{ old('quota_floating_ips', 50) }}"
                    min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <label for="quota_networks" class="block text-sm font-medium text-gray-700 mb-2">Network ها</label>
                <input 
                    type="number" 
                    name="quota_networks" 
                    id="quota_networks" 
                    value="{{ old('quota_networks', 10) }}"
                    min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <label for="quota_routers" class="block text-sm font-medium text-gray-700 mb-2">Router ها</label>
                <input 
                    type="number" 
                    name="quota_routers" 
                    id="quota_routers" 
                    value="{{ old('quota_routers', 5) }}"
                    min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <label for="quota_volumes" class="block text-sm font-medium text-gray-700 mb-2">Volume ها</label>
                <input 
                    type="number" 
                    name="quota_volumes" 
                    id="quota_volumes" 
                    value="{{ old('quota_volumes', 50) }}"
                    min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
        <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-center">
            انصراف
        </a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
            ایجاد پروژه
        </button>
    </div>
</form>
@endsection

