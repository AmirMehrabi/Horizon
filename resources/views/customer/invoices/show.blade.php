@extends('layouts.customer')

@section('title', 'فاکتور شماره #INV-2024-001')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
    $invoice = [
        'id' => 1,
        'number' => 'INV-2024-001',
        'status' => 'unpaid', // paid, unpaid, overdue, processing
        'issue_date' => '۱۴۰۳/۰۹/۱۵',
        'due_date' => '۱۴۰۳/۰۹/۲۵',
        'total' => 4500000,
        'subtotal' => 4200000,
        'tax' => 270000,
        'discount' => 0,
        'customer' => [
            'name' => 'علی احمدی',
            'id' => 'CUST-12345',
            'email' => 'ali@example.com',
            'phone' => '09123456789',
        ],
        'company' => [
            'name' => 'شرکت ابری آویاتو',
            'tax_id' => '1234567890',
            'address' => 'تهران، خیابان ولیعصر، پلاک ۱۲۳',
            'support_phone' => '021-12345678',
        ],
        'line_items' => [
            ['description' => 'اجاره VPS ماهانه - وب سرور اصلی', 'quantity' => '۱ ماه', 'unit_price' => 1500000, 'amount' => 1500000],
            ['description' => 'مصرف CPU به ساعت', 'quantity' => '۷۲۰ ساعت', 'unit_price' => 500, 'amount' => 360000],
            ['description' => 'حجم ترافیک مصرفی', 'quantity' => '۲۸۵ GB', 'unit_price' => 1000, 'amount' => 285000],
            ['description' => 'فضای ذخیره‌سازی حجم بالا', 'quantity' => '۱۰۰ GB', 'unit_price' => 2000, 'amount' => 200000],
            ['description' => 'IP شناور', 'quantity' => '۱ عدد', 'unit_price' => 50000, 'amount' => 50000],
            ['description' => 'نسخه پشتیبان', 'quantity' => '۳ نسخه', 'unit_price' => 100000, 'amount' => 300000],
            ['description' => 'سرویس پایگاه داده', 'quantity' => '۱ ماه', 'unit_price' => 1200000, 'amount' => 1200000],
        ],
        'timeline' => [
            ['event' => 'فاکتور ایجاد شد', 'date' => '۱۴۰۳/۰۹/۱۵ ۱۰:۳۰', 'icon' => 'created'],
            ['event' => 'ایمیل ارسال شد', 'date' => '۱۴۰۳/۰۹/۱۵ ۱۰:۳۵', 'icon' => 'email'],
        ],
    ];
    $walletBalance = 1200000;
    $canPayFromWallet = $walletBalance >= $invoice['total'];
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
                'url' => route('customer.invoices.index'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>'
            ],
            [
                'label' => 'فاکتور #' . $invoice['number'],
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Export Options Bar -->
    <div class="mb-6 flex items-center justify-between bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center gap-3">
            <button onclick="printInvoice()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                پرینت
            </button>
            <button onclick="downloadPDF()" class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                دانلود PDF
            </button>
            <button onclick="downloadExcel()" class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                دانلود Excel
            </button>
        </div>
    </div>

    <!-- Invoice Document -->
    <div class="bg-white rounded-lg shadow-sm border-2 border-gray-300 p-8 print:shadow-none print:border-0" id="invoice-document">
        <!-- Header Section -->
        <div class="border-b-2 border-gray-300 pb-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">فاکتور شماره {{ $invoice['number'] }}</h1>
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <div>
                            <span class="font-medium">تاریخ صدور:</span>
                            <span>{{ $invoice['issue_date'] }}</span>
                        </div>
                        <div>
                            <span class="font-medium">تاریخ سررسید:</span>
                            <span class="{{ $invoice['status'] === 'overdue' ? 'text-red-600 font-semibold' : '' }}">{{ $invoice['due_date'] }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    @if($invoice['status'] === 'paid')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            پرداخت شده
                        </span>
                    @elseif($invoice['status'] === 'unpaid')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            پرداخت نشده
                        </span>
                    @elseif($invoice['status'] === 'overdue')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                            <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            منقضی شده
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }} animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            در حال پردازش
                        </span>
                    @endif
                </div>
            </div>

            <!-- Company Logo Placeholder -->
            <div class="flex items-center justify-between">
                <div class="w-32 h-16 bg-gray-200 rounded flex items-center justify-center">
                    <span class="text-gray-500 text-sm">لوگو شرکت</span>
                </div>
            </div>
        </div>

        <!-- Customer & Company Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Customer Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات مشتری</h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">نام کامل:</span>
                        <span class="text-gray-900">{{ $invoice['customer']['name'] }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">شماره مشتری:</span>
                        <span class="text-gray-900">{{ $invoice['customer']['id'] }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">ایمیل:</span>
                        <span class="text-gray-900">{{ $invoice['customer']['email'] }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">شماره تماس:</span>
                        <span class="text-gray-900">{{ $invoice['customer']['phone'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Company Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات شرکت</h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">نام شرکت:</span>
                        <span class="text-gray-900">{{ $invoice['company']['name'] }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">شناسه مالیاتی:</span>
                        <span class="text-gray-900">{{ $invoice['company']['tax_id'] }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">آدرس:</span>
                        <span class="text-gray-900">{{ $invoice['company']['address'] }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">تلفن پشتیبانی:</span>
                        <span class="text-gray-900">{{ $invoice['company']['support_phone'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">جزئیات فاکتور</h3>
            <div class="overflow-x-auto w-full">
                <table class="w-full divide-y divide-gray-200 border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider border-l border-gray-300">شرح آیتم</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider border-l border-gray-300">تعداد / ساعت / گیگابایت</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider border-l border-gray-300">قیمت واحد (ریال)</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">مبلغ (ریال)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($invoice['line_items'] as $index => $item)
                        <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                            <td class="px-6 py-4 text-sm text-gray-900 border-l border-gray-200">{{ $item['description'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 text-center border-l border-gray-200">{{ $item['quantity'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 text-left border-l border-gray-200">{{ number_format($item['unit_price']) }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 text-left">{{ number_format($item['amount']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totals Section -->
        <div class="flex justify-end mb-8">
            <div class="w-full md:w-96 border-2 border-gray-300 rounded-lg p-6 bg-gray-50">
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">مجموع:</span>
                        <span class="font-medium text-gray-900">{{ number_format($invoice['subtotal']) }} ریال</span>
                    </div>
                    @if($invoice['tax'] > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">مالیات (۹٪):</span>
                        <span class="font-medium text-gray-900">{{ number_format($invoice['tax']) }} ریال</span>
                    </div>
                    @endif
                    @if($invoice['discount'] > 0)
                    <div class="flex justify-between text-sm text-green-600">
                        <span>تخفیف:</span>
                        <span class="font-medium">-{{ number_format($invoice['discount']) }} ریال</span>
                    </div>
                    @endif
                    <div class="border-t-2 border-gray-400 pt-3 mt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-gray-900">مبلغ قابل پرداخت نهایی:</span>
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($invoice['total']) }} ریال</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Section -->
        @if($invoice['status'] !== 'paid')
        <div class="mb-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">پرداخت فاکتور</h3>
                <div class="text-sm text-gray-600">
                    <span>موجودی کیف پول:</span>
                    <span class="font-medium text-gray-900">{{ number_format($walletBalance) }} ریال</span>
                </div>
            </div>
            
            @if($canPayFromWallet)
            <button onclick="payFromWallet()" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                پرداخت از کیف پول
            </button>
            @else
            <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-yellow-800">موجودی شما کافی نیست</p>
                        <p class="text-sm text-yellow-700 mt-1">برای پرداخت این فاکتور، ابتدا کیف پول خود را شارژ کنید.</p>
                        <a href="{{ route('customer.wallet.topup') }}" class="mt-2 inline-block text-sm text-yellow-800 font-medium hover:underline">شارژ کیف پول →</a>
                    </div>
                </div>
            </div>
            <button onclick="payWithOtherMethod()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                پرداخت با روش دیگر
            </button>
            @endif
        </div>
        @else
        <div class="mb-8 p-6 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-semibold text-green-800">این فاکتور پرداخت شده است.</p>
            </div>
        </div>
        @endif

        <!-- Timeline / Activity Log -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">تاریخچه فاکتور</h3>
            <div class="space-y-4">
                @foreach($invoice['timeline'] as $event)
                <div class="flex items-start gap-4">
                    <div class="shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        @if($event['icon'] === 'created')
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        @elseif($event['icon'] === 'email')
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        @else
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $event['event'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $event['date'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Related Resources (Optional) -->
        <div class="border-t border-gray-300 pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">منابع مرتبط</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('customer.servers.show', 1) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                    </svg>
                    وب سرور اصلی
                </a>
                <a href="{{ route('customer.storage.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    فضای ذخیره‌سازی
                </a>
                <a href="{{ route('customer.networks.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    IP شناور
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function printInvoice() {
    window.print();
}

function downloadPDF() {
    window.location.href = '/customer/invoices/{{ $invoice["id"] }}/download/pdf';
}

function downloadExcel() {
    window.location.href = '/customer/invoices/{{ $invoice["id"] }}/download/excel';
}

function payFromWallet() {
    if (confirm('آیا مطمئن هستید که می‌خواهید این فاکتور را از کیف پول پرداخت کنید؟')) {
        // Implement payment logic
        window.location.href = '/customer/invoices/{{ $invoice["id"] }}/pay';
    }
}

function payWithOtherMethod() {
    // Implement other payment methods
    alert('روش‌های پرداخت دیگر به زودی اضافه خواهد شد.');
}

// Print styles
const style = document.createElement('style');
style.textContent = `
    @media print {
        body * {
            visibility: hidden;
        }
        #invoice-document, #invoice-document * {
            visibility: visible;
        }
        #invoice-document {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }
`;
document.head.appendChild(style);
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    body {
        background: white;
    }
    #invoice-document {
        box-shadow: none;
        border: none;
    }
}
</style>
@endsection
