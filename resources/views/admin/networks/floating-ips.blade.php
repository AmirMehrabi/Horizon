@extends('layouts.admin')

@section('title', 'مدیریت IP های شناور')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.networks.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">مدیریت IP های شناور</h1>
        <p class="mt-1 text-sm text-gray-500">مدیریت IP Pool ها و تخصیص IP های شناور</p>
    </div>
    <div class="flex gap-3">
        <button onclick="openCreatePoolModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            ایجاد Pool جدید
        </button>
        <button onclick="openAllocateIpModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            تخصیص IP
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">کل IP های شناور</p>
                <p class="text-2xl font-bold text-gray-900">247</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">IP های تخصیص یافته</p>
                <p class="text-2xl font-bold text-gray-900">189</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">IP های آزاد</p>
                <p class="text-2xl font-bold text-gray-900">58</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">IP Pool ها</p>
                <p class="text-2xl font-bold text-gray-900">8</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Floating IP Pools Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">IP Pool ها</h2>
        <button onclick="openCreatePoolModal()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ افزودن Pool</button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-900">public-ip-pool-01</h3>
                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
            </div>
            <p class="text-xs text-gray-500 mb-3">203.0.113.0/24</p>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500">256 IP</span>
                <span class="text-gray-900 font-medium">189 استفاده شده</span>
            </div>
        </div>
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-900">public-ip-pool-02</h3>
                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
            </div>
            <p class="text-xs text-gray-500 mb-3">198.51.100.0/24</p>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500">256 IP</span>
                <span class="text-gray-900 font-medium">67 استفاده شده</span>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">جستجو</label>
            <div class="relative">
                <input type="text" placeholder="جستجو بر اساس IP یا Instance..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">وضعیت</label>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه</option>
                <option value="allocated">تخصیص یافته</option>
                <option value="available">آزاد</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pool</label>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">همه Pool ها</option>
                <option value="pool-1">public-ip-pool-01</option>
                <option value="pool-2">public-ip-pool-02</option>
            </select>
        </div>
    </div>
</div>

<!-- Floating IPs Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Pool</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Instance</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">پروژه</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">203.0.113.10</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">public-ip-pool-01</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">web-server-01</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">project-acme-corp</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">متصل</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="disconnectIp('203.0.113.10')" class="text-red-600 hover:text-red-900">قطع اتصال</button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">203.0.113.11</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">public-ip-pool-01</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">آزاد</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="allocateIp('203.0.113.11')" class="text-blue-600 hover:text-blue-900">تخصیص</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Create Pool Modal -->
<div id="createPoolModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">ایجاد IP Pool جدید</h3>
            <button onclick="closeCreatePoolModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">نام Pool</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="public-ip-pool-03" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">CIDR</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="192.0.2.0/24" required>
                <p class="mt-1 text-xs text-gray-500">مثال: 192.0.2.0/24</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">شبکه Gateway</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">انتخاب شبکه</option>
                    <option value="public-net-1">public-network-01</option>
                    <option value="public-net-2">public-network-02</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeCreatePoolModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    ایجاد Pool
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Allocate IP Modal -->
<div id="allocateIpModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">تخصیص IP شناور</h3>
            <button onclick="closeAllocateIpModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">IP Pool</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">انتخاب Pool</option>
                    <option value="pool-1">public-ip-pool-01</option>
                    <option value="pool-2">public-ip-pool-02</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Instance</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">انتخاب Instance</option>
                    <option value="instance-1">web-server-01</option>
                    <option value="instance-2">db-server-01</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAllocateIpModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    تخصیص IP
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreatePoolModal() {
    document.getElementById('createPoolModal').classList.remove('hidden');
}

function closeCreatePoolModal() {
    document.getElementById('createPoolModal').classList.add('hidden');
}

function openAllocateIpModal() {
    document.getElementById('allocateIpModal').classList.remove('hidden');
}

function closeAllocateIpModal() {
    document.getElementById('allocateIpModal').classList.add('hidden');
}

function allocateIp(ip) {
    openAllocateIpModal();
}

function disconnectIp(ip) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این IP را قطع کنید؟')) {
        // Disconnect logic
        alert('IP قطع شد');
    }
}
</script>
@endsection



