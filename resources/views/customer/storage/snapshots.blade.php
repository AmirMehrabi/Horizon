@extends('layouts.customer')

@section('title', 'اسنپ‌شات‌ها')

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
                'label' => 'فضای ذخیره‌سازی',
                'url' => route('customer.storage.index'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>'
            ],
            [
                'label' => 'اسنپ‌شات‌ها',
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
                <h1 class="text-3xl font-bold text-gray-900">اسنپ‌شات‌ها</h1>
                <p class="mt-1 text-sm text-gray-500">مدیریت اسنپ‌شات‌های حجم‌های ذخیره‌سازی</p>
            </div>
            <button onclick="openCreateSnapshotModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                ایجاد اسنپ‌شات
            </button>
        </div>
    </div>

    <!-- Snapshots Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">کل اسنپ‌شات‌ها</p>
                    <p class="text-2xl font-semibold text-gray-900">۸</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">حجم کل</p>
                    <p class="text-2xl font-semibold text-gray-900">۷۰ GB</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">هزینه ماهانه</p>
                    <p class="text-2xl font-semibold text-gray-900">۱۴۰,۰۰۰ تومان</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <div class="relative">
                    <input type="text" placeholder="جستجو در اسنپ‌شات‌ها..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                
                <select class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">همه حجم‌ها</option>
                    <option value="database-storage">database-storage</option>
                    <option value="web-storage">web-storage</option>
                    <option value="backup-storage">backup-storage</option>
                </select>

                <select class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="available">در دسترس</option>
                    <option value="creating">در حال ایجاد</option>
                    <option value="deleting">در حال حذف</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button class="px-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Snapshots Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اسنپ‌شات</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">حجم مبدأ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اندازه</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ ایجاد</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">database-backup-daily</div>
                                    <div class="text-sm text-gray-500">پشتیبان‌گیری روزانه پایگاه داده</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">database-storage</div>
                            <div class="text-sm text-gray-500">۱۰۰ GB • SSD</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۲۵ GB</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                در دسترس
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>۱۴۰۳/۰۹/۲۵</div>
                            <div class="text-xs text-gray-400">۱۴:۳۰</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <button onclick="restoreSnapshot('snap-1')" class="text-blue-600 hover:text-blue-900">بازگردانی</button>
                                <button onclick="createVolumeFromSnapshot('snap-1')" class="text-green-600 hover:text-green-900">ایجاد حجم</button>
                                <button onclick="deleteSnapshot('snap-1')" class="text-red-600 hover:text-red-900">حذف</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">web-files-backup</div>
                                    <div class="text-sm text-gray-500">پشتیبان فایل‌های وب سایت</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">web-storage</div>
                            <div class="text-sm text-gray-500">۸۰ GB • SSD</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۱۵ GB</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                در دسترس
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>۱۴۰۳/۰۹/۲۳</div>
                            <div class="text-xs text-gray-400">۰۹:۱۵</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <button onclick="restoreSnapshot('snap-2')" class="text-blue-600 hover:text-blue-900">بازگردانی</button>
                                <button onclick="createVolumeFromSnapshot('snap-2')" class="text-green-600 hover:text-green-900">ایجاد حجم</button>
                                <button onclick="deleteSnapshot('snap-2')" class="text-red-600 hover:text-red-900">حذف</button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                    <svg class="w-5 h-5 text-yellow-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">logs-backup-weekly</div>
                                    <div class="text-sm text-gray-500">پشتیبان هفتگی لاگ‌ها</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">logs-storage</div>
                            <div class="text-sm text-gray-500">۳۰ GB • NVMe</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">۸ GB</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                در حال ایجاد
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>۱۴۰۳/۰۹/۲۵</div>
                            <div class="text-xs text-gray-400">۱۶:۴۵</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <span class="text-gray-400">در حال پردازش...</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">قبلی</a>
                    <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">بعدی</a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">نمایش <span class="font-medium">۱</span> تا <span class="font-medium">۳</span> از <span class="font-medium">۸</span> نتیجه</p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">قبلی</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">۱</a>
                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">۲</a>
                            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">۳</a>
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">بعدی</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Snapshot Modal -->
<div id="createSnapshotModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">ایجاد اسنپ‌شات جدید</h3>
            </div>
            
            <form class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">انتخاب حجم</label>
                    <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">انتخاب حجم...</option>
                        <option value="database-storage">database-storage (۱۰۰ GB)</option>
                        <option value="web-storage">web-storage (۸۰ GB)</option>
                        <option value="backup-storage">backup-storage (۵۰ GB)</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام اسنپ‌شات</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="my-snapshot">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات (اختیاری)</label>
                    <textarea rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="توضیحات اسنپ‌شات..."></textarea>
                </div>
                
                <div class="p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-700">
                        <span class="font-medium">هزینه تخمینی:</span>
                        <span class="text-lg font-bold text-blue-600">۵۰,۰۰۰ تومان/ماه</span>
                    </p>
                    <p class="text-xs text-gray-600 mt-1">بر اساس اندازه حجم انتخاب شده</p>
                </div>
            </form>
            
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeCreateSnapshotModal()" class="px-4 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">
                    انصراف
                </button>
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    ایجاد اسنپ‌شات
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openCreateSnapshotModal() {
    document.getElementById('createSnapshotModal').classList.remove('hidden');
}

function closeCreateSnapshotModal() {
    document.getElementById('createSnapshotModal').classList.add('hidden');
}

function restoreSnapshot(snapshotId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این اسنپ‌شات را بازگردانی کنید؟')) {
        // Implement restore logic
        console.log('Restoring snapshot:', snapshotId);
    }
}

function createVolumeFromSnapshot(snapshotId) {
    // Implement create volume from snapshot logic
    console.log('Creating volume from snapshot:', snapshotId);
}

function deleteSnapshot(snapshotId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این اسنپ‌شات را حذف کنید؟ این عمل قابل بازگشت نیست.')) {
        // Implement delete logic
        console.log('Deleting snapshot:', snapshotId);
    }
}

// Close modal when clicking outside
document.getElementById('createSnapshotModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeCreateSnapshotModal();
    }
});
</script>
@endsection
