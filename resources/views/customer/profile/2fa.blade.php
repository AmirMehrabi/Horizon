@extends('layouts.customer')

@section('title', 'فعال‌سازی احراز هویت دو مرحله‌ای')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <a href="{{ route('customer.profile.index') }}" class="text-blue-600 hover:text-blue-700 text-sm mb-2 inline-block">
        ← بازگشت به پروفایل
    </a>
    <h1 class="text-3xl font-bold text-gray-900">فعال‌سازی احراز هویت دو مرحله‌ای</h1>
    <p class="mt-1 text-sm text-gray-500">افزایش امنیت حساب کاربری با احراز هویت دو مرحله‌ای</p>
</div>

<div class="max-w-2xl">
    <!-- Step 1: Scan QR Code -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">1</div>
            <h2 class="text-lg font-semibold text-gray-900">نصب اپلیکیشن احراز هویت</h2>
        </div>
        <p class="text-sm text-gray-600 mb-4">
            یکی از اپلیکیشن‌های زیر را روی گوشی خود نصب کنید:
        </p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="text-center p-3 border border-gray-200 rounded-lg">
                <p class="text-sm font-medium text-gray-900">Google Authenticator</p>
            </div>
            <div class="text-center p-3 border border-gray-200 rounded-lg">
                <p class="text-sm font-medium text-gray-900">Microsoft Authenticator</p>
            </div>
            <div class="text-center p-3 border border-gray-200 rounded-lg">
                <p class="text-sm font-medium text-gray-900">Authy</p>
            </div>
            <div class="text-center p-3 border border-gray-200 rounded-lg">
                <p class="text-sm font-medium text-gray-900">1Password</p>
            </div>
        </div>
    </div>

    <!-- Step 2: Scan QR Code -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">2</div>
            <h2 class="text-lg font-semibold text-gray-900">اسکن QR کد</h2>
        </div>
        <p class="text-sm text-gray-600 mb-4">
            QR کد زیر را با اپلیکیشن احراز هویت خود اسکن کنید:
        </p>
        <div class="flex flex-col items-center">
            <div class="bg-white p-4 border-2 border-gray-200 rounded-lg mb-4">
                <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-48 h-48">
            </div>
            <p class="text-xs text-gray-500 mb-4">یا کد زیر را به صورت دستی وارد کنید:</p>
            <div class="bg-gray-50 rounded-lg p-4 font-mono text-sm text-center">
                <span id="secret-code" class="text-gray-900">{{ $secret }}</span>
                <button onclick="copySecret()" class="ml-2 text-blue-600 hover:text-blue-700 text-xs">
                    کپی
                </button>
            </div>
        </div>
    </div>

    <!-- Step 3: Verify Code -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">3</div>
            <h2 class="text-lg font-semibold text-gray-900">تایید کد</h2>
        </div>
        <p class="text-sm text-gray-600 mb-4">
            کد ۶ رقمی نمایش داده شده در اپلیکیشن را وارد کنید:
        </p>
        
        <form method="POST" action="{{ route('customer.profile.2fa.enable') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="secret" value="{{ $secret }}">
            
            <div>
                <label for="verification_code" class="block text-sm font-medium text-gray-700 mb-2">کد تایید</label>
                <input 
                    type="text" 
                    id="verification_code" 
                    name="verification_code" 
                    maxlength="6" 
                    pattern="[0-9]{6}"
                    class="w-full max-w-xs mx-auto block text-center text-2xl font-mono border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="000000"
                    required
                    autocomplete="off"
                >
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('customer.profile.index') }}" class="flex-1 px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors text-center">
                    انصراف
                </a>
                <button type="submit" class="flex-1 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    فعال‌سازی
                </button>
            </div>
        </form>
    </div>

    <!-- Recovery Codes Info -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <p class="text-sm font-medium text-yellow-900">کدهای بازیابی</p>
                <p class="text-xs text-yellow-700 mt-1">
                    پس از فعال‌سازی، کدهای بازیابی به شما نمایش داده می‌شوند. این کدها را در جای امنی نگهداری کنید.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function copySecret() {
    const secret = document.getElementById('secret-code').textContent.trim();
    navigator.clipboard.writeText(secret).then(() => {
        alert('کد کپی شد');
    });
}

// Auto-focus and format verification code input
document.getElementById('verification_code')?.addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
    if (this.value.length === 6) {
        // Auto-submit can be enabled here if desired
    }
});
</script>
@endsection


