@extends('layouts.admin')

@section('title', 'تراکنش‌ها')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">تراکنش‌ها</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت و نظارت بر تمام تراکنش‌های مالی</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">فیلترها</h2>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div>
            <label for="gateway_filter" class="block text-sm font-medium text-gray-700 mb-2">درگاه پرداخت</label>
            <select id="gateway_filter" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">همه درگاه‌ها</option>
                <option value="stripe">Stripe</option>
                <option value="paypal">PayPal</option>
                <option value="zarinpal">زرین‌پال</option>
                <option value="mellat">ملت</option>
            </select>
        </div>
        <div>
            <label for="status_filter" class="block text-sm font-medium text-gray-700 mb-2">وضعیت</label>
            <select id="status_filter" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">همه</option>
                <option value="completed">موفق</option>
                <option value="failed">ناموفق</option>
                <option value="pending">در انتظار</option>
                <option value="refunded">برگشت داده شده</option>
            </select>
        </div>
        <div>
            <label for="customer_filter" class="block text-sm font-medium text-gray-700 mb-2">مشتری</label>
            <input type="text" id="customer_filter" placeholder="جستجو مشتری..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <div>
            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">از تاریخ</label>
            <input type="date" id="date_from" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <div>
            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">تا تاریخ</label>
            <input type="date" id="date_to" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
    </div>
    <div class="flex justify-end mt-4">
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
            اعمال فیلتر
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل تراکنش‌ها</p>
                <p class="text-2xl font-bold text-gray-900">2,456</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">موفق</p>
                <p class="text-2xl font-bold text-gray-900">2,234</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">ناموفق</p>
                <p class="text-2xl font-bold text-gray-900">156</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">در انتظار</p>
                <p class="text-2xl font-bold text-gray-900">66</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل مبلغ</p>
                <p class="text-2xl font-bold text-gray-900">$89,450</p>
            </div>
        </div>
    </div>
</div>

<!-- Transactions List -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">لیست تراکنش‌ها</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        شناسه تراکنش
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        مشتری
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        نوع
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        مبلغ
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        درگاه
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        تاریخ
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        وضعیت
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">عملیات</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">TXN-2024-001234</div>
                        <div class="text-sm text-gray-500">Stripe: ch_3N...</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                <span class="text-xs font-medium text-blue-600">AC</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">ACME Corporation</div>
                                <div class="text-sm text-gray-500">acme@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            پرداخت
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-green-600">+$234.50</div>
                        <div class="text-sm text-gray-500">INV-2024-001</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded bg-blue-600 flex items-center justify-center {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                <span class="text-xs font-bold text-white">S</span>
                            </div>
                            <span class="text-sm text-gray-900">Stripe</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>2024-01-15 14:30</div>
                        <div class="text-xs text-gray-500">2 ساعت پیش</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            موفق
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button onclick="showTransactionDetails('TXN-2024-001234')" class="text-blue-600 hover:text-blue-900">جزئیات</button>
                            <button class="text-green-600 hover:text-green-900">رسید</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">TXN-2024-001233</div>
                        <div class="text-sm text-gray-500">PayPal: PAYID-M...</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                <span class="text-xs font-medium text-purple-600">TS</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">TechStart Inc</div>
                                <div class="text-sm text-gray-500">tech@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            شارژ کیف پول
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-green-600">+$500.00</div>
                        <div class="text-sm text-gray-500">شارژ دستی</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded bg-blue-500 flex items-center justify-center {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                <span class="text-xs font-bold text-white">P</span>
                            </div>
                            <span class="text-sm text-gray-900">PayPal</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>2024-01-15 12:15</div>
                        <div class="text-xs text-gray-500">4 ساعت پیش</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            موفق
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button onclick="showTransactionDetails('TXN-2024-001233')" class="text-blue-600 hover:text-blue-900">جزئیات</button>
                            <button class="text-green-600 hover:text-green-900">رسید</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">TXN-2024-001232</div>
                        <div class="text-sm text-gray-500">زرین‌پال: A00...</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                <span class="text-xs font-medium text-red-600">DS</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Digital Solutions</div>
                                <div class="text-sm text-gray-500">digital@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            تلاش پرداخت ناموفق
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-red-600">-$89.99</div>
                        <div class="text-sm text-gray-500">INV-2024-002</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded bg-green-600 flex items-center justify-center {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                <span class="text-xs font-bold text-white">ز</span>
                            </div>
                            <span class="text-sm text-gray-900">زرین‌پال</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>2024-01-15 09:45</div>
                        <div class="text-xs text-gray-500">7 ساعت پیش</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            ناموفق
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button onclick="showTransactionDetails('TXN-2024-001232')" class="text-blue-600 hover:text-blue-900">جزئیات</button>
                            <button class="text-orange-600 hover:text-orange-900">تلاش مجدد</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">TXN-2024-001231</div>
                        <div class="text-sm text-gray-500">Refund: re_3N...</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                <span class="text-xs font-medium text-gray-600">SC</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">StartupCorp</div>
                                <div class="text-sm text-gray-500">startup@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            برگشت وجه
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-purple-600">-$45.00</div>
                        <div class="text-sm text-gray-500">لغو سرویس</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded bg-blue-600 flex items-center justify-center {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                <span class="text-xs font-bold text-white">S</span>
                            </div>
                            <span class="text-sm text-gray-900">Stripe</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>2024-01-14 16:20</div>
                        <div class="text-xs text-gray-500">1 روز پیش</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            برگشت داده شده
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button onclick="showTransactionDetails('TXN-2024-001231')" class="text-blue-600 hover:text-blue-900">جزئیات</button>
                            <button class="text-green-600 hover:text-green-900">رسید</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">TXN-2024-001230</div>
                        <div class="text-sm text-gray-500">Auto: wallet_...</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                <span class="text-xs font-medium text-indigo-600">NE</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">NewEnterprise</div>
                                <div class="text-sm text-gray-500">new@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            شارژ خودکار
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-blue-600">$125.00</div>
                        <div class="text-sm text-gray-500">شارژ خودکار</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded bg-gray-600 flex items-center justify-center {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                <span class="text-xs font-bold text-white">W</span>
                            </div>
                            <span class="text-sm text-gray-900">کیف پول</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>2024-01-14 08:00</div>
                        <div class="text-xs text-gray-500">1 روز پیش</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            در انتظار
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button onclick="showTransactionDetails('TXN-2024-001230')" class="text-blue-600 hover:text-blue-900">جزئیات</button>
                            <button class="text-orange-600 hover:text-orange-900">لغو</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                قبلی
            </a>
            <a href="#" class="{{ $isRtl ? 'mr-3' : 'ml-3' }} relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                بعدی
            </a>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    نمایش <span class="font-medium">1</span> تا <span class="font-medium">10</span> از <span class="font-medium">2,456</span> نتیجه
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px {{ $isRtl ? 'space-x-reverse' : '' }}" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-{{ $isRtl ? 'r' : 'l' }}-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">قبلی</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="{{ $isRtl ? 'M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z' : 'M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z' }}" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        1
                    </a>
                    <a href="#" class="bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                        2
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        3
                    </a>
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-{{ $isRtl ? 'l' : 'r' }}-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">بعدی</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="{{ $isRtl ? 'M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z' : 'M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z' }}" clip-rule="evenodd" />
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Details Modal -->
<div id="transactionDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">جزئیات تراکنش</h3>
                <button onclick="closeTransactionDetailsModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4" id="transactionDetailsContent">
                <!-- Dynamic content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showTransactionDetails(transactionId) {
    // Sample transaction details - in real app, this would be fetched from server
    const sampleDetails = {
        'TXN-2024-001234': {
            id: 'TXN-2024-001234',
            gateway_id: 'ch_3NqJKl2eZvKYlo2C1234567890',
            customer: 'ACME Corporation (acme@example.com)',
            type: 'پرداخت',
            amount: '$234.50',
            gateway: 'Stripe',
            status: 'موفق',
            date: '2024-01-15 14:30:25',
            invoice: 'INV-2024-001',
            description: 'پرداخت فاکتور ماهانه',
            fees: '$6.79',
            net_amount: '$227.71'
        }
    };
    
    const details = sampleDetails[transactionId] || {};
    
    const content = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">شناسه تراکنش</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm">${details.id || 'نامشخص'}</div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">شناسه درگاه</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm font-mono">${details.gateway_id || 'نامشخص'}</div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">مشتری</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm">${details.customer || 'نامشخص'}</div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">نوع تراکنش</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm">${details.type || 'نامشخص'}</div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">مبلغ</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm font-medium">${details.amount || 'نامشخص'}</div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">درگاه پرداخت</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm">${details.gateway || 'نامشخص'}</div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">وضعیت</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        ${details.status || 'نامشخص'}
                    </span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">تاریخ و زمان</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm">${details.date || 'نامشخص'}</div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">فاکتور مرتبط</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm">${details.invoice || 'ندارد'}</div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">کارمزد</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm">${details.fees || 'نامشخص'}</div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">توضیحات</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md text-sm">${details.description || 'توضیحی ثبت نشده'}</div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }} pt-4 border-t">
            <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors">
                دانلود رسید
            </button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                ارسال ایمیل
            </button>
        </div>
    `;
    
    document.getElementById('transactionDetailsContent').innerHTML = content;
    document.getElementById('transactionDetailsModal').classList.remove('hidden');
}

function closeTransactionDetailsModal() {
    document.getElementById('transactionDetailsModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('transactionDetailsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTransactionDetailsModal();
    }
});
</script>
@endsection
