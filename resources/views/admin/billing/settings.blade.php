@extends('layouts.admin')

@section('title', 'تنظیمات صورتحساب')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">تنظیمات صورتحساب</h1>
    <p class="mt-1 text-sm text-gray-500">پیکربندی سیستم صورتحساب و پرداخت</p>
</div>

<form class="space-y-8">
    <!-- Billing Modes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">حالت‌های صورتحساب</h2>
        <div class="space-y-4">
            <div class="flex items-center">
                <input id="prepaid" name="billing_mode" type="radio" value="prepaid" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                <label for="prepaid" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} block text-sm font-medium text-gray-700">
                    پیش‌پرداخت (Prepaid)
                    <span class="block text-xs text-gray-500">کاربران باید قبل از استفاده شارژ کنند</span>
                </label>
            </div>
            <div class="flex items-center">
                <input id="postpaid" name="billing_mode" type="radio" value="postpaid" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                <label for="postpaid" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} block text-sm font-medium text-gray-700">
                    پس‌پرداخت (Postpaid)
                    <span class="block text-xs text-gray-500">کاربران بعد از استفاده پرداخت می‌کنند</span>
                </label>
            </div>
            <div class="flex items-center">
                <input id="hybrid" name="billing_mode" type="radio" value="hybrid" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                <label for="hybrid" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} block text-sm font-medium text-gray-700">
                    ترکیبی (Hybrid)
                    <span class="block text-xs text-gray-500">ترکیب پیش‌پرداخت و پس‌پرداخت</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Billing Cycles -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">چرخه‌های صورتحساب</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center">
                <input id="hourly" name="billing_cycles" type="checkbox" value="hourly" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label for="hourly" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} block text-sm font-medium text-gray-700">ساعتی</label>
            </div>
            <div class="flex items-center">
                <input id="daily" name="billing_cycles" type="checkbox" value="daily" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label for="daily" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} block text-sm font-medium text-gray-700">روزانه</label>
            </div>
            <div class="flex items-center">
                <input id="monthly" name="billing_cycles" type="checkbox" value="monthly" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label for="monthly" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} block text-sm font-medium text-gray-700">ماهانه</label>
            </div>
        </div>
    </div>

    <!-- Invoice Generation -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">تولید فاکتور</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">تولید خودکار فاکتور</span>
                </label>
            </div>
            <div>
                <label for="grace_period_hours" class="block text-sm font-medium text-gray-700 mb-2">مهلت پرداخت (ساعت)</label>
                <input type="number" id="grace_period_hours" name="grace_period_hours" value="24" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="suspension_days" class="block text-sm font-medium text-gray-700 mb-2">روزهای قبل از تعلیق</label>
                <input type="number" id="suspension_days" name="suspension_days" value="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="deletion_days" class="block text-sm font-medium text-gray-700 mb-2">روزهای قبل از حذف</label>
                <input type="number" id="deletion_days" name="deletion_days" value="14" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
        </div>
    </div>

    <!-- Tax Rules -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">قوانین مالیات</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="global_tax" class="block text-sm font-medium text-gray-700 mb-2">مالیات جهانی (%)</label>
                <input type="number" id="global_tax" name="global_tax" value="0" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">قوانین مخصوص کشور</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">اعتبارسنجی شناسه مالیاتی</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">شارژ معکوس</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Currency Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">تنظیمات ارز</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="base_currency" class="block text-sm font-medium text-gray-700 mb-2">ارز پایه</label>
                <select id="base_currency" name="base_currency" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="USD" selected>دلار آمریکا (USD)</option>
                    <option value="EUR">یورو (EUR)</option>
                    <option value="IRR">ریال ایران (IRR)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ارزهای پشتیبانی شده</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">USD</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">EUR</span>
                    </label>
                </div>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">API نرخ ارز</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Rounding Rules -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">قوانین گرد کردن</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="cpu_rounding" class="block text-sm font-medium text-gray-700 mb-2">گرد کردن CPU</label>
                <select id="cpu_rounding" name="cpu_rounding" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="ceil" selected>سقف (Ceil)</option>
                    <option value="floor">کف (Floor)</option>
                    <option value="round">گرد (Round)</option>
                </select>
            </div>
            <div>
                <label for="bandwidth_rounding" class="block text-sm font-medium text-gray-700 mb-2">گرد کردن پهنای باند</label>
                <select id="bandwidth_rounding" name="bandwidth_rounding" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="ceil" selected>سقف (Ceil)</option>
                    <option value="floor">کف (Floor)</option>
                    <option value="round">گرد (Round)</option>
                </select>
            </div>
            <div>
                <label for="decimal_precision" class="block text-sm font-medium text-gray-700 mb-2">دقت اعشار</label>
                <input type="number" id="decimal_precision" name="decimal_precision" value="3" min="0" max="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
        </div>
    </div>

    <!-- Late Fees -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">جریمه تأخیر</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="late_fee_percentage" class="block text-sm font-medium text-gray-700 mb-2">درصد جریمه</label>
                <input type="number" id="late_fee_percentage" name="late_fee_percentage" value="0" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="late_fee_flat" class="block text-sm font-medium text-gray-700 mb-2">مبلغ ثابت جریمه</label>
                <input type="number" id="late_fee_flat" name="late_fee_flat" value="0" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="recurring_interval" class="block text-sm font-medium text-gray-700 mb-2">بازه تکرار (روز)</label>
                <input type="number" id="recurring_interval" name="recurring_interval" value="7" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
        </div>
    </div>

    <!-- Invoice Number Format -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">فرمت شماره فاکتور</h2>
        <div>
            <label for="invoice_format" class="block text-sm font-medium text-gray-700 mb-2">الگو</label>
            <input type="text" id="invoice_format" name="invoice_format" value="INV-{YEAR}-{SEQUENCE}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <p class="mt-1 text-xs text-gray-500">متغیرهای موجود: {YEAR}, {MONTH}, {DAY}, {SEQUENCE}</p>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
            ذخیره تنظیمات
        </button>
    </div>
</form>
@endsection
