@extends('layouts.customer')

@section('title', 'گزارشات مصرف')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">گزارشات مصرف</h1>
    <p class="mt-1 text-sm text-gray-500">گزارشات مصرف منابع شما</p>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <p class="text-gray-500 text-center py-8">گزارشات مصرف</p>
</div>
@endsection



