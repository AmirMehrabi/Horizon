@extends('layouts.admin')

@section('title', 'فاکتورها')

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
    <h1 class="text-3xl font-bold text-gray-900">فاکتورها</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت فاکتورها و پرداخت‌ها</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">فیلترها</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="status_filter" class="block text-sm font-medium text-gray-700 mb-2">وضعیت</label>
            <select id="status_filter" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">همه</option>
                <option value="paid">پرداخت شده</option>
                <option value="pending">در انتظار</option>
                <option value="overdue">معوق</option>
                <option value="cancelled">لغو شده</option>
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
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل فاکتورها</p>
                <p class="text-2xl font-bold text-gray-900">1,234</p>
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
                <p class="text-sm text-gray-500 font-medium">پرداخت شده</p>
                <p class="text-2xl font-bold text-gray-900">987</p>
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
                <p class="text-2xl font-bold text-gray-900">156</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">معوق</p>
                <p class="text-2xl font-bold text-gray-900">91</p>
            </div>
        </div>
    </div>
</div>

<!-- Invoices List -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">لیست فاکتورها</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        شماره فاکتور
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        مشتری
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        مبلغ
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        تاریخ صدور
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        سررسید
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
                <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('admin.billing.invoices.show', 'INV-2024-001') }}'">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">INV-2024-001</div>
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
                        <div class="text-sm font-medium text-gray-900">$234.50</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-01-15
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-02-15
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            پرداخت شده
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button class="text-blue-600 hover:text-blue-900">مشاهده</button>
                            <button class="text-green-600 hover:text-green-900">دانلود PDF</button>
                        </div>
                    </td>
                </tr>
                
                <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('admin.billing.invoices.show', 'INV-2024-002') }}'">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">INV-2024-002</div>
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
                        <div class="text-sm font-medium text-gray-900">$89.99</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-01-20
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-02-20
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            در انتظار
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button class="text-blue-600 hover:text-blue-900">مشاهده</button>
                            <button class="text-orange-600 hover:text-orange-900">ارسال یادآوری</button>
                        </div>
                    </td>
                </tr>
                
                <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('admin.billing.invoices.show', 'INV-2024-003') }}'">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">INV-2024-003</div>
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
                        <div class="text-sm font-medium text-gray-900">$156.75</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-01-10
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-02-10
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            معوق
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button class="text-blue-600 hover:text-blue-900">مشاهده</button>
                            <button class="text-red-600 hover:text-red-900">تعلیق سرویس</button>
                        </div>
                    </td>
                </tr>
                
                <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('admin.billing.invoices.show', 'INV-2024-004') }}'">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">INV-2024-004</div>
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
                        <div class="text-sm font-medium text-gray-900">$45.00</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-01-25
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-02-25
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            لغو شده
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button class="text-blue-600 hover:text-blue-900">مشاهده</button>
                            <button class="text-gray-600 hover:text-gray-900">آرشیو</button>
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
                    نمایش <span class="font-medium">1</span> تا <span class="font-medium">10</span> از <span class="font-medium">97</span> نتیجه
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
@endsection
