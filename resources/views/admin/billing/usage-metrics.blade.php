@extends('layouts.admin')

@section('title', 'متریک‌های مصرف')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">متریک‌های مصرف</h1>
    <p class="mt-1 text-sm text-gray-500">پیکربندی متریک‌های اندازه‌گیری مصرف منابع</p>
</div>

<!-- Usage Metrics Configuration -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">پیکربندی متریک‌های مصرف</h2>
    </div>
    
    <div class="p-6">
        <form class="space-y-6">
            <!-- vCPU Hours -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="vcpu_enabled" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="vcpu_enabled" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-lg font-medium text-gray-900">ساعات vCPU</label>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        فعال
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="vcpu_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت هر ساعت (USD)</label>
                        <input type="number" id="vcpu_price" value="0.015" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="vcpu_rounding" class="block text-sm font-medium text-gray-700 mb-2">گرد کردن</label>
                        <select id="vcpu_rounding" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="ceil" selected>سقف (Ceil)</option>
                            <option value="floor">کف (Floor)</option>
                            <option value="round">گرد (Round)</option>
                        </select>
                    </div>
                    <div>
                        <label for="vcpu_minimum" class="block text-sm font-medium text-gray-700 mb-2">حداقل واحد</label>
                        <input type="number" id="vcpu_minimum" value="1" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="flex items-end">
                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>

            <!-- RAM Hours -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="ram_enabled" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="ram_enabled" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-lg font-medium text-gray-900">ساعات RAM</label>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        فعال
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="ram_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت هر GB/ساعت (USD)</label>
                        <input type="number" id="ram_price" value="0.002" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="ram_minimum" class="block text-sm font-medium text-gray-700 mb-2">حداقل واحد (GB)</label>
                        <input type="number" id="ram_minimum" value="1" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div></div>
                    <div class="flex items-end">
                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>

            <!-- Storage GB -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="storage_enabled" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="storage_enabled" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-lg font-medium text-gray-900">ذخیره‌سازی GB</label>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        فعال
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="storage_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت هر GB/ماه (USD)</label>
                        <input type="number" id="storage_price" value="0.10" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div></div>
                    <div></div>
                    <div class="flex items-end">
                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bandwidth GB -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="bandwidth_enabled" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="bandwidth_enabled" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-lg font-medium text-gray-900">پهنای باند GB</label>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        فعال
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="bandwidth_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت هر GB (USD)</label>
                        <input type="number" id="bandwidth_price" value="0.05" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div></div>
                    <div></div>
                    <div class="flex items-end">
                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>

            <!-- Floating IPs -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="floating_ip_enabled" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="floating_ip_enabled" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-lg font-medium text-gray-900">IP‌های شناور</label>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        فعال
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="floating_ip_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت هر IP/ساعت (USD)</label>
                        <input type="number" id="floating_ip_price" value="0.005" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div></div>
                    <div></div>
                    <div class="flex items-end">
                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>

            <!-- Snapshots -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="snapshots_enabled" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="snapshots_enabled" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-lg font-medium text-gray-900">اسنپ‌شات‌ها</label>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        فعال
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="snapshots_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت هر GB/ماه (USD)</label>
                        <input type="number" id="snapshots_price" value="0.05" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div></div>
                    <div></div>
                    <div class="flex items-end">
                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>

            <!-- Backups -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="backups_enabled" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="backups_enabled" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-lg font-medium text-gray-900">پشتیبان‌گیری</label>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        فعال
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="backups_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت هر GB/ماه (USD)</label>
                        <input type="number" id="backups_price" value="0.03" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div></div>
                    <div></div>
                    <div class="flex items-end">
                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>

            <!-- Volumes -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="volumes_enabled" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="volumes_enabled" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-lg font-medium text-gray-900">حجم‌ها</label>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        فعال
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="volumes_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت هر GB/ماه (USD)</label>
                        <input type="number" id="volumes_price" value="0.08" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div></div>
                    <div></div>
                    <div class="flex items-end">
                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>

            <!-- Save All Button -->
            <div class="flex justify-end pt-6">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                    ذخیره همه تنظیمات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
