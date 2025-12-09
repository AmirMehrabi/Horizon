@extends('layouts.app')

@section('title', 'Verify Phone Number - ' . config('app.name'))

@section('content')
@php
    $direction = config('ui.direction', 'ltr');
    $language = config('ui.language', 'en');
    $isRtl = $direction === 'rtl';
@endphp

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-green-100">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ __('Verify Your Phone') }}
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{ __('We sent a verification code to') }}<br>
                <span class="font-medium">{{ $phoneNumber }}</span>
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('customer.verify') }}" method="POST" id="verificationForm">
            @csrf
            
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">{{ __('Verification Code') }}</label>
                <input id="code" 
                       name="code" 
                       type="text" 
                       maxlength="6"
                       pattern="[0-9]{6}"
                       required 
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-center text-lg tracking-widest @error('code') border-red-300 @enderror" 
                       placeholder="000000"
                       autocomplete="one-time-code"
                       autofocus>
                @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div id="codeError" class="mt-1 text-sm text-red-600 hidden"></div>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        id="verifyBtn">
                    <span class="absolute {{ $isRtl ? 'right-0 pr-3' : 'left-0 pl-3' }} inset-y-0 flex items-center">
                        <svg class="h-5 w-5 text-green-500 group-hover:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </span>
                    <span id="verifyText">{{ __('Verify & Complete Registration') }}</span>
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" id="verifySpinner" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>

            <div class="text-center">
                <button type="button" 
                        id="resendBtn"
                        class="text-sm text-blue-600 hover:text-blue-500 disabled:text-gray-400 disabled:cursor-not-allowed">
                    <span id="resendText">{{ __('Resend Code') }}</span>
                    <span id="resendTimer" class="hidden"></span>
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('customer.register') }}" class="text-sm text-gray-600 hover:text-gray-500">
                    ← {{ __('Back to registration') }}
                </a>
            </div>
        </form>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                    <h3 class="text-sm font-medium text-blue-800">
                        {{ __('Verification Code Info') }}
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc {{ $isRtl ? 'pr-5' : 'pl-5' }} space-y-1">
                            <li>{{ __('The code is valid for 15 minutes') }}</li>
                            <li>{{ __('You have 3 attempts to enter the correct code') }}</li>
                            <li>{{ __('Check your SMS messages for the 6-digit code') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
let resendTimer = 60;
let resendInterval;

// Start resend timer on page load
document.addEventListener('DOMContentLoaded', function() {
    startResendTimer();
});

// Handle verification form submission
document.getElementById('verificationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const verifyBtn = document.getElementById('verifyBtn');
    const verifyText = document.getElementById('verifyText');
    const verifySpinner = document.getElementById('verifySpinner');
    const code = document.getElementById('code').value;
    const codeError = document.getElementById('codeError');
    
    codeError.classList.add('hidden');
    verifyBtn.disabled = true;
    verifyText.textContent = '{{ __("Verifying...") }}';
    verifySpinner.classList.remove('hidden');
    
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                code: code
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            codeError.textContent = data.message;
            codeError.classList.remove('hidden');
            document.getElementById('code').focus();
        }
    } catch (error) {
        codeError.textContent = '{{ __("Network error. Please try again.") }}';
        codeError.classList.remove('hidden');
    } finally {
        verifyBtn.disabled = false;
        verifyText.textContent = '{{ __("Verify & Complete Registration") }}';
        verifySpinner.classList.add('hidden');
    }
});

// Handle resend code
document.getElementById('resendBtn').addEventListener('click', async function() {
    try {
        const response = await fetch('{{ route("customer.resend-code") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            startResendTimer();
            // Show success message
            const successDiv = document.createElement('div');
            successDiv.className = 'rounded-md bg-green-50 p-4 mb-4';
            successDiv.innerHTML = `
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                        <p class="text-sm font-medium text-green-800">${data.message}</p>
                    </div>
                </div>
            `;
            document.querySelector('form').parentNode.insertBefore(successDiv, document.querySelector('form'));
            setTimeout(() => successDiv.remove(), 5000);
        } else {
            alert(data.message || '{{ __("Failed to resend code. Please try again.") }}');
        }
    } catch (error) {
        alert('{{ __("Network error. Please try again.") }}');
    }
});

// Resend timer
function startResendTimer() {
    resendTimer = 60;
    const resendBtn = document.getElementById('resendBtn');
    const resendText = document.getElementById('resendText');
    const resendTimerSpan = document.getElementById('resendTimer');
    
    resendBtn.disabled = true;
    resendText.classList.add('hidden');
    resendTimerSpan.classList.remove('hidden');
    
    resendInterval = setInterval(() => {
        resendTimer--;
        resendTimerSpan.textContent = `{{ __("Resend in") }} ${resendTimer}s`;
        
        if (resendTimer <= 0) {
            clearInterval(resendInterval);
            resendBtn.disabled = false;
            resendText.classList.remove('hidden');
            resendTimerSpan.classList.add('hidden');
        }
    }, 1000);
}

// Auto-format code input
document.getElementById('code').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endpush
@endsection
