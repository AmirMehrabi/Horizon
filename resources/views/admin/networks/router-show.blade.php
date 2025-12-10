@extends('layouts.admin')

@section('title', 'جزئیات روتر')

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
                <a href="{{ route('admin.networks.routers') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    روترها
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 mr-1 md:mr-2">router-acme-main</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-lg bg-purple-100 flex items-center justify-center">
            <svg class="w-9 h-9 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">router-acme-main</h1>
            <p class="mt-1 text-sm text-gray-500">Router ID: router-abc123</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            <span class="w-2 h-2 rounded-full bg-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}"></span>
            فعال
        </span>
        <button onclick="deleteRouter()" class="bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg font-medium text-sm transition-colors">
            حذف روتر
        </button>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Router Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">جزئیات روتر</h2>
            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام روتر</label>
                    <input type="text" value="router-acme-main" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">پروژه</label>
                    <input type="text" value="project-acme-corp" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gateway</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="public-net-1" selected>public-network-01 (203.0.113.1)</option>
                        <option value="public-net-2">public-network-02</option>
                    </select>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 block text-sm text-gray-700">فعال‌سازی SNAT (Source NAT)</span>
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

        <!-- Connected Networks -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">شبکه‌های متصل</h2>
                <button onclick="openAddInterfaceModal()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ افزودن Interface</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">شبکه</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">IP Address</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">وضعیت</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">public-network-01</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">203.0.113.1</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <button onclick="removeInterface(1)" class="text-red-600 hover:text-red-900">حذف</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">private-network-acme</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">10.0.1.1</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <button onclick="removeInterface(2)" class="text-red-600 hover:text-red-900">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Static Routes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Static Routes</h2>
                <button onclick="openAddRouteModal()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ افزودن Route</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">مقصد</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Next Hop</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">192.168.1.0/24</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">10.0.1.10</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <button onclick="deleteRoute(1)" class="text-red-600 hover:text-red-900">حذف</button>
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
                    <span class="text-gray-500">Router ID</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">router-abc123</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Neutron ID</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">neutron-router-xyz</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">تاریخ ایجاد</span>
                    <span class="font-medium text-gray-900">۱۴۰۳/۰۱/۱۵</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">وضعیت</span>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">آمار</h2>
            <div class="space-y-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">3</p>
                    <p class="text-sm text-gray-500 mt-1">شبکه‌های متصل</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">1</p>
                    <p class="text-sm text-gray-500 mt-1">Static Routes</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Interface Modal -->
<div id="addInterfaceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">افزودن Interface</h3>
            <button onclick="closeAddInterfaceModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">شبکه</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">انتخاب شبکه</option>
                    <option value="net-1">private-network-acme</option>
                    <option value="net-2">private-network-tech</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">IP Address (اختیاری)</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="10.0.1.1">
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddInterfaceModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    افزودن Interface
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Route Modal -->
<div id="addRouteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">افزودن Static Route</h3>
            <button onclick="closeAddRouteModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">مقصد (CIDR)</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="192.168.1.0/24" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Next Hop</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="10.0.1.10" required>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddRouteModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    افزودن Route
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddInterfaceModal() {
    document.getElementById('addInterfaceModal').classList.remove('hidden');
}

function closeAddInterfaceModal() {
    document.getElementById('addInterfaceModal').classList.add('hidden');
}

function openAddRouteModal() {
    document.getElementById('addRouteModal').classList.remove('hidden');
}

function closeAddRouteModal() {
    document.getElementById('addRouteModal').classList.add('hidden');
}

function removeInterface(interfaceId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Interface را حذف کنید؟')) {
        // Remove interface logic
        alert('Interface حذف شد');
    }
}

function deleteRoute(routeId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Route را حذف کنید؟')) {
        // Delete route logic
        alert('Route حذف شد');
    }
}

function deleteRouter() {
    if (confirm('آیا مطمئن هستید که می‌خواهید این روتر را حذف کنید؟ این عمل غیرقابل بازگشت است.')) {
        window.location.href = "{{ route('admin.networks.routers') }}";
    }
}
</script>
@endsection



