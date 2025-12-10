@extends('layouts.admin')

@section('title', 'اتوماسیون‌های صورتحساب')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">اتوماسیون‌های صورتحساب</h1>
    <p class="mt-1 text-sm text-gray-500">پیکربندی قوانین خودکار برای مدیریت صورتحساب</p>
</div>

<!-- Automation Rules -->
<div class="space-y-6">
    <!-- Account Suspension -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">تعلیق حساب</h3>
                    <p class="text-sm text-gray-500">تعلیق خودکار حساب‌های بدهکار</p>
                </div>
            </div>
            <div class="flex items-center">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:{{ $isRtl ? 'right' : 'left' }}-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-900">فعال</span>
                </label>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="suspension_hours" class="block text-sm font-medium text-gray-700 mb-2">تعلیق پس از (ساعت)</label>
                <input type="number" id="suspension_hours" value="24" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <p class="mt-1 text-xs text-gray-500">حساب پس از این مدت تعلیق می‌شود</p>
            </div>
            <div>
                <label class="flex items-center mt-6">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">ارسال ایمیل هشدار قبل از تعلیق</span>
                </label>
            </div>
            <div>
                <label for="warning_hours" class="block text-sm font-medium text-gray-700 mb-2">ارسال هشدار (ساعت قبل)</label>
                <input type="number" id="warning_hours" value="6" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
        </div>
        
        <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-400 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-yellow-800">توجه</h4>
                    <p class="text-sm text-yellow-700">تعلیق حساب باعث قطع دسترسی به تمام سرویس‌ها می‌شود</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Deletion -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">حذف حساب</h3>
                    <p class="text-sm text-gray-500">حذف خودکار حساب‌های معوق طولانی مدت</p>
                </div>
            </div>
            <div class="flex items-center">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:{{ $isRtl ? 'right' : 'left' }}-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-900">فعال</span>
                </label>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="deletion_days" class="block text-sm font-medium text-gray-700 mb-2">حذف پس از (روز)</label>
                <input type="number" id="deletion_days" value="14" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <p class="mt-1 text-xs text-gray-500">حساب پس از این مدت حذف می‌شود</p>
            </div>
            <div>
                <label for="archive_days" class="block text-sm font-medium text-gray-700 mb-2">آرشیو قبل از حذف (روز)</label>
                <input type="number" id="archive_days" value="3" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <p class="mt-1 text-xs text-gray-500">داده‌ها قبل از حذف آرشیو می‌شوند</p>
            </div>
            <div>
                <label class="flex items-center mt-6">
                    <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">ارسال اطلاعیه نهایی</span>
                </label>
            </div>
        </div>
        
        <div class="mt-4 p-4 bg-red-50 rounded-lg border border-red-200">
            <div class="flex">
                <svg class="w-5 h-5 text-red-400 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-red-800">هشدار</h4>
                    <p class="text-sm text-red-700">حذف حساب غیرقابل برگشت است و تمام داده‌ها از بین می‌رود</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto Invoicing -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">صدور خودکار فاکتور</h3>
                    <p class="text-sm text-gray-500">تولید خودکار فاکتورهای دوره‌ای</p>
                </div>
            </div>
            <div class="flex items-center">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:{{ $isRtl ? 'right' : 'left' }}-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-900">فعال</span>
                </label>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-2">فاکتور مصرف روزانه</h4>
                    <label class="flex items-center">
                        <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">تولید فاکتور روزانه برای مصرف منابع</span>
                    </label>
                    <div class="mt-2 {{ $isRtl ? 'mr-6' : 'ml-6' }}">
                        <label for="daily_invoice_time" class="block text-sm text-gray-600 mb-1">زمان صدور</label>
                        <input type="time" id="daily_invoice_time" value="23:59" class="block border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-2">فاکتور خلاصه ماهانه</h4>
                    <label class="flex items-center">
                        <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">تولید فاکتور خلاصه در پایان ماه</span>
                    </label>
                    <div class="mt-2 {{ $isRtl ? 'mr-6' : 'ml-6' }}">
                        <label for="monthly_invoice_day" class="block text-sm text-gray-600 mb-1">روز صدور</label>
                        <select id="monthly_invoice_day" class="block border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="last">آخرین روز ماه</option>
                            <option value="1">روز اول ماه بعد</option>
                            <option value="15">روز 15 ماه</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-2">تنظیمات اضافی</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">ارسال خودکار ایمیل فاکتور</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">تجمیع فاکتورهای کوچک</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">اعمال تخفیف‌های فعال</span>
                        </label>
                    </div>
                </div>
                
                <div>
                    <label for="min_invoice_amount" class="block text-sm font-medium text-gray-700 mb-2">حداقل مبلغ فاکتور (USD)</label>
                    <input type="number" id="min_invoice_amount" value="1.00" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <p class="mt-1 text-xs text-gray-500">فاکتورهای کمتر از این مبلغ صادر نمی‌شوند</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto Renewal -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">تمدید خودکار</h3>
                    <p class="text-sm text-gray-500">تمدید خودکار سرویس‌ها و اشتراک‌ها</p>
                </div>
            </div>
            <div class="flex items-center">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:{{ $isRtl ? 'right' : 'left' }}-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-900">فعال</span>
                </label>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="renewal_days_before" class="block text-sm font-medium text-gray-700 mb-2">تمدید چند روز قبل از انقضا</label>
                <input type="number" id="renewal_days_before" value="3" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="renewal_retry_attempts" class="block text-sm font-medium text-gray-700 mb-2">تعداد تلاش مجدد</label>
                <input type="number" id="renewal_retry_attempts" value="3" min="1" max="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="renewal_retry_interval" class="block text-sm font-medium text-gray-700 mb-2">فاصله تلاش مجدد (ساعت)</label>
                <input type="number" id="renewal_retry_interval" value="24" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
        </div>
        
        <div class="mt-4 space-y-2">
            <label class="flex items-center">
                <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">ارسال اطلاعیه قبل از تمدید</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">تمدید فقط در صورت موجودی کافی</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">تمدید حتی در صورت بدهی</span>
            </label>
        </div>
    </div>

    <!-- Payment Retry -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">تلاش مجدد پرداخت</h3>
                    <p class="text-sm text-gray-500">تلاش مجدد برای پرداخت‌های ناموفق</p>
                </div>
            </div>
            <div class="flex items-center">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:{{ $isRtl ? 'right' : 'left' }}-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="{{ $isRtl ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-900">فعال</span>
                </label>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="retry_max_attempts" class="block text-sm font-medium text-gray-700 mb-2">حداکثر تلاش</label>
                <input type="number" id="retry_max_attempts" value="5" min="1" max="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="retry_first_interval" class="block text-sm font-medium text-gray-700 mb-2">اولین تلاش (ساعت)</label>
                <input type="number" id="retry_first_interval" value="6" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="retry_second_interval" class="block text-sm font-medium text-gray-700 mb-2">دومین تلاش (روز)</label>
                <input type="number" id="retry_second_interval" value="1" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="retry_final_interval" class="block text-sm font-medium text-gray-700 mb-2">تلاش‌های نهایی (روز)</label>
                <input type="number" id="retry_final_interval" value="7" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
        </div>
        
        <div class="mt-4 space-y-2">
            <label class="flex items-center">
                <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">ارسال اطلاعیه پرداخت ناموفق</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">تغییر درگاه پرداخت در تلاش مجدد</span>
            </label>
        </div>
    </div>
</div>

<!-- Save Button -->
<div class="flex justify-end mt-8">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
        ذخیره تمام تنظیمات
    </button>
</div>
@endsection
