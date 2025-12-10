@extends('layouts.customer')

@section('title', 'مدیریت سرور')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <a href="{{ route('customer.servers.index') }}" class="text-blue-600 hover:text-blue-700 text-sm mb-2 inline-block">
            ← بازگشت به لیست سرورها
        </a>
        <h1 class="text-3xl font-bold text-gray-900">وب سرور اصلی</h1>
        <p class="mt-1 text-sm text-gray-500">Ubuntu 22.04 LTS • ۴ vCPU • ۸GB RAM</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
            فعال
        </span>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="border-b border-gray-200 mb-6">
    <nav class="-mb-px flex space-x-8 {{ $isRtl ? 'space-x-reverse' : '' }}" aria-label="Tabs">
        <button onclick="showTab('overview')" id="tab-overview" class="tab-button border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            نمای کلی
        </button>
        <button onclick="showTab('actions')" id="tab-actions" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            عملیات سرور
        </button>
        <button onclick="showTab('networking')" id="tab-networking" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            شبکه
        </button>
        <button onclick="showTab('storage')" id="tab-storage" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            ذخیره‌سازی
        </button>
    </nav>
</div>

<!-- Overview Tab -->
<div id="content-overview" class="tab-content">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Server Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Resource Usage -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">مصرف منابع</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">CPU</span>
                            <span class="font-medium text-gray-900">۲۳%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 23%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">RAM</span>
                            <span class="font-medium text-gray-900">۴.۲ GB از ۸ GB</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 52.5%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">دیسک</span>
                            <span class="font-medium text-gray-900">۳۵ GB از ۸۰ GB</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-600 h-2 rounded-full" style="width: 43.75%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Server Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">جزئیات سرور</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">نام سرور</dt>
                        <dd class="mt-1 text-sm text-gray-900">وب سرور اصلی</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">نوع</dt>
                        <dd class="mt-1 text-sm text-gray-900">VPS</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">منطقه</dt>
                        <dd class="mt-1 text-sm text-gray-900">تهران</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">IP عمومی</dt>
                        <dd class="mt-1 text-sm text-gray-900">185.123.45.67</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">IP خصوصی</dt>
                        <dd class="mt-1 text-sm text-gray-900">10.0.0.5</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">تاریخ ایجاد</dt>
                        <dd class="mt-1 text-sm text-gray-900">۱۴۰۳/۰۹/۱۵</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Quick Actions Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">عملیات سریع</h3>
                <div class="space-y-2">
                    <button onclick="showTab('actions')" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                        عملیات سرور
                    </button>
                    <button onclick="showTab('networking')" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                        مدیریت شبکه
                    </button>
                    <button onclick="showTab('storage')" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                        مدیریت ذخیره‌سازی
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions Tab -->
<div id="content-actions" class="tab-content hidden">
    <div class="space-y-6">
        <!-- Power Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">عملیات قدرت</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <button onclick="performAction('start')" class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-green-50 hover:border-green-300 transition-colors">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">شروع</span>
                </button>
                <button onclick="performAction('stop')" class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-red-50 hover:border-red-300 transition-colors">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6v4H9z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">توقف</span>
                </button>
                <button onclick="performAction('restart')" class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">راه‌اندازی مجدد</span>
                </button>
            </div>
        </div>

        <!-- Reboot Options -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">راه‌اندازی مجدد</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <button onclick="performAction('soft-reboot')" class="flex items-center justify-between px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <div>
                        <p class="text-sm font-medium text-gray-900">راه‌اندازی مجدد نرم</p>
                        <p class="text-xs text-gray-500 mt-1">راه‌اندازی مجدد از طریق سیستم عامل</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
                <button onclick="performAction('hard-reboot')" class="flex items-center justify-between px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <div>
                        <p class="text-sm font-medium text-gray-900">راه‌اندازی مجدد سخت</p>
                        <p class="text-xs text-gray-500 mt-1">راه‌اندازی مجدد فوری از طریق Hypervisor</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Advanced Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">عملیات پیشرفته</h2>
            <div class="space-y-4">
                <button onclick="performAction('rescue-mode')" class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 rounded-lg hover:bg-yellow-50 hover:border-yellow-300 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">حالت نجات</p>
                            <p class="text-xs text-gray-500">راه‌اندازی سرور در حالت نجات برای رفع مشکل</p>
                        </div>
                    </div>
                </button>
                <button onclick="showResizeModal()" class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                        </svg>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">تغییر اندازه</p>
                            <p class="text-xs text-gray-500">ارتقا یا کاهش منابع سرور</p>
                        </div>
                    </div>
                </button>
                <button onclick="showRebuildModal()" class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">بازسازی سیستم عامل</p>
                            <p class="text-xs text-gray-500">نصب مجدد سیستم عامل با حفظ IP</p>
                        </div>
                    </div>
                </button>
                <button onclick="showRestoreModal()" class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 rounded-lg hover:bg-indigo-50 hover:border-indigo-300 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">بازیابی از پشتیبان</p>
                            <p class="text-xs text-gray-500">بازیابی سرور از یک snapshot</p>
                        </div>
                    </div>
                </button>
                <button onclick="showDeleteModal()" class="w-full flex items-center justify-between px-4 py-3 border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <div class="text-right">
                            <p class="text-sm font-medium text-red-900">حذف سرور</p>
                            <p class="text-xs text-red-500">حذف دائمی سرور و تمام داده‌ها</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Networking Tab -->
<div id="content-networking" class="tab-content hidden">
    <div class="space-y-6">
        <!-- VNC Console -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">کنسول VNC</h2>
            <p class="text-sm text-gray-600 mb-4">دسترسی مستقیم به کنسول سرور از طریق VNC</p>
            <button onclick="openVNCConsole()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                باز کردن کنسول VNC
            </button>
        </div>

        <!-- Floating IPs -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">IP های شناور</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">185.123.45.67</p>
                        <p class="text-xs text-gray-500 mt-1">متصل به این سرور</p>
                    </div>
                    <button onclick="removeFloatingIP('185.123.45.67')" class="text-red-600 hover:text-red-700 text-sm font-medium">
                        حذف
                    </button>
                </div>
                <button onclick="showAssignIPModal()" class="w-full border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-500 hover:bg-blue-50 transition-colors text-center">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-700">اختصاص IP شناور جدید</p>
                </button>
            </div>
        </div>

        <!-- Security Groups -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">گروه‌های امنیتی</h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">پیش‌فرض</p>
                        <p class="text-xs text-gray-500 mt-1">SSH (22), HTTP (80), HTTPS (443)</p>
                    </div>
                    <button onclick="editSecurityGroup('default')" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        ویرایش
                    </button>
                </div>
                <button onclick="showAddSecurityGroupModal()" class="w-full border-2 border-dashed border-gray-300 rounded-lg p-3 hover:border-blue-500 hover:bg-blue-50 transition-colors text-center text-sm font-medium text-gray-700">
                    + افزودن گروه امنیتی
                </button>
            </div>
        </div>

        <!-- Bandwidth Usage -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">مصرف پهنای باند</h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">مصرف این ماه</span>
                        <span class="font-medium text-gray-900">۲۸۵ GB از ۲TB</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 14.25%"></div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">ورودی:</p>
                        <p class="font-medium text-gray-900">۱۲۰ GB</p>
                    </div>
                    <div>
                        <p class="text-gray-600">خروجی:</p>
                        <p class="font-medium text-gray-900">۱۶۵ GB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Storage Tab -->
<div id="content-storage" class="tab-content hidden">
    <div class="space-y-6">
        <!-- Attached Volumes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">حجم‌های متصل</h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">حجم اصلی</p>
                        <p class="text-xs text-gray-500 mt-1">۸۰ GB • SSD</p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="showResizeVolumeModal('main')" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            تغییر اندازه
                        </button>
                        <button onclick="showSnapshotModal('main')" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                            ایجاد Snapshot
                        </button>
                    </div>
                </div>
                <button onclick="showAttachVolumeModal()" class="w-full border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-500 hover:bg-blue-50 transition-colors text-center">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-700">اتصال حجم جدید</p>
                </button>
            </div>
        </div>

        <!-- Snapshots -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Snapshots</h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Snapshot قبل از به‌روزرسانی</p>
                        <p class="text-xs text-gray-500 mt-1">۱۴۰۳/۰۹/۲۰ • ۸۰ GB</p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="restoreFromSnapshot('snapshot-1')" class="text-green-600 hover:text-green-700 text-sm font-medium">
                            بازیابی
                        </button>
                        <button onclick="deleteSnapshot('snapshot-1')" class="text-red-600 hover:text-red-700 text-sm font-medium">
                            حذف
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals will be added here -->
<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(`content-${tabName}`).classList.remove('hidden');
    
    // Activate selected tab
    const activeTab = document.getElementById(`tab-${tabName}`);
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-blue-500', 'text-blue-600');
}

function performAction(action) {
    if (confirm(`آیا از انجام عملیات "${action}" مطمئن هستید؟`)) {
        // TODO: Implement actual action
        alert(`عملیات ${action} در حال انجام است...`);
    }
}

function showResizeModal() {
    alert('مدال تغییر اندازه - در حال توسعه');
}

function showRebuildModal() {
    alert('مدال بازسازی سیستم عامل - در حال توسعه');
}

function showRestoreModal() {
    alert('مدال بازیابی از پشتیبان - در حال توسعه');
}

function showDeleteModal() {
    if (confirm('آیا از حذف دائمی این سرور مطمئن هستید؟ این عملیات قابل بازگشت نیست.')) {
        alert('سرور در حال حذف است...');
    }
}

function openVNCConsole() {
    window.open('/vnc-console/{{ $id }}', '_blank', 'width=1024,height=768');
}

function removeFloatingIP(ip) {
    if (confirm(`آیا از حذف IP ${ip} مطمئن هستید؟`)) {
        alert('IP در حال حذف است...');
    }
}

function showAssignIPModal() {
    alert('مدال اختصاص IP شناور - در حال توسعه');
}

function editSecurityGroup(group) {
    alert(`ویرایش گروه امنیتی ${group} - در حال توسعه`);
}

function showAddSecurityGroupModal() {
    alert('مدال افزودن گروه امنیتی - در حال توسعه');
}

function showResizeVolumeModal(volume) {
    alert(`مدال تغییر اندازه حجم ${volume} - در حال توسعه`);
}

function showSnapshotModal(volume) {
    if (confirm('آیا می‌خواهید از این حجم Snapshot ایجاد کنید؟')) {
        alert('Snapshot در حال ایجاد است...');
    }
}

function showAttachVolumeModal() {
    alert('مدال اتصال حجم - در حال توسعه');
}

function restoreFromSnapshot(snapshotId) {
    if (confirm('آیا از بازیابی از این Snapshot مطمئن هستید؟ تمام داده‌های فعلی از بین خواهد رفت.')) {
        alert('بازیابی در حال انجام است...');
    }
}

function deleteSnapshot(snapshotId) {
    if (confirm('آیا از حذف این Snapshot مطمئن هستید؟')) {
        alert('Snapshot در حال حذف است...');
    }
}
</script>
@endsection

