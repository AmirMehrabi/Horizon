@extends('layouts.admin')

@section('title', 'جزئیات شبکه')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.networks.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    شبکه‌ها
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 mr-1 md:mr-2">public-network-01</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-lg bg-blue-100 flex items-center justify-center">
            <svg class="w-9 h-9 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">public-network-01</h1>
            <p class="mt-1 text-sm text-gray-500">Network ID: net-abc123def456</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            <span class="w-2 h-2 rounded-full bg-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}"></span>
            فعال
        </span>
        <button onclick="deleteNetwork()" class="bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg font-medium text-sm transition-colors">
            حذف شبکه
        </button>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Network Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">جزئیات شبکه</h2>
            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام شبکه</label>
                    <input type="text" value="public-network-01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نوع شبکه</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="public" selected>عمومی</option>
                            <option value="private">خصوصی</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">پروژه</label>
                        <input type="text" value="project-acme-corp" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CIDR</label>
                        <input type="text" value="203.0.113.0/24" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gateway IP</label>
                        <input type="text" value="203.0.113.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">محدودیت پهنای باند (Mbps)</label>
                        <input type="number" value="1000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Burst (Mbps)</label>
                        <input type="number" value="2000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 block text-sm text-gray-700">فعال‌سازی DHCP</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 block text-sm text-gray-700">فعال‌سازی DNS</span>
                    </label>
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

        <!-- Connected Instances Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Instance های متصل</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">نام Instance</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">IP Address</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">وضعیت</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">web-server-01</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">203.0.113.10</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-blue-600 hover:text-blue-900">مشاهده</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">db-server-01</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">203.0.113.11</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-blue-600 hover:text-blue-900">مشاهده</a>
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
                    <span class="text-gray-500">Network ID</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">net-abc123def456</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Neutron ID</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">neutron-xyz789</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">تاریخ ایجاد</span>
                    <span class="font-medium text-gray-900">۱۴۰۳/۰۱/۱۵</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">وضعیت</span>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">MTU</span>
                    <span class="font-medium text-gray-900">1500</span>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">آمار</h2>
            <div class="space-y-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">12</p>
                    <p class="text-sm text-gray-500 mt-1">Instance های متصل</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">245</p>
                    <p class="text-sm text-gray-500 mt-1">IP های استفاده شده</p>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">11</p>
                    <p class="text-sm text-gray-500 mt-1">IP های باقیمانده</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteNetwork() {
    if (confirm('آیا مطمئن هستید که می‌خواهید این شبکه را حذف کنید؟ این عمل غیرقابل بازگشت است.')) {
        // Delete logic here
        window.location.href = "{{ route('admin.networks.index') }}";
    }
}
</script>
@endsection



