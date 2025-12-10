@extends('layouts.customer')

@section('title', 'فضای ذخیره‌سازی')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('header_content')
    @include('customer.partials.breadcrumb', [
        'items' => [
            [
                'label' => 'داشبورد',
                'url' => route('customer.dashboard'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>'
            ],
            [
                'label' => 'ذخیره‌سازی',
                'active' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>'
            ]
        ]
    ])
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">فضای ذخیره‌سازی</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت حجم‌های ذخیره‌سازی</p>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <p class="text-gray-500 text-center py-8">هنوز حجمی ایجاد نشده است</p>
</div>
@endsection



