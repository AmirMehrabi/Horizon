@extends('layouts.admin')

@section('title', 'جزئیات Container')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.storage.sidebar')
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.storage.containers') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Container ها
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 mr-1 md:mr-2">backups</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-lg bg-orange-100 flex items-center justify-center">
            <svg class="w-9 h-9 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">backups</h1>
            <p class="mt-1 text-sm text-gray-500">Container ID: container-abc123</p>
        </div>
    </div>
    <button onclick="editQuota()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors">
        تنظیم Quota
    </button>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Container Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">جزئیات Container</h2>
            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام Container</label>
                    <input type="text" value="backups" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نوع دسترسی</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="private" selected>خصوصی</option>
                            <option value="public">عمومی</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">پروژه</label>
                        <input type="text" value="project-acme-corp" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        انصراف
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        ذخیره تغییرات
                    </button>
                </div>
            </form>
        </div>

        <!-- Objects -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Object ها</h2>
                <button onclick="uploadObject()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ آپلود Object</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">نام</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">اندازه</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">تاریخ آپلود</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">backup-2024-01-15.tar.gz</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2.5 GB</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۱/۱۵</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <button onclick="downloadObject('backup-2024-01-15.tar.gz')" class="text-blue-600 hover:text-blue-900 mr-4">دانلود</button>
                                <button onclick="deleteObject('backup-2024-01-15.tar.gz')" class="text-red-600 hover:text-red-900">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات سریع</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Container ID</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">container-abc123</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">پروژه</span>
                    <span class="font-medium text-gray-900">project-acme-corp</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Object ها</span>
                    <span class="font-medium text-gray-900">1,234</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">ظرفیت استفاده شده</span>
                    <span class="font-medium text-gray-900">2.5 TB</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Quota</span>
                    <span class="font-medium text-gray-900">5 TB</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">نوع دسترسی</span>
                    <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded">خصوصی</span>
                </div>
            </div>
        </div>

        <!-- Quota Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quota و قیمت‌گذاری</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Quota</span>
                    <span class="font-medium text-gray-900">5 TB</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">قیمت (تومان/GB/ماه)</span>
                    <span class="font-medium text-gray-900">1,500</span>
                </div>
                <div class="pt-3 border-t border-gray-200">
                    <button onclick="editQuota()" class="w-full text-right px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg font-medium text-sm transition-colors">
                        ویرایش Quota
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function editQuota() {
    window.location.href = "{{ route('admin.storage.containers') }}?edit_quota=container-abc123";
}

function uploadObject() {
    alert('آپلود Object');
}

function downloadObject(objectName) {
    alert('دانلود: ' + objectName);
}

function deleteObject(objectName) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Object را حذف کنید؟')) {
        alert('Object حذف شد');
    }
}
</script>
@endsection

