@extends('layouts.customer')

@section('title', 'فاکتورها')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">فاکتورها</h1>
    <p class="mt-1 text-sm text-gray-500">لیست فاکتورهای شما</p>
</div>

<!-- Invoices List -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6">
        <p class="text-gray-500 text-center py-8">هنوز فاکتوری وجود ندارد</p>
    </div>
</div>
@endsection



