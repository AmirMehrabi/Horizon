@extends('layouts.admin')

@section('title', 'SMS/Telegram')

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
    <h1 class="text-3xl font-bold text-gray-900">SMS/Telegram</h1>
    <p class="mt-1 text-sm text-gray-500">تنظیمات اعلان‌های SMS و Telegram</p>
</div>

<!-- SMS Settings -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">تنظیمات SMS</h2>
    <form class="space-y-6">
        <div>
            <label class="flex items-center">
                <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <span class="mr-2 block text-sm text-gray-700">فعال‌سازی SMS</span>
            </label>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">API Provider</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="kavenegar">کاوه نگار</option>
                <option value="melipayamak">ملی پیامک</option>
                <option value="smsir">پیامک آی آر</option>
            </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="API Key">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">شماره فرستنده</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="10001000">
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

<!-- Telegram Settings -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">تنظیمات Telegram</h2>
    <form class="space-y-6">
        <div>
            <label class="flex items-center">
                <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <span class="mr-2 block text-sm text-gray-700">فعال‌سازی Telegram</span>
            </label>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Bot Token</label>
            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="123456789:ABCdefGHIjklMNOpqrsTUVwxyz">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Chat ID</label>
            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="-1001234567890">
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

<!-- Notification Types -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">انواع اعلان‌ها</h2>
    <div class="space-y-4">
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <h3 class="text-sm font-medium text-gray-900">هشدار پرداخت معوق</h3>
                <p class="text-xs text-gray-500">ارسال SMS و Telegram برای پرداخت معوق</p>
            </div>
            <div class="flex items-center gap-4">
                <label class="flex items-center">
                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="mr-2 text-sm text-gray-700">SMS</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="mr-2 text-sm text-gray-700">Telegram</span>
                </label>
            </div>
        </div>
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <h3 class="text-sm font-medium text-gray-900">VM Down</h3>
                <p class="text-xs text-gray-500">اعلان زمانی که Instance خاموش می‌شود</p>
            </div>
            <div class="flex items-center gap-4">
                <label class="flex items-center">
                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="mr-2 text-sm text-gray-700">SMS</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="mr-2 text-sm text-gray-700">Telegram</span>
                </label>
            </div>
        </div>
    </div>
</div>
@endsection

