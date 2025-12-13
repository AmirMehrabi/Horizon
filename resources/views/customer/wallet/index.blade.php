@extends('layouts.customer')

@section('title', 'کیف پول')

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
                'label' => 'کیف پول',
                'active' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>'
            ]
        ]
    ])
@endsection

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">کیف پول</h1>
        <p class="mt-1 text-sm text-gray-500">مدیریت موجودی، شارژ و تاریخچه تراکنش‌ها</p>
    </div>
    <div>
        <a href="{{ route('customer.wallet.topup') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            شارژ کیف پول
        </a>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Balance Card -->
        <div class="bg-blue-50 rounded-lg border border-blue-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-medium text-gray-700">موجودی فعلی</h2>
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <p class="text-3xl font-semibold text-gray-900 mb-2">{{ $wallet->formatted_balance }}</p>
            <p class="text-xs text-gray-500">پس از هر پرداخت یا شارژ به‌صورت خودکار به‌روزرسانی می‌شود</p>
        </div>

        <!-- Payment Methods Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-gray-900">روش‌های پرداخت ذخیره‌شده</h2>
                <button onclick="showAddPaymentMethodModal()" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    افزودن
                </button>
            </div>
            <div class="space-y-3">
                @foreach($paymentMethods as $method)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        @if($method['type'] === 'card')
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        @else
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $method['label'] }}</p>
                            @if($method['status'] === 'default')
                            <p class="text-xs text-gray-500">پیش‌فرض</p>
                            @endif
                        </div>
                    </div>
                    @if($method['status'] === 'default')
                    <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded">پیش‌فرض</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="lg:col-span-2">
        <!-- Recent Transactions Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">تراکنش‌های اخیر کیف پول</h2>
                    <div class="flex items-center gap-3">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text" placeholder="جستجو..." class="pl-10 pr-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <svg class="w-4 h-4 absolute {{ $isRtl ? 'right-3' : 'left-3' }} top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <!-- Filter -->
                        <select class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-blue-500 focus:border-blue-500">
                            <option>همه وضعیت‌ها</option>
                            <option>موفق</option>
                            <option>تکمیل شده</option>
                            <option>ناموفق</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">توضیحات</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">مبلغ</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction['date'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $transaction['description'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $transaction['amount'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction['amount_formatted'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($transaction['status_color'] === 'green') bg-green-100 text-green-800
                                    @elseif($transaction['status_color'] === 'blue') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $transaction['status'] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                هیچ تراکنشی یافت نشد
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    نمایش <span class="font-medium">1</span> تا <span class="font-medium">5</span> از <span class="font-medium">5</span> تراکنش
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        قبلی
                    </button>
                    <button class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        بعدی
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Payment Method Modal (Placeholder) -->
<div id="addPaymentMethodModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">افزودن روش پرداخت</h3>
        </div>
        <div class="px-6 py-4">
            <p class="text-sm text-gray-600">این ویژگی به زودی اضافه خواهد شد.</p>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
            <button onclick="closeAddPaymentMethodModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium">
                بستن
            </button>
        </div>
    </div>
</div>

<script>
function showAddPaymentMethodModal() {
    document.getElementById('addPaymentMethodModal').classList.remove('hidden');
}

function closeAddPaymentMethodModal() {
    document.getElementById('addPaymentMethodModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('addPaymentMethodModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddPaymentMethodModal();
    }
});
</script>
@endsection
