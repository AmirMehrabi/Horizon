@extends('layouts.customer')

@section('title', 'تیکت‌های پشتیبانی')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">تیکت‌های پشتیبانی</h1>
        <p class="mt-1 text-sm text-gray-500">مدیریت تیکت‌های پشتیبانی</p>
    </div>
    <a href="{{ route('customer.support.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
        + ایجاد تیکت جدید
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <p class="text-gray-500 text-center py-8">هنوز تیکتی ایجاد نشده است</p>
</div>
@endsection



