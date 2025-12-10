@extends('layouts.customer')

@section('title', 'کلیدهای API')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">کلیدهای API</h1>
        <p class="mt-1 text-sm text-gray-500">مدیریت کلیدهای دسترسی API</p>
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
        + ایجاد کلید جدید
    </button>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <p class="text-gray-500 text-center py-8">هنوز کلید API ایجاد نشده است</p>
</div>
@endsection



