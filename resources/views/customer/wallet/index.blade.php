@extends('layouts.customer')

@section('title', 'کیف پول')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">کیف پول</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت موجودی و تراکنش‌های کیف پول</p>
</div>

<!-- Wallet Balance -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="text-center">
        <p class="text-sm text-gray-500 mb-2">موجودی فعلی</p>
        <p class="text-4xl font-bold text-gray-900">۱,۲۵۰,۰۰۰ تومان</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('customer.wallet.topup') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-6 rounded-lg transition-colors text-center">
        شارژ کیف پول
    </a>
    <a href="#" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-4 px-6 rounded-lg transition-colors text-center">
        تاریخچه تراکنش‌ها
    </a>
</div>
@endsection

