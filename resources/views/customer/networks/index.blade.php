@extends('layouts.customer')

@section('title', 'شبکه‌های من')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('header_content')
    @include('customer.partials.breadcrumb', [
        'items' => [
            [
                'label' => 'داشبورد',
                'url' => route('customer.dashboard'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>'
            ],
            [
                'label' => 'شبکه‌های من',
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
<!-- Page Header -->
<div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
    <h1 class="text-3xl font-bold text-gray-900">شبکه‌های من</h1>
                <p class="mt-1 text-sm text-gray-500">مدیریت شبکه‌های خصوصی، گروه‌های امنیتی و IP های شناور</p>
            </div>
        </div>
    </div>

    <!-- Network Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Private Networks -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">شبکه‌های خصوصی</p>
                    <p class="text-2xl font-semibold text-gray-900">۳</p>
                </div>
            </div>
        </div>

        <!-- Security Groups -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">گروه‌های امنیتی</p>
                    <p class="text-2xl font-semibold text-gray-900">۵</p>
                </div>
            </div>
        </div>

        <!-- Floating IPs -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">IP های شناور</p>
                    <p class="text-2xl font-semibold text-gray-900">۲</p>
                </div>
            </div>
        </div>

        <!-- Bandwidth Usage -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">مصرف پهنای باند</p>
                    <p class="text-2xl font-semibold text-gray-900">۲۸۵ GB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Network Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="switchTab('networks')" id="networks-tab" class="tab-button active border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    شبکه‌های خصوصی
                </button>
                <button onclick="switchTab('security-groups')" id="security-groups-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    گروه‌های امنیتی
                </button>
                <button onclick="switchTab('floating-ips')" id="floating-ips-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    IP های شناور
                </button>
                <button onclick="switchTab('bandwidth')" id="bandwidth-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    مصرف پهنای باند
                </button>
            </nav>
        </div>

        <!-- Private Networks Tab -->
        <div id="networks-content" class="tab-content p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">شبکه‌های خصوصی</h2>
                <button onclick="openCreateNetworkModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    ایجاد شبکه جدید
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Network 1 -->
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s1.343-9 3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">production-network</h3>
                                <p class="text-sm text-gray-500">۱۹۲.۱۶۸.۱.۰/۲۴</p>
                            </div>
                        </div>
                        <div class="relative">
                            <button onclick="toggleNetworkMenu('network-1')" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </button>
                            <div id="network-1-menu" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                <button class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">ویرایش</button>
                                <button class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">افزودن زیرشبکه</button>
                                <div class="border-t border-gray-200 my-1"></div>
                                <button class="block w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50">حذف</button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">وضعیت:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                فعال
                            </span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">سرورهای متصل:</span>
                            <span class="font-medium text-gray-900">۳</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">زیرشبکه‌ها:</span>
                            <span class="font-medium text-gray-900">۲</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">ایجاد شده:</span>
                            <span class="text-gray-500">۱۴۰۳/۰۹/۱۰</span>
                        </div>

                        <!-- Connected Servers -->
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-2">سرورهای متصل:</p>
                            <div class="space-y-1">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">وب سرور اصلی</span>
                                    <span class="text-gray-500">۱۹۲.۱۶۸.۱.۱۰</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">پایگاه داده</span>
                                    <span class="text-gray-500">۱۹۲.۱۶۸.۱.۲۰</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">سرور فایل</span>
                                    <span class="text-gray-500">۱۹۲.۱۶۸.۱.۳۰</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Network 2 -->
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s1.343-9 3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">development-network</h3>
                                <p class="text-sm text-gray-500">۱۰.۰.۰.۰/۱۶</p>
                            </div>
                        </div>
                        <div class="relative">
                            <button onclick="toggleNetworkMenu('network-2')" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </button>
                            <div id="network-2-menu" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                <button class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">ویرایش</button>
                                <button class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">افزودن زیرشبکه</button>
                                <div class="border-t border-gray-200 my-1"></div>
                                <button class="block w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50">حذف</button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">وضعیت:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                فعال
                            </span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">سرورهای متصل:</span>
                            <span class="font-medium text-gray-900">۱</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">زیرشبکه‌ها:</span>
                            <span class="font-medium text-gray-900">۱</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">ایجاد شده:</span>
                            <span class="text-gray-500">۱۴۰۳/۰۹/۲۰</span>
                        </div>

                        <!-- Connected Servers -->
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-2">سرورهای متصل:</p>
                            <div class="space-y-1">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">سرور تست</span>
                                    <span class="text-gray-500">۱۰.۰.۱.۱۰</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Groups Tab -->
        <div id="security-groups-content" class="tab-content p-6 hidden">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">گروه‌های امنیتی</h2>
                <button onclick="openCreateSecurityGroupModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    ایجاد گروه امنیتی
                </button>
            </div>

            <div class="space-y-6">
                <!-- Security Group 1 -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">web-servers</h3>
                                <p class="text-sm text-gray-500">گروه امنیتی برای وب سرورها</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ۳ سرور
                            </span>
                            <button onclick="editSecurityGroup('sg-1')" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Rules Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">نوع</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">پروتکل</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">پورت</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">منبع</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">عملیات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">ورودی</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">TCP</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">۸۰</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">۰.۰.۰.۰/۰</td>
                                    <td class="px-4 py-2 text-sm">
                                        <button class="text-red-600 hover:text-red-900">حذف</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">ورودی</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">TCP</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">۴۴۳</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">۰.۰.۰.۰/۰</td>
                                    <td class="px-4 py-2 text-sm">
                                        <button class="text-red-600 hover:text-red-900">حذف</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">ورودی</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">TCP</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">۲۲</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">۱۹۲.۱۶۸.۱.۰/۲۴</td>
                                    <td class="px-4 py-2 text-sm">
                                        <button class="text-red-600 hover:text-red-900">حذف</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Security Group 2 -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">database-servers</h3>
                                <p class="text-sm text-gray-500">گروه امنیتی برای سرورهای پایگاه داده</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                ۱ سرور
                            </span>
                            <button onclick="editSecurityGroup('sg-2')" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Rules Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">نوع</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">پروتکل</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">پورت</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">منبع</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">عملیات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">ورودی</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">TCP</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">۳۳۰۶</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">۱۹۲.۱۶۸.۱.۰/۲۴</td>
                                    <td class="px-4 py-2 text-sm">
                                        <button class="text-red-600 hover:text-red-900">حذف</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">ورودی</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">TCP</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">۲۲</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">۱۹۲.۱۶۸.۱.۰/۲۴</td>
                                    <td class="px-4 py-2 text-sm">
                                        <button class="text-red-600 hover:text-red-900">حذف</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating IPs Tab -->
        <div id="floating-ips-content" class="tab-content p-6 hidden">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">IP های شناور</h2>
                <button onclick="openAllocateFloatingIPModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    تخصیص IP جدید
                </button>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">آدرس IP</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">متصل به</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">هزینه ماهانه</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ تخصیص</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">۱۸۵.۲۳۹.۱۰۶.۱۲۳</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        متصل
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">وب سرور اصلی</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۵۰,۰۰۰ تومان</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۹/۱۰</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <button onclick="detachFloatingIP('ip-1')" class="text-yellow-600 hover:text-yellow-900">جدا کردن</button>
                                        <button onclick="releaseFloatingIP('ip-1')" class="text-red-600 hover:text-red-900">آزاد کردن</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">۱۸۵.۲۳۹.۱۰۶.۱۲۴</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        آزاد
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۵۰,۰۰۰ تومان</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۹/۲۰</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <button onclick="attachFloatingIP('ip-2')" class="text-blue-600 hover:text-blue-900">متصل کردن</button>
                                        <button onclick="releaseFloatingIP('ip-2')" class="text-red-600 hover:text-red-900">آزاد کردن</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bandwidth Usage Tab -->
        <div id="bandwidth-content" class="tab-content p-6 hidden">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">مصرف پهنای باند</h2>
            
            <!-- Bandwidth Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500">ترافیک ورودی</p>
                            <p class="text-2xl font-semibold text-gray-900">۱۲۰ GB</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500">ترافیک خروجی</p>
                            <p class="text-2xl font-semibold text-gray-900">۱۶۵ GB</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500">کل مصرف</p>
                            <p class="text-2xl font-semibold text-gray-900">۲۸۵ GB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bandwidth Chart Placeholder -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">نمودار مصرف پهنای باند (۳۰ روز گذشته)</h3>
                <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                    <p class="text-gray-500">نمودار مصرف پهنای باند</p>
                </div>
            </div>

            <!-- Per-Server Bandwidth -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">مصرف پهنای باند به تفکیک سرور</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">سرور</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ترافیک ورودی</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ترافیک خروجی</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">کل مصرف</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">درصد کل</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">وب سرور اصلی</div>
                                            <div class="text-sm text-gray-500">۱۸۵.۲۳۹.۱۰۶.۱۲۳</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۸۰ GB</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۱۲۰ GB</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">۲۰۰ GB</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2 {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: 70%"></div>
                                        </div>
                                        <span class="text-sm text-gray-900">۷۰%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">پایگاه داده</div>
                                            <div class="text-sm text-gray-500">۱۹۲.۱۶۸.۱.۲۰</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۳۰ GB</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۲۵ GB</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">۵۵ GB</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2 {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: 19%"></div>
                                        </div>
                                        <span class="text-sm text-gray-900">۱۹%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">سرور فایل</div>
                                            <div class="text-sm text-gray-500">۱۹۲.۱۶۸.۱.۳۰</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۱۰ GB</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۲۰ GB</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">۳۰ GB</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2 {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                            <div class="bg-purple-600 h-2 rounded-full" style="width: 11%"></div>
                                        </div>
                                        <span class="text-sm text-gray-900">۱۱%</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Network Modal -->
<div id="createNetworkModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">ایجاد شبکه خصوصی جدید</h3>
            </div>
            
            <form class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام شبکه</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="my-private-network">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">CIDR Block</label>
                    <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="192.168.0.0/24">۱۹۲.۱۶۸.۰.۰/۲۴ (۲۵۶ آدرس)</option>
                        <option value="10.0.0.0/16">۱۰.۰.۰.۰/۱۶ (۶۵۵۳۶ آدرس)</option>
                        <option value="172.16.0.0/16">۱۷۲.۱۶.۰.۰/۱۶ (۶۵۵۳۶ آدرس)</option>
                        <option value="custom">سفارشی</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات (اختیاری)</label>
                    <textarea rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="توضیحات شبکه..."></textarea>
                </div>
            </form>
            
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeCreateNetworkModal()" class="px-4 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">
                    انصراف
                </button>
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    ایجاد شبکه
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Tab switching
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.add('active', 'border-blue-500', 'text-blue-600');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
}

// Modal functions
function openCreateNetworkModal() {
    document.getElementById('createNetworkModal').classList.remove('hidden');
}

function closeCreateNetworkModal() {
    document.getElementById('createNetworkModal').classList.add('hidden');
}

function openCreateSecurityGroupModal() {
    // Implement security group modal
    console.log('Opening create security group modal');
}

function openAllocateFloatingIPModal() {
    // Implement floating IP allocation modal
    console.log('Opening allocate floating IP modal');
}

// Network menu toggle
function toggleNetworkMenu(networkId) {
    const menu = document.getElementById(networkId + '-menu');
    const allMenus = document.querySelectorAll('[id$="-menu"]');
    
    // Close all other menus
    allMenus.forEach(m => {
        if (m.id !== networkId + '-menu') {
            m.classList.add('hidden');
        }
    });
    
    // Toggle current menu
    menu.classList.toggle('hidden');
}

// Security group functions
function editSecurityGroup(sgId) {
    console.log('Editing security group:', sgId);
}

// Floating IP functions
function attachFloatingIP(ipId) {
    console.log('Attaching floating IP:', ipId);
}

function detachFloatingIP(ipId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این IP را جدا کنید؟')) {
        console.log('Detaching floating IP:', ipId);
    }
}

function releaseFloatingIP(ipId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این IP را آزاد کنید؟ این عمل قابل بازگشت نیست.')) {
        console.log('Releasing floating IP:', ipId);
    }
}

// Close menus when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick*="toggleNetworkMenu"]') && !event.target.closest('[id$="-menu"]')) {
        document.querySelectorAll('[id$="-menu"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});

// Close modal when clicking outside
document.getElementById('createNetworkModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeCreateNetworkModal();
    }
});
</script>

<style>
.tab-button.active {
    border-bottom-color: #3b82f6;
    color: #3b82f6;
}
</style>
@endsection