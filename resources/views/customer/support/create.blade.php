@extends('layouts.customer')

@section('title', 'ایجاد تیکت پشتیبانی')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">ایجاد تیکت پشتیبانی</h1>
    <p class="mt-1 text-sm text-gray-500">ارسال درخواست پشتیبانی</p>
</div>

<!-- Support Ticket Form -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl">
    <form>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">موضوع</label>
            <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">اولویت</label>
            <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                <option>پایین</option>
                <option>متوسط</option>
                <option>بالا</option>
                <option>فوری</option>
            </select>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">پیام</label>
            <textarea rows="6" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>
        
        <div class="flex justify-end gap-4">
            <a href="{{ route('customer.support.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-6 rounded-lg transition-colors">
                انصراف
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                ارسال تیکت
            </button>
        </div>
    </form>
</div>
@endsection



