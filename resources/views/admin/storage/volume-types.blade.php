@extends('layouts.admin')

@section('title', 'انواع Volume')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.storage.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">انواع Volume</h1>
        <p class="mt-1 text-sm text-gray-500">مدیریت انواع Volume (SSD, HDD) و تنظیم قیمت‌گذاری</p>
    </div>
    <button onclick="openCreateVolumeTypeModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2 shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        ایجاد نوع جدید
    </button>
</div>

<!-- Volume Types Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نام</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نوع</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">قیمت (تومان/GB/ماه)</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Volume ها</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900">SSD Premium</div>
                                <div class="text-sm text-gray-500">volume-type-ssd-01</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">SSD</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5,000</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">892</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editVolumeType('volume-type-ssd-01')" class="text-indigo-600 hover:text-indigo-900 mr-4">ویرایش</button>
                        <button onclick="deleteVolumeType('volume-type-ssd-01')" class="text-red-600 hover:text-red-900">حذف</button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900">HDD Standard</div>
                                <div class="text-sm text-gray-500">volume-type-hdd-01</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded">HDD</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2,000</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">355</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editVolumeType('volume-type-hdd-01')" class="text-indigo-600 hover:text-indigo-900 mr-4">ویرایش</button>
                        <button onclick="deleteVolumeType('volume-type-hdd-01')" class="text-red-600 hover:text-red-900">حذف</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Create/Edit Volume Type Modal -->
<div id="volumeTypeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900" id="modalTitle">ایجاد نوع Volume جدید</h3>
            <button onclick="closeVolumeTypeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">نام</label>
                <input type="text" id="volumeTypeName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="SSD Premium" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">نوع</label>
                <select id="volumeTypeType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="ssd">SSD</option>
                    <option value="hdd">HDD</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">قیمت (تومان/GB/ماه)</label>
                <input type="number" id="volumeTypePrice" min="0" step="100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="5000" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
                <textarea rows="3" id="volumeTypeDescription" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="توضیحات نوع Volume..."></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeVolumeTypeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    ذخیره
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateVolumeTypeModal() {
    document.getElementById('modalTitle').textContent = 'ایجاد نوع Volume جدید';
    document.getElementById('volumeTypeName').value = '';
    document.getElementById('volumeTypeType').value = 'ssd';
    document.getElementById('volumeTypePrice').value = '';
    document.getElementById('volumeTypeDescription').value = '';
    document.getElementById('volumeTypeModal').classList.remove('hidden');
}

function closeVolumeTypeModal() {
    document.getElementById('volumeTypeModal').classList.add('hidden');
}

function editVolumeType(typeId) {
    document.getElementById('modalTitle').textContent = 'ویرایش نوع Volume';
    // Load volume type data
    document.getElementById('volumeTypeName').value = 'SSD Premium';
    document.getElementById('volumeTypeType').value = 'ssd';
    document.getElementById('volumeTypePrice').value = '5000';
    document.getElementById('volumeTypeDescription').value = '';
    document.getElementById('volumeTypeModal').classList.remove('hidden');
}

function deleteVolumeType(typeId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این نوع Volume را حذف کنید؟ این عمل غیرقابل بازگشت است.')) {
        // Delete logic
        alert('نوع Volume حذف شد');
    }
}
</script>
@endsection

