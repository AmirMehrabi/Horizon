@extends('layouts.admin')

@section('title', 'ایجاد پلن جدید')

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
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.billing.plans') }}" class="text-gray-500 hover:text-gray-700 {{ $isRtl ? 'ml-4' : 'mr-4' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $isRtl ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"></path>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-900">ایجاد پلن جدید</h1>
    </div>
    <p class="text-sm text-gray-500">تعریف پلن قیمت‌گذاری جدید برای خدمات ابری</p>
</div>

<form class="space-y-8">
    <!-- Basic Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات پایه</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="plan_name" class="block text-sm font-medium text-gray-700 mb-2">نام پلن</label>
                <input type="text" id="plan_name" name="plan_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="مثال: پلن پایه">
            </div>
            <div>
                <label for="plan_description" class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
                <input type="text" id="plan_description" name="plan_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="توضیح کوتاه از پلن">
            </div>
            <div>
                <label for="visibility" class="block text-sm font-medium text-gray-700 mb-2">نمایش</label>
                <select id="visibility" name="visibility" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="public">عمومی</option>
                    <option value="admin_only">فقط ادمین</option>
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">وضعیت</label>
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="active">فعال</option>
                    <option value="inactive">غیرفعال</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Compute Resources -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">منابع محاسباتی</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="vcpu" class="block text-sm font-medium text-gray-700 mb-2">vCPU</label>
                <input type="number" id="vcpu" name="vcpu" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="ram_gb" class="block text-sm font-medium text-gray-700 mb-2">RAM (GB)</label>
                <input type="number" id="ram_gb" name="ram_gb" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="boot_disk_gb" class="block text-sm font-medium text-gray-700 mb-2">دیسک بوت (GB)</label>
                <input type="number" id="boot_disk_gb" name="boot_disk_gb" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="bandwidth_limit" class="block text-sm font-medium text-gray-700 mb-2">محدودیت پهنای باند (Mbps)</label>
                <input type="number" id="bandwidth_limit" name="bandwidth_limit" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="monthly_bandwidth_cap" class="block text-sm font-medium text-gray-700 mb-2">سقف ماهانه پهنای باند (TB)</label>
                <input type="number" id="monthly_bandwidth_cap" name="monthly_bandwidth_cap" min="0" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">انواع حجم مجاز</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="volume_types[]" value="ssd" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">SSD</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="volume_types[]" value="hdd" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">HDD</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Models -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">مدل‌های قیمت‌گذاری</h2>
        
        <!-- Fixed Monthly -->
        <div class="mb-6">
            <label class="flex items-center mb-3">
                <input type="checkbox" id="enable_fixed_monthly" name="enable_fixed_monthly" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">قیمت ثابت ماهانه</span>
            </label>
            <div id="fixed_monthly_fields" class="{{ $isRtl ? 'mr-7' : 'ml-7' }} grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="fixed_monthly_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت ماهانه (USD)</label>
                    <input type="number" id="fixed_monthly_price" name="fixed_monthly_price" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>
        </div>

        <!-- Hourly -->
        <div class="mb-6">
            <label class="flex items-center mb-3">
                <input type="checkbox" id="enable_hourly" name="enable_hourly" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">قیمت ساعتی</span>
            </label>
            <div id="hourly_fields" class="{{ $isRtl ? 'mr-7' : 'ml-7' }} grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="hourly_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت ساعتی (USD)</label>
                    <input type="number" id="hourly_price" name="hourly_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>
        </div>

        <!-- Pay as You Go -->
        <div class="mb-6">
            <label class="flex items-center mb-3">
                <input type="checkbox" id="enable_payg" name="enable_payg" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">پرداخت بر اساس مصرف</span>
            </label>
            <div id="payg_fields" class="{{ $isRtl ? 'mr-7' : 'ml-7' }} grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="vcpu_hour_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت vCPU/ساعت</label>
                    <input type="number" id="vcpu_hour_price" name="vcpu_hour_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="ram_hour_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت RAM/ساعت</label>
                    <input type="number" id="ram_hour_price" name="ram_hour_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="storage_gb_month_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت ذخیره‌سازی GB/ماه</label>
                    <input type="number" id="storage_gb_month_price" name="storage_gb_month_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="bandwidth_gb_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت پهنای باند GB</label>
                    <input type="number" id="bandwidth_gb_price" name="bandwidth_gb_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="floating_ip_hour_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت IP شناور/ساعت</label>
                    <input type="number" id="floating_ip_hour_price" name="floating_ip_hour_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="backup_gb_month_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت پشتیبان GB/ماه</label>
                    <input type="number" id="backup_gb_month_price" name="backup_gb_month_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>
        </div>

        <!-- Windows License -->
        <div class="mb-6">
            <label class="flex items-center mb-3">
                <input type="checkbox" id="enable_windows_license" name="enable_windows_license" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">لایسنس ویندوز</span>
            </label>
            <div id="windows_license_fields" class="{{ $isRtl ? 'mr-7' : 'ml-7' }} grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="windows_license_hourly" class="block text-sm font-medium text-gray-700 mb-2">قیمت لایسنس ویندوز/ساعت</label>
                    <input type="number" id="windows_license_hourly" name="windows_license_hourly" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>
        </div>
    </div>

    <!-- Add-ons -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">افزونه‌ها</h2>
        
        <!-- Automated Backups -->
        <div class="mb-6">
            <label class="flex items-center mb-3">
                <input type="checkbox" id="enable_automated_backups" name="enable_automated_backups" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">پشتیبان‌گیری خودکار</span>
            </label>
            <div id="automated_backups_fields" class="{{ $isRtl ? 'mr-7' : 'ml-7' }} grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="automated_backups_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت پشتیبان‌گیری GB/ماه</label>
                    <input type="number" id="automated_backups_price" name="automated_backups_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>
        </div>

        <!-- Snapshots -->
        <div class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="snapshots_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت اسنپ‌شات GB/ماه</label>
                    <input type="number" id="snapshots_price" name="snapshots_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>
        </div>

        <!-- Additional IPv4 -->
        <div class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="additional_ipv4_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت IPv4 اضافی/ساعت</label>
                    <input type="number" id="additional_ipv4_price" name="additional_ipv4_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>
        </div>

        <!-- Additional Volumes -->
        <div class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="additional_volumes_price" class="block text-sm font-medium text-gray-700 mb-2">قیمت حجم اضافی GB/ماه</label>
                    <input type="number" id="additional_volumes_price" name="additional_volumes_price" step="0.001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
        <a href="{{ route('admin.billing.plans') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors">
            انصراف
        </a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
            ایجاد پلن
        </button>
    </div>
</form>

<script>
// Toggle field visibility based on checkbox state
document.addEventListener('DOMContentLoaded', function() {
    const toggleFields = [
        { checkbox: 'enable_fixed_monthly', fields: 'fixed_monthly_fields' },
        { checkbox: 'enable_hourly', fields: 'hourly_fields' },
        { checkbox: 'enable_payg', fields: 'payg_fields' },
        { checkbox: 'enable_windows_license', fields: 'windows_license_fields' },
        { checkbox: 'enable_automated_backups', fields: 'automated_backups_fields' }
    ];

    toggleFields.forEach(function(item) {
        const checkbox = document.getElementById(item.checkbox);
        const fields = document.getElementById(item.fields);
        
        if (checkbox && fields) {
            // Initial state
            fields.style.display = checkbox.checked ? 'grid' : 'none';
            
            // Toggle on change
            checkbox.addEventListener('change', function() {
                fields.style.display = this.checked ? 'grid' : 'none';
            });
        }
    });
});
</script>
@endsection
