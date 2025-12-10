@extends('layouts.customer')

@section('title', 'فاکتورها')

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
                'label' => 'فاکتورها',
                'active' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>'
            ]
        ]
    ])
@endsection

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



