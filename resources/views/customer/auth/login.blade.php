@extends('layouts.app')

@section('title', 'Customer Login - ' . config('app.name'))

@section('content')
@php
    $direction = config('ui.direction', 'ltr');
    $language = config('ui.language', 'en');
    $isRtl = $direction === 'rtl';
@endphp

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-100">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ __('Customer Portal') }}
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{ __('Sign in with your phone number') }}
            </p>
        </div>

        <!-- Phone Number Form -->
        <div id="phoneForm">
            <form class="mt-8 space-y-6" action="{{ route('customer.login') }}" method="POST" id="loginForm">
                @csrf
                
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">{{ __('Phone Number') }}</label>
                    <input id="phone_number" 
                           name="phone_number" 
                           type="tel" 
                           required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('phone_number') border-red-300 @enderror" 
                           placeholder="{{ __('Phone Number (e.g., +1234567890)') }}"
                           value="{{ old('phone_number') }}">
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="submitBtn">
                        <span class="absolute {{ $isRtl ? 'right-0 pr-3' : 'left-0 pl-3' }} inset-y-0 flex items-center">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </span>
                        <span id="submitText">{{ __('Send Verification Code') }}</span>
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" id="loadingSpinner" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>

                <div class="text-center space-y-2">
                    <p class="text-sm text-gray-600">
                        {{ __("Don't have an account?") }}
                        <a href="{{ route('customer.register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            {{ __('Register here') }}
                        </a>
                    </p>
                    <a href="{{ url('/') }}" class="text-sm text-blue-600 hover:text-blue-500">
                        ← {{ __('Back to main site') }}
                    </a>
                </div>
            </form>
        </div>

        <!-- Verification Code Form (Hidden initially) -->
        <div id="verificationForm" class="hidden">
            <form class="mt-8 space-y-6" action="{{ route('customer.verify-login') }}" method="POST" id="verifyForm">
                @csrf
                
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-4">
                        {{ __('We sent a verification code to') }}<br>
                        <span class="font-medium" id="displayPhone"></span>
                    </p>
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">{{ __('Verification Code') }}</label>
                    <input id="code" 
                           name="code" 
                           type="text" 
                           maxlength="6"
                           pattern="[0-9]{6}"
                           required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-center text-lg tracking-widest" 
                           placeholder="000000"
                           autocomplete="one-time-code">
                    <div id="codeError" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="verifyBtn">
                        <span id="verifyText">{{ __('Verify & Sign In') }}</span>
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
                    <button type="button" 
                            id="backToPhone"
                            class="text-sm text-gray-600 hover:text-gray-500">
                        ← {{ __('Use different phone number') }}
                    </button>
                </div>
            </form>
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

// Handle phone form submission
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const phoneNumber = document.getElementById('phone_number').value;
    
    submitBtn.disabled = true;
    submitText.textContent = '{{ __("Sending Code...") }}';
    loadingSpinner.classList.remove('hidden');
    
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                phone_number: phoneNumber
            })
        });
        
        const data = await response.json();
        
        if (data.success && data.show_verification) {
            // Show verification form
            document.getElementById('phoneForm').classList.add('hidden');
            document.getElementById('verificationForm').classList.remove('hidden');
            document.getElementById('displayPhone').textContent = phoneNumber;
            document.getElementById('code').focus();
            startResendTimer();
        } else {
            // Show error
            alert(data.message || '{{ __("An error occurred. Please try again.") }}');
        }
    } catch (error) {
        alert('{{ __("Network error. Please try again.") }}');
    } finally {
        submitBtn.disabled = false;
        submitText.textContent = '{{ __("Send Verification Code") }}';
        loadingSpinner.classList.add('hidden');
    }
});

// Handle verification form submission
document.getElementById('verifyForm').addEventListener('submit', async function(e) {
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
        verifyText.textContent = '{{ __("Verify & Sign In") }}';
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
            alert(data.message);
        } else {
            alert(data.message || '{{ __("Failed to resend code. Please try again.") }}');
        }
    } catch (error) {
        alert('{{ __("Network error. Please try again.") }}');
    }
});

// Handle back to phone
document.getElementById('backToPhone').addEventListener('click', function() {
    document.getElementById('verificationForm').classList.add('hidden');
    document.getElementById('phoneForm').classList.remove('hidden');
    document.getElementById('phone_number').focus();
    clearInterval(resendInterval);
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
