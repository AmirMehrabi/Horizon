@extends('layouts.admin')

@section('title', 'جزئیات فاکتور')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">جزئیات فاکتور #{{ $id }}</h1>
            <p class="mt-1 text-sm text-gray-500">مشاهده و مدیریت جزئیات فاکتور</p>
        </div>
        <div class="flex space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
            <a href="{{ route('admin.billing.invoices') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                بازگشت به لیست
            </a>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                دانلود PDF
            </button>
        </div>
    </div>
</div>

<!-- Invoice Status -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
            <div class="flex-shrink-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    پرداخت شده
                </span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">فاکتور #INV-2024-{{ $id }}</h3>
                <p class="text-sm text-gray-500">تاریخ صدور: ۱۴۰۳/۰۹/۱۵</p>
            </div>
        </div>
        <div class="text-{{ $isRtl ? 'left' : 'right' }}">
            <p class="text-2xl font-bold text-gray-900">۲,۵۰۰,۰۰۰ تومان</p>
            <p class="text-sm text-gray-500">سررسید: ۱۴۰۳/۰۹/۳۰</p>
        </div>
    </div>
</div>

<div class="dd grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Invoice Details -->
    <div class="lg:col-span-2">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات مشتری</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">نام مشتری</label>
                    <p class="mt-1 text-sm text-gray-900">علی احمدی</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">ایمیل</label>
                    <p class="mt-1 text-sm text-gray-900">ali.ahmadi@example.com</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">شماره تماس</label>
                    <p class="mt-1 text-sm text-gray-900">۰۹۱۲۳۴۵۶۷۸۹</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">شناسه مشتری</label>
                    <p class="mt-1 text-sm text-gray-900">CUST-{{ $id }}01</p>
                </div>
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">آیتم‌های فاکتور</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-{{ $isRtl ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">شرح</th>
                            <th class="px-6 py-3 text-{{ $isRtl ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">مقدار</th>
                            <th class="px-6 py-3 text-{{ $isRtl ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">قیمت واحد</th>
                            <th class="px-6 py-3 text-{{ $isRtl ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">جمع</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>
                                    <p class="font-medium">پلن استاندارد</p>
                                    <p class="text-gray-500">۴ vCPU, ۸GB RAM, ۱۰۰GB Storage</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۱</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۲,۰۰۰,۰۰۰ تومان</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۲,۰۰۰,۰۰۰ تومان</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>
                                    <p class="font-medium">فضای اضافی</p>
                                    <p class="text-gray-500">۵۰GB اضافی</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۵۰</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۵,۰۰۰ تومان</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۲۵۰,۰۰۰ تومان</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>
                                    <p class="font-medium">IP اضافی</p>
                                    <p class="text-gray-500">آدرس IP عمومی</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۲</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۱۲۵,۰۰۰ تومان</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۲۵۰,۰۰۰ تومان</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment History -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">تاریخچه پرداخت</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center space-x-3 {{ $isRtl ? 'space-x-reverse' : '' }}">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-900">پرداخت موفق</p>
                            <p class="text-sm text-green-700">۱۴۰۳/۰۹/۱۶ - ۱۴:۳۰</p>
                        </div>
                    </div>
                    <div class="text-{{ $isRtl ? 'left' : 'right' }}">
                        <p class="text-sm font-medium text-green-900">۲,۵۰۰,۰۰۰ تومان</p>
                        <p class="text-xs text-green-700">شماره تراکنش: TXN-{{ $id }}789</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Invoice Summary -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">خلاصه فاکتور</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">جمع کل:</span>
                    <span class="text-sm font-medium text-gray-900">۲,۵۰۰,۰۰۰ تومان</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">تخفیف:</span>
                    <span class="text-sm font-medium text-gray-900">۰ تومان</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">مالیات:</span>
                    <span class="text-sm font-medium text-gray-900">۰ تومان</span>
                </div>
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex justify-between">
                        <span class="text-base font-medium text-gray-900">مبلغ نهایی:</span>
                        <span class="text-base font-bold text-gray-900">۲,۵۰۰,۰۰۰ تومان</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">عملیات</h3>
            <div class="space-y-3">
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    ارسال ایمیل فاکتور
                </button>
                <button class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    علامت‌گذاری به عنوان پرداخت شده
                </button>
                <button class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    افزودن آیتم جدید
                </button>
                <button class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    لغو فاکتور
                </button>
            </div>
        </div>

        <!-- Invoice Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات فاکتور</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">شماره فاکتور</label>
                    <p class="mt-1 text-sm text-gray-900">INV-2024-{{ $id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">تاریخ صدور</label>
                    <p class="mt-1 text-sm text-gray-900">۱۴۰۳/۰۹/۱۵</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">تاریخ سررسید</label>
                    <p class="mt-1 text-sm text-gray-900">۱۴۰۳/۰۹/۳۰</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">روش پرداخت</label>
                    <p class="mt-1 text-sm text-gray-900">کارت بانکی</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">وضعیت</label>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        پرداخت شده
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
