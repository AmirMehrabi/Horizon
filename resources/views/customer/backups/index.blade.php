@extends('layouts.customer')

@section('title', 'پشتیبان‌گیری')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">پشتیبان‌گیری</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت پشتیبان‌های شما</p>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <p class="text-gray-500 text-center py-8">هنوز پشتیبانی ایجاد نشده است</p>
</div>
@endsection



