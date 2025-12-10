@extends('layouts.admin')

@section('title', 'Provisioning های ناموفق')

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
    <h1 class="text-3xl font-bold text-gray-900">Provisioning های ناموفق</h1>
    <p class="mt-1 text-sm text-gray-500">لاگ‌های خطا در ایجاد منابع</p>
</div>

<!-- Failed Provisioning Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">زمان</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نوع</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">کاربر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">خطا</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۱/۱۵ - ۱۳:۴۵</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">Volume</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">user@example.com</td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-red-600 font-medium">Insufficient quota</div>
                        <div class="text-xs text-gray-500 mt-1">Volume creation failed: Quota exceeded for volumes</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="viewDetails('log-123')" class="text-blue-600 hover:text-blue-900">مشاهده جزئیات</button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۱/۱۵ - ۱۲:۲۰</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Instance</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">admin@example.com</td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-red-600 font-medium">Hypervisor unavailable</div>
                        <div class="text-xs text-gray-500 mt-1">Instance creation failed: No available hypervisor</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="viewDetails('log-124')" class="text-blue-600 hover:text-blue-900">مشاهده جزئیات</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
function viewDetails(logId) {
    alert('جزئیات لاگ: ' + logId);
}
</script>
@endsection

