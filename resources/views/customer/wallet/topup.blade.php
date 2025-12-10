@extends('layouts.customer')

@section('title', 'شارژ کیف پول')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">شارژ کیف پول</h1>
    <p class="mt-1 text-sm text-gray-500">افزایش موجودی کیف پول</p>
</div>

<!-- Top-up Form -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-md mx-auto">
    <form>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">مبلغ شارژ (تومان)</label>
            <input type="number" min="10000" step="10000" value="100000" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">روش پرداخت</label>
            <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                <option>درگاه پرداخت آنلاین</option>
                <option>کارت به کارت</option>
            </select>
        </div>
        
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
            پرداخت
        </button>
    </form>
</div>
@endsection

