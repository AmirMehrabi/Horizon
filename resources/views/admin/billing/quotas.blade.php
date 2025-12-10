@extends('layouts.admin')

@section('title', 'قیمت‌گذاری کوتا')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.billing.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">قیمت‌گذاری کوتا</h1>
    <p class="mt-1 text-sm text-gray-500">تنظیم قیمت‌گذاری برای کوتاهای منابع</p>
</div>

<!-- Quota Pricing Configuration -->
<div class="space-y-6">
    <!-- Max vCPU -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">حداکثر vCPU</h3>
                    <p class="text-sm text-gray-500">تنظیم کوتا و قیمت‌گذاری vCPU</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                فعال
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="vcpu_included" class="block text-sm font-medium text-gray-700 mb-2">مقدار رایگان</label>
                <input type="number" id="vcpu_included" value="2" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="vcpu_upgrade_fee" class="block text-sm font-medium text-gray-700 mb-2">هزینه ارتقا (USD)</label>
                <input type="number" id="vcpu_upgrade_fee" value="5.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="vcpu_overage_cost" class="block text-sm font-medium text-gray-700 mb-2">هزینه اضافه/ماه (USD)</label>
                <input type="number" id="vcpu_overage_cost" value="2.50" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">صورتحساب خودکار</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Max RAM -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">حداکثر RAM (GB)</h3>
                    <p class="text-sm text-gray-500">تنظیم کوتا و قیمت‌گذاری حافظه</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                فعال
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="ram_included" class="block text-sm font-medium text-gray-700 mb-2">مقدار رایگان (GB)</label>
                <input type="number" id="ram_included" value="4" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="ram_upgrade_fee" class="block text-sm font-medium text-gray-700 mb-2">هزینه ارتقا (USD)</label>
                <input type="number" id="ram_upgrade_fee" value="3.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="ram_overage_cost" class="block text-sm font-medium text-gray-700 mb-2">هزینه اضافه/GB/ماه (USD)</label>
                <input type="number" id="ram_overage_cost" value="1.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">صورتحساب خودکار</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Max Instances -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">حداکثر اینستنس</h3>
                    <p class="text-sm text-gray-500">تنظیم کوتا و قیمت‌گذاری تعداد اینستنس</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                فعال
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="instances_included" class="block text-sm font-medium text-gray-700 mb-2">تعداد رایگان</label>
                <input type="number" id="instances_included" value="3" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="instances_upgrade_fee" class="block text-sm font-medium text-gray-700 mb-2">هزینه ارتقا (USD)</label>
                <input type="number" id="instances_upgrade_fee" value="10.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="instances_overage_cost" class="block text-sm font-medium text-gray-700 mb-2">هزینه اضافه/ماه (USD)</label>
                <input type="number" id="instances_overage_cost" value="5.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">صورتحساب خودکار</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Max Volumes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">حداکثر حجم‌ها</h3>
                    <p class="text-sm text-gray-500">تنظیم کوتا و قیمت‌گذاری حجم‌های ذخیره‌سازی</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                فعال
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="volumes_included" class="block text-sm font-medium text-gray-700 mb-2">تعداد رایگان</label>
                <input type="number" id="volumes_included" value="5" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="volumes_upgrade_fee" class="block text-sm font-medium text-gray-700 mb-2">هزینه ارتقا (USD)</label>
                <input type="number" id="volumes_upgrade_fee" value="2.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="volumes_overage_cost" class="block text-sm font-medium text-gray-700 mb-2">هزینه اضافه/ماه (USD)</label>
                <input type="number" id="volumes_overage_cost" value="1.50" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">صورتحساب خودکار</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Max Snapshots -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">حداکثر اسنپ‌شات</h3>
                    <p class="text-sm text-gray-500">تنظیم کوتا و قیمت‌گذاری اسنپ‌شات‌ها</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                فعال
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="snapshots_included" class="block text-sm font-medium text-gray-700 mb-2">تعداد رایگان</label>
                <input type="number" id="snapshots_included" value="10" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="snapshots_upgrade_fee" class="block text-sm font-medium text-gray-700 mb-2">هزینه ارتقا (USD)</label>
                <input type="number" id="snapshots_upgrade_fee" value="1.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="snapshots_overage_cost" class="block text-sm font-medium text-gray-700 mb-2">هزینه اضافه/ماه (USD)</label>
                <input type="number" id="snapshots_overage_cost" value="0.50" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">صورتحساب خودکار</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Max Floating IPs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-teal-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">حداکثر IP شناور</h3>
                    <p class="text-sm text-gray-500">تنظیم کوتا و قیمت‌گذاری IP‌های شناور</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                فعال
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="floating_ips_included" class="block text-sm font-medium text-gray-700 mb-2">تعداد رایگان</label>
                <input type="number" id="floating_ips_included" value="1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="floating_ips_upgrade_fee" class="block text-sm font-medium text-gray-700 mb-2">هزینه ارتقا (USD)</label>
                <input type="number" id="floating_ips_upgrade_fee" value="5.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="floating_ips_overage_cost" class="block text-sm font-medium text-gray-700 mb-2">هزینه اضافه/ماه (USD)</label>
                <input type="number" id="floating_ips_overage_cost" value="3.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">صورتحساب خودکار</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Max Networks -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">حداکثر شبکه</h3>
                    <p class="text-sm text-gray-500">تنظیم کوتا و قیمت‌گذاری شبکه‌ها</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                فعال
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="networks_included" class="block text-sm font-medium text-gray-700 mb-2">تعداد رایگان</label>
                <input type="number" id="networks_included" value="2" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="networks_upgrade_fee" class="block text-sm font-medium text-gray-700 mb-2">هزینه ارتقا (USD)</label>
                <input type="number" id="networks_upgrade_fee" value="2.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="networks_overage_cost" class="block text-sm font-medium text-gray-700 mb-2">هزینه اضافه/ماه (USD)</label>
                <input type="number" id="networks_overage_cost" value="1.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">صورتحساب خودکار</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
            ذخیره تنظیمات کوتا
        </button>
    </div>
</div>
@endsection
