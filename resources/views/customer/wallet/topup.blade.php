@extends('layouts.customer')

@section('title', 'شارژ کیف پول')

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
                'url' => route('customer.wallet.index'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>'
            ],
            [
                'label' => 'شارژ کیف پول',
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">شارژ کیف پول</h1>
    <p class="mt-1 text-sm text-gray-500">افزایش موجودی برای پرداخت سرویس‌ها</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form id="topupForm" method="POST" action="{{ route('customer.wallet.topup.process') }}">
                @csrf
                
                <!-- Amount Field -->
                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        مبلغ شارژ
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="amount" 
                            name="amount" 
                            placeholder="500000" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-12 text-lg focus:ring-blue-500 focus:border-blue-500"
                            oninput="handleAmountInput(this); updateSummary()"
                            onblur="formatCurrency(this)"
                            required
                        >
                        <span class="absolute {{ $isRtl ? 'left-4' : 'right-4' }} top-1/2 transform -translate-y-1/2 text-gray-500">ریال</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">حداقل مبلغ شارژ: ۱۰,۰۰۰ ریال</p>
                </div>
                
                <!-- Payment Method Field -->
                <div class="mb-6">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                        روش پرداخت
                    </label>
                    <select 
                        id="payment_method" 
                        name="payment_method" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                        onchange="updateSummary()"
                        required
                    >
                        <option value="">انتخاب روش پرداخت</option>
                        @foreach($paymentMethods as $key => $method)
                        <option value="{{ $key }}">{{ $method }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors"
                >
                    <span>ادامه و پرداخت</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Side Panel Summary -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-24">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">خلاصه پرداخت</h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                    <span class="text-sm text-gray-600">روش انتخاب‌شده</span>
                    <span id="summary-method" class="text-sm font-medium text-gray-900">-</span>
                </div>
                
                <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                    <span class="text-sm text-gray-600">کارمزد</span>
                    <span class="text-sm font-medium text-gray-900">۰ ریال</span>
                </div>
                
                <div class="flex items-center justify-between pt-2">
                    <span class="text-sm font-medium text-gray-700">موجودی جدید (تقریبی)</span>
                    <span id="summary-new-balance" class="text-lg font-semibold text-blue-600">{{ number_format($currentBalance, 0) }} ریال</span>
                </div>
            </div>
            
            <div class="mt-6 p-3 bg-blue-50 rounded-lg">
                <p class="text-xs text-blue-700">
                    <svg class="w-4 h-4 inline {{ $isRtl ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    موجودی بلافاصله پس از پرداخت موفق به کیف پول شما اضافه می‌شود.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function handleAmountInput(input) {
    // Only allow digits, remove everything else
    let value = input.value.replace(/[^\d]/g, '');
    input.value = value;
    updateSummary();
}

function formatCurrency(input) {
    // Remove all non-digit characters
    let value = input.value.replace(/[^\d]/g, '');
    
    // Format with thousand separators using English locale (commas)
    if (value) {
        value = parseInt(value).toLocaleString('en-US');
    }
    
    input.value = value;
    updateSummary();
}

function updateSummary() {
    const amountInput = document.getElementById('amount');
    const paymentMethod = document.getElementById('payment_method');
    const summaryMethod = document.getElementById('summary-method');
    const summaryNewBalance = document.getElementById('summary-new-balance');
    
    // Update payment method
    if (paymentMethod.value) {
        summaryMethod.textContent = paymentMethod.value;
    } else {
        summaryMethod.textContent = '-';
    }
    
    // Calculate new balance
    const currentBalance = {{ $currentBalance }};
    const amountValue = amountInput.value.replace(/[^\d]/g, '');
    
    if (amountValue && !isNaN(amountValue)) {
        const amount = parseInt(amountValue);
        const newBalance = currentBalance + amount;
        summaryNewBalance.textContent = newBalance.toLocaleString('en-US') + ' ریال';
    } else {
        summaryNewBalance.textContent = currentBalance.toLocaleString('en-US') + ' ریال';
    }
}

// Form submission
document.getElementById('topupForm')?.addEventListener('submit', function(e) {
    const amountInput = document.getElementById('amount');
    const paymentMethod = document.getElementById('payment_method');
    
    const amountValue = amountInput.value.replace(/[^\d]/g, '');
    
    if (!amountValue || parseInt(amountValue) < 10000) {
        e.preventDefault();
        alert('حداقل مبلغ شارژ ۱۰,۰۰۰ ریال است.');
        return;
    }
    
    if (!paymentMethod.value) {
        e.preventDefault();
        alert('لطفاً روش پرداخت را انتخاب کنید.');
        return;
    }
    
    // For test payment, submit the form directly
    // For other payment methods, you would redirect to payment gateway here
});
</script>
@endsection
