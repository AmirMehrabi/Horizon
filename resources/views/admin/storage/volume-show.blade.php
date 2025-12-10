@extends('layouts.admin')

@section('title', 'جزئیات Volume')

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
                <a href="{{ route('admin.storage.volumes') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Volume ها
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 mr-1 md:mr-2">volume-db-01</span>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">volume-db-01</h1>
            <p class="mt-1 text-sm text-gray-500">Volume ID: vol-abc123</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            <span class="w-2 h-2 rounded-full bg-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}"></span>
            متصل
        </span>
        <button onclick="openResizeModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors">
            تغییر اندازه
        </button>
        <button onclick="openSnapshotModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors">
            ایجاد Snapshot
        </button>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Volume Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">جزئیات Volume</h2>
            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام Volume</label>
                    <input type="text" value="volume-db-01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نوع Volume</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="ssd" selected>SSD</option>
                            <option value="hdd">HDD</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">اندازه (GB)</label>
                        <input type="number" value="100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" max="16384">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">پروژه</label>
                    <input type="text" value="project-acme-corp" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Instance متصل</label>
                    <div class="flex items-center gap-3">
                        <input type="text" value="db-server-01" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                        <button type="button" onclick="detachVolume()" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-medium text-sm transition-colors">
                            قطع اتصال
                        </button>
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

        <!-- Snapshots -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Snapshot ها</h2>
                <button onclick="openSnapshotModal()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ ایجاد Snapshot</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">نام</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">اندازه</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">تاریخ ایجاد</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">snapshot-db-01</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">100 GB</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">۱۴۰۳/۰۱/۱۵</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <button onclick="restoreSnapshot('snapshot-db-01')" class="text-blue-600 hover:text-blue-900 mr-4">بازگردانی</button>
                                <button onclick="deleteSnapshot('snapshot-db-01')" class="text-red-600 hover:text-red-900">حذف</button>
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
                    <span class="text-gray-500">Volume ID</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">vol-abc123</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Cinder ID</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">cinder-vol-xyz</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">نوع</span>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">SSD</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">اندازه</span>
                    <span class="font-medium text-gray-900">100 GB</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">وضعیت</span>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">متصل</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">تاریخ ایجاد</span>
                    <span class="font-medium text-gray-900">۱۴۰۳/۰۱/۱۰</span>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">عملیات</h2>
            <div class="space-y-2">
                <button onclick="openResizeModal()" class="w-full text-right px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg font-medium text-sm transition-colors">
                    تغییر اندازه
                </button>
                <button onclick="openSnapshotModal()" class="w-full text-right px-4 py-2.5 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg font-medium text-sm transition-colors">
                    ایجاد Snapshot
                </button>
                <button onclick="deleteVolume()" class="w-full text-right px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-medium text-sm transition-colors">
                    حذف Volume
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Resize Modal -->
<div id="resizeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">تغییر اندازه Volume</h3>
            <button onclick="closeResizeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    <strong>توجه:</strong> اندازه جدید باید بیشتر از اندازه فعلی باشد. تغییر اندازه ممکن است نیاز به جدا کردن Volume از Instance داشته باشد.
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">اندازه فعلی</label>
                <input type="text" value="100 GB" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">اندازه جدید (GB)</label>
                <input type="number" min="101" max="16384" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="200" required>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeResizeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    تغییر اندازه
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Snapshot Modal -->
<div id="snapshotModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">ایجاد Snapshot</h3>
            <button onclick="closeSnapshotModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">نام Snapshot</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="snapshot-db-01" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
                <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="توضیحات Snapshot..."></textarea>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="mr-2 block text-sm text-gray-700">Force (ایجاد Snapshot حتی اگر Volume متصل است)</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeSnapshotModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    ایجاد Snapshot
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openResizeModal() {
    document.getElementById('resizeModal').classList.remove('hidden');
}

function closeResizeModal() {
    document.getElementById('resizeModal').classList.add('hidden');
}

function openSnapshotModal() {
    document.getElementById('snapshotModal').classList.remove('hidden');
}

function closeSnapshotModal() {
    document.getElementById('snapshotModal').classList.add('hidden');
}

function detachVolume() {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Volume را از Instance جدا کنید؟')) {
        // Detach logic
        alert('Volume جدا شد');
    }
}

function restoreSnapshot(snapshotId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Snapshot را بازگردانی کنید؟ این عمل داده‌های فعلی Volume را جایگزین می‌کند.')) {
        // Restore logic
        alert('Snapshot بازگردانی شد');
    }
}

function deleteSnapshot(snapshotId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Snapshot را حذف کنید؟')) {
        // Delete logic
        alert('Snapshot حذف شد');
    }
}

function deleteVolume() {
    if (confirm('آیا مطمئن هستید که می‌خواهید این Volume را حذف کنید؟ این عمل غیرقابل بازگشت است.')) {
        window.location.href = "{{ route('admin.storage.volumes') }}";
    }
}
</script>
@endsection

