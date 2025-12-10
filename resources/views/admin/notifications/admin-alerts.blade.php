@extends('layouts.admin')

@section('title', 'هشدارهای ادمین')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.notifications.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">هشدارهای ادمین</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت هشدارهای سیستم برای ادمین‌ها</p>
</div>

<!-- Alert Settings -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">تنظیمات هشدارها</h2>
    <form class="space-y-6">
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="text-sm font-medium text-gray-900">Node Failure</h3>
                    <p class="text-xs text-gray-500">هشدار زمانی که یک Hypervisor از دسترس خارج می‌شود</p>
                </div>
                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 text-sm text-gray-700">فعال</span>
                    </label>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="text-sm font-medium text-gray-900">Quota Full</h3>
                    <p class="text-xs text-gray-500">هشدار زمانی که Quota یک پروژه تکمیل می‌شود</p>
                </div>
                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 text-sm text-gray-700">فعال</span>
                    </label>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="text-sm font-medium text-gray-900">API Health Check Failed</h3>
                    <p class="text-xs text-gray-500">هشدار زمانی که یک API از دسترس خارج می‌شود</p>
                </div>
                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 text-sm text-gray-700">فعال</span>
                    </label>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="text-sm font-medium text-gray-900">Storage Full</h3>
                    <p class="text-xs text-gray-500">هشدار زمانی که فضای ذخیره‌سازی به 90% می‌رسد</p>
                </div>
                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 text-sm text-gray-700">فعال</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                انصراف
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                ذخیره تنظیمات
            </button>
        </div>
    </form>
</div>

<!-- Active Alerts -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">هشدارهای فعال</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نوع هشدار</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">جزئیات</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اولویت</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">Node Failure</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">Hypervisor compute-node-03 از دسترس خارج شد</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">بالا</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۱/۱۵ - ۱۴:۲۰</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="markResolved('alert-1')" class="text-green-600 hover:text-green-900">حل شده</button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded">Quota Full</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">پروژه project-acme-corp: Quota Volume تکمیل شد</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">متوسط</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۱/۱۵ - ۱۳:۴۵</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="markResolved('alert-2')" class="text-green-600 hover:text-green-900">حل شده</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
function markResolved(alertId) {
    if (confirm('آیا مطمئن هستید که این هشدار حل شده است؟')) {
        alert('هشدار حل شده علامت‌گذاری شد');
    }
}
</script>
@endsection

