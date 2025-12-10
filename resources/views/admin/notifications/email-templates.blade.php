@extends('layouts.admin')

@section('title', 'قالب‌های ایمیل')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">قالب‌های ایمیل</h1>
        <p class="mt-1 text-sm text-gray-500">مدیریت قالب‌های ایمیل برای اعلان‌ها</p>
    </div>
    <button onclick="openCreateTemplateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2 shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        ایجاد قالب جدید
    </button>
</div>

<!-- Email Templates Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نام قالب</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">موضوع</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نوع</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">خوش‌آمدگویی</td>
                    <td class="px-6 py-4 text-sm text-gray-500">خوش آمدید به سرویس ما</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">کاربر</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editTemplate('welcome')" class="text-indigo-600 hover:text-indigo-900 mr-4">ویرایش</button>
                        <button onclick="previewTemplate('welcome')" class="text-blue-600 hover:text-blue-900">پیش‌نمایش</button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">هشدار پرداخت</td>
                    <td class="px-6 py-4 text-sm text-gray-500">پرداخت معوق - اقدام فوری</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded">هشدار</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editTemplate('payment')" class="text-indigo-600 hover:text-indigo-900 mr-4">ویرایش</button>
                        <button onclick="previewTemplate('payment')" class="text-blue-600 hover:text-blue-900">پیش‌نمایش</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Create/Edit Template Modal -->
<div id="templateModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-4/5 lg:w-3/4 shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900" id="modalTitle">ایجاد قالب جدید</h3>
            <button onclick="closeTemplateModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام قالب</label>
                    <input type="text" id="templateName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="خوش‌آمدگویی" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نوع</label>
                    <select id="templateType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="user">کاربر</option>
                        <option value="alert">هشدار</option>
                        <option value="admin">ادمین</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">موضوع ایمیل</label>
                <input type="text" id="templateSubject" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="خوش آمدید به سرویس ما" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">متن ایمیل</label>
                <textarea rows="10" id="templateBody" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" placeholder="متن ایمیل...&#10;&#10;متغیرهای قابل استفاده:&#10;{{name}} - نام کاربر&#10;{{email}} - ایمیل کاربر" required></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeTemplateModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    ذخیره قالب
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateTemplateModal() {
    document.getElementById('modalTitle').textContent = 'ایجاد قالب جدید';
    document.getElementById('templateName').value = '';
    document.getElementById('templateType').value = 'user';
    document.getElementById('templateSubject').value = '';
    document.getElementById('templateBody').value = '';
    document.getElementById('templateModal').classList.remove('hidden');
}

function closeTemplateModal() {
    document.getElementById('templateModal').classList.add('hidden');
}

function editTemplate(templateId) {
    document.getElementById('modalTitle').textContent = 'ویرایش قالب';
    // Load template data
    document.getElementById('templateName').value = 'خوش‌آمدگویی';
    document.getElementById('templateType').value = 'user';
    document.getElementById('templateSubject').value = 'خوش آمدید به سرویس ما';
    document.getElementById('templateBody').value = 'سلام {{name}}،\n\nخوش آمدید به سرویس ما!';
    document.getElementById('templateModal').classList.remove('hidden');
}

function previewTemplate(templateId) {
    alert('پیش‌نمایش قالب: ' + templateId);
}
</script>
@endsection

