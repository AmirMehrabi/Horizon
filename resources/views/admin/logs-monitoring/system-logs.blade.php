@extends('layouts.admin')

@section('title', 'لاگ‌های سیستم')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.logs-monitoring.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">لاگ‌های سیستم</h1>
    <p class="mt-1 text-sm text-gray-500">عملیات انجام شده توسط ادمین و کاربران</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">جستجو</label>
            <div class="relative">
                <input type="text" placeholder="جستجو در لاگ‌ها..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">نوع کاربر</label>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه</option>
                <option value="admin">ادمین</option>
                <option value="user">کاربر</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">نوع عملیات</label>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه</option>
                <option value="create">ایجاد</option>
                <option value="update">ویرایش</option>
                <option value="delete">حذف</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">تاریخ</label>
            <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>
</div>

<!-- Logs Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">زمان</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">کاربر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">منبع</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">جزئیات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۱/۱۵ - ۱۴:۳۲</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-xs font-medium text-blue-600">A</span>
                            </div>
                            <div class="mr-3">
                                <div class="text-sm font-medium text-gray-900">admin@example.com</div>
                                <div class="text-xs text-gray-500">ادمین</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">ایجاد</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Instance</td>
                    <td class="px-6 py-4 text-sm text-gray-500">ایجاد Instance: web-server-01</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۱/۱۵ - ۱۴:۲۸</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <span class="text-xs font-medium text-purple-600">U</span>
                            </div>
                            <div class="mr-3">
                                <div class="text-sm font-medium text-gray-900">user@example.com</div>
                                <div class="text-xs text-gray-500">کاربر</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">ویرایش</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Volume</td>
                    <td class="px-6 py-4 text-sm text-gray-500">تغییر اندازه Volume: volume-db-01</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">
                نمایش ۱ تا ۲۰ از ۱,۲۴۷ لاگ
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">قبلی</button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">بعدی</button>
            </div>
        </div>
    </div>
</div>
@endsection

