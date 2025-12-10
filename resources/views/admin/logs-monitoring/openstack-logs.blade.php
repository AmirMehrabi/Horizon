@extends('layouts.admin')

@section('title', 'لاگ‌های OpenStack')

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
    <h1 class="text-3xl font-bold text-gray-900">لاگ‌های OpenStack</h1>
    <p class="mt-1 text-sm text-gray-500">رویدادها و خطاهای OpenStack</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">سرویس</label>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه سرویس‌ها</option>
                <option value="nova">Nova</option>
                <option value="neutron">Neutron</option>
                <option value="cinder">Cinder</option>
                <option value="glance">Glance</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">سطح</label>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه</option>
                <option value="error">خطا</option>
                <option value="warning">هشدار</option>
                <option value="info">اطلاعات</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">تاریخ</label>
            <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>
</div>

<!-- OpenStack Logs Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">زمان</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">سرویس</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">سطح</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">پیام</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۱/۱۵ - ۱۴:۳۰</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">Nova</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">هشدار</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">High response time detected: 2.5s average</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۱/۱۵ - ۱۴:۲۵</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Neutron</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">خطا</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">Failed to create network: Invalid CIDR format</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

