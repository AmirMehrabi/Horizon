@extends('layouts.admin')

@section('title', 'گزارشات مصرف')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">گزارشات مصرف</h1>
    <p class="mt-1 text-sm text-gray-500">تحلیل و گزارش‌گیری از مصرف منابع</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">فیلترها</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="customer_filter" class="block text-sm font-medium text-gray-700 mb-2">مشتری</label>
            <input type="text" id="customer_filter" placeholder="جستجو مشتری..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <div>
            <label for="resource_type" class="block text-sm font-medium text-gray-700 mb-2">نوع منبع</label>
            <select id="resource_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">همه منابع</option>
                <option value="cpu">CPU</option>
                <option value="ram">RAM</option>
                <option value="storage">ذخیره‌سازی</option>
                <option value="bandwidth">پهنای باند</option>
                <option value="floating_ip">IP شناور</option>
                <option value="volumes">حجم‌ها</option>
            </select>
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
    <div class="flex justify-between items-center mt-4">
        <div class="flex space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                اعمال فیلتر
            </button>
            <button class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                صادرات Excel
            </button>
            <button class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                صادرات PDF
            </button>
        </div>
        <div class="text-sm text-gray-500">
            آخرین به‌روزرسانی: 2024-01-15 16:30
        </div>
    </div>
</div>

<!-- Summary Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل ساعات CPU</p>
                <p class="text-2xl font-bold text-gray-900">45,678</p>
                <p class="text-xs text-green-600 mt-1">+12% از ماه قبل</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل ساعات RAM</p>
                <p class="text-2xl font-bold text-gray-900">123,456</p>
                <p class="text-xs text-green-600 mt-1">+8% از ماه قبل</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل ذخیره‌سازی</p>
                <p class="text-2xl font-bold text-gray-900">2.4 TB</p>
                <p class="text-xs text-blue-600 mt-1">+15% از ماه قبل</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل پهنای باند</p>
                <p class="text-2xl font-bold text-gray-900">890 GB</p>
                <p class="text-xs text-yellow-600 mt-1">+5% از ماه قبل</p>
            </div>
        </div>
    </div>
</div>

<!-- Resource Usage Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">مصرف منابع در زمان</h3>
        <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
            <div class="text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <p class="text-gray-500">نمودار مصرف منابع</p>
                <p class="text-sm text-gray-400">داده‌ها در حال بارگذاری...</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">توزیع مصرف بر اساس منبع</h3>
        <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
            <div class="text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
                <p class="text-gray-500">نمودار دایره‌ای مصرف</p>
                <p class="text-sm text-gray-400">داده‌ها در حال بارگذاری...</p>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Usage Report -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">گزارش تفصیلی مصرف</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        مشتری
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        CPU ساعت
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        RAM ساعت
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ذخیره‌سازی GB
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        پهنای باند GB
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        IP شناور ساعت
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        کل هزینه
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">2,340</div>
                        <div class="text-xs text-gray-500">بالاترین مصرف</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">9,360</div>
                        <div class="text-xs text-gray-500">4GB میانگین</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">480</div>
                        <div class="text-xs text-gray-500">SSD</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">125.6</div>
                        <div class="text-xs text-gray-500">ورودی/خروجی</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">720</div>
                        <div class="text-xs text-gray-500">1 IP</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        $234.50
                    </td>
                </tr>
                
                <tr>
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">1,680</div>
                        <div class="text-xs text-gray-500">مصرف متوسط</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">3,360</div>
                        <div class="text-xs text-gray-500">2GB میانگین</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">160</div>
                        <div class="text-xs text-gray-500">SSD</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">89.2</div>
                        <div class="text-xs text-gray-500">ورودی/خروجی</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">720</div>
                        <div class="text-xs text-gray-500">1 IP</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        $89.99
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                <span class="text-xs font-medium text-green-600">DS</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Digital Solutions</div>
                                <div class="text-sm text-gray-500">digital@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">840</div>
                        <div class="text-xs text-gray-500">مصرف کم</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">840</div>
                        <div class="text-xs text-gray-500">1GB میانگین</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">80</div>
                        <div class="text-xs text-gray-500">SSD</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">45.8</div>
                        <div class="text-xs text-gray-500">ورودی/خروجی</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">0</div>
                        <div class="text-xs text-gray-500">بدون IP</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        $45.75
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                <span class="text-xs font-medium text-yellow-600">NE</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">NewEnterprise</div>
                                <div class="text-sm text-gray-500">new@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">3,120</div>
                        <div class="text-xs text-gray-500">مصرف بالا</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">12,480</div>
                        <div class="text-xs text-gray-500">4GB میانگین</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">800</div>
                        <div class="text-xs text-gray-500">SSD + HDD</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">234.7</div>
                        <div class="text-xs text-gray-500">ورودی/خروجی</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">1,440</div>
                        <div class="text-xs text-gray-500">2 IP</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        $456.80
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- High Usage Customers -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">مشتریان پرمصرف</h2>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-red-800">مصرف CPU بالا</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        هشدار
                    </span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-red-700">ACME Corporation</span>
                        <span class="font-medium text-red-900">2,340 ساعت</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-red-700">NewEnterprise</span>
                        <span class="font-medium text-red-900">3,120 ساعت</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-orange-800">مصرف پهنای باند بالا</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                        توجه
                    </span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-orange-700">NewEnterprise</span>
                        <span class="font-medium text-orange-900">234.7 GB</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-orange-700">ACME Corporation</span>
                        <span class="font-medium text-orange-900">125.6 GB</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-blue-800">مصرف ذخیره‌سازی بالا</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        اطلاع
                    </span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-blue-700">NewEnterprise</span>
                        <span class="font-medium text-blue-900">800 GB</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-blue-700">ACME Corporation</span>
                        <span class="font-medium text-blue-900">480 GB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
