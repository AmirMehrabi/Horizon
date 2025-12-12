@extends('layouts.app')

@section('title', 'Customer Login - ' . config('app.name'))

@section('content')
@php
    $direction = config('ui.direction', 'ltr');
    $language = config('ui.language', 'en');
    $isRtl = $direction === 'rtl';
@endphp

<div class="min-h-screen flex flex-col bg-[#faf9f5]">
    <!-- Logo Placeholder -->
    <div class="w-full py-6 px-4 text-center">
        <h1 class="text-4xl sm:text-5xl font-black text-black">آویاتو</h1>
    </div>
    
    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="text-xl font-bold text-gray-900 mb-2">
                    شماره موبایل خود را وارد کنید
                </h2>
                <p class=" text-gray-500">
                    تا کد تائید به شماره‌تان ارسال شود
                </p>
            </div>

            <!-- Phone Number Form -->
            <div id="phoneForm">
                <form class="space-y-6" action="{{ route('customer.login') }}" method="POST" id="loginForm">
                    @csrf
                    
                    <div>
                        <div class="flex {{ $isRtl ? 'flex-row-reverse' : '' }} rounded-lg border border-gray-300 bg-white hover:border-gray-400 focus-within:ring-2 focus-within:ring-blue-500/20 transition-all @error('phone_number') border-red-400 bg-red-50 @enderror">
                            <select id="country_code" 
                                    name="country_code" 
                                    class="px-4 py-3 bg-transparent border-0 {{ $isRtl ? 'border-gray-300 rounded-r-lg' : 'border-r border-gray-300 rounded-l-lg' }} text-sm font-medium text-gray-700 focus:outline-none focus:ring-0 @error('phone_number') border-red-400 @enderror"
                                    style="min-width: 100px;">
                                <option value="+98" selected>🇮🇷 +98</option>
                            </select>
                            <input id="phone_number" 
                                   name="phone_number" 
                                   type="tel" 
                                   required 
                                   class="flex-1 px-4 py-3 bg-transparent border-0 {{ $isRtl ? 'rounded-l-lg' : 'rounded-r-lg' }} text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 @error('phone_number') text-red-600 @enderror" 
                                   placeholder="912 345 6789"
                                   value="{{ old('phone_number') }}"
                                   maxlength="11">
                        </div>
                        @error('phone_number')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                        <p id="phoneError" class="mt-2 text-sm text-red-600 font-medium hidden"></p>
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent text-base font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                id="submitBtn">
                            <span id="submitText">{{ __('Send Verification Code') }}</span>
                            <svg class="animate-spin ml-3 h-5 w-5 text-white hidden" id="loadingSpinner" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="text-center pt-2">
                        <p class="text-sm text-gray-600">
                            {{ __("Don't have an account?") }}
                            <a href="{{ route('customer.register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                                {{ __('Register here') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>

        <!-- Verification Code Form (Hidden initially) -->
        <div id="verificationForm" class="hidden">
            <form class="mt-8 space-y-6" action="{{ route('customer.verify-login') }}" method="POST" id="verifyForm">
                @csrf
                
                <div class="text-center mb-6">
                    <p class="text-sm text-gray-600 mb-2">
                        {{ __('We sent a verification code to') }}
                    </p>
                    <span class="text-base font-semibold text-gray-900" id="displayPhone"></span>
                </div>

                <div>
                    <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Verification Code') }}</label>
                    <input id="code" 
                           name="code" 
                           type="text" 
                           maxlength="6"
                           pattern="[0-9]{6}"
                           required 
                           class="w-full px-4 py-3 border border-gray-300 bg-white rounded-lg text-center text-2xl tracking-[0.5em] font-semibold text-gray-900 placeholder-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all" 
                           placeholder="000000"
                           autocomplete="one-time-code">
                    <div id="codeError" class="mt-2 text-sm text-red-600 font-medium hidden"></div>
                </div>

                <div>
                    <button type="submit" 
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent text-base font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="verifyBtn">
                        <span id="verifyText">{{ __('Verify & Sign In') }}</span>
                        <svg class="animate-spin ml-3 h-5 w-5 text-white hidden" id="verifySpinner" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>

                    <div class="text-center space-y-3">
                        <button type="button" 
                                id="resendBtn"
                                class="text-sm font-semibold text-blue-600 hover:text-blue-700 disabled:text-gray-400 disabled:cursor-not-allowed transition-colors">
                            <span id="resendText">{{ __('Resend Code') }}</span>
                            <span id="resendTimer" class="hidden"></span>
                        </button>
                        <div>
                            <button type="button" 
                                    id="backToPhone"
                                    class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                                ← {{ __('Use different phone number') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 border border-green-200 p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
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
            <div class="rounded-lg bg-red-50 border border-red-200 p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
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
</div>

@push('scripts')
<script>
let resendTimer = 60;
let resendInterval;

// Iran phone number validation with Farsi error messages
function validateIranPhoneNumber(phone) {
    const digits = phone.replace(/\D/g, '');
    
    // Empty
    if (digits.length === 0) {
        return { valid: false, message: 'شماره موبایل را وارد کنید' };
    }
    
    // Must start with 09 or 9
    if (!digits.startsWith('09') && !digits.startsWith('9')) {
        return { valid: false, message: 'شماره موبایل باید با 09 یا 9 شروع شود' };
    }
    
    // If starts with 9, should be 10 digits total
    if (digits.startsWith('9') && digits.length !== 10) {
        if (digits.length < 10) {
            return { valid: false, message: 'شماره موبایل باید 10 رقم باشد (شروع با 9)' };
        }
        return { valid: false, message: 'شماره موبایل نباید بیشتر از 10 رقم باشد' };
    }
    
    // If starts with 09, should be 11 digits total
    if (digits.startsWith('09') && digits.length !== 11) {
        if (digits.length < 11) {
            return { valid: false, message: 'شماره موبایل باید 11 رقم باشد (شروع با 09)' };
        }
        return { valid: false, message: 'شماره موبایل نباید بیشتر از 11 رقم باشد' };
    }
    
    // Valid
    return { valid: true, message: '' };
}

// Format phone number for display
function formatIranPhoneNumber(phone) {
    const digits = phone.replace(/\D/g, '');
    if (digits.length === 11 && digits.startsWith('09')) {
        return `+98 ${digits.substring(1, 4)} ${digits.substring(4, 7)} ${digits.substring(7)}`;
    }
    if (digits.length === 10 && digits.startsWith('9')) {
        return `+98 ${digits.substring(0, 3)} ${digits.substring(3, 6)} ${digits.substring(6)}`;
    }
    return phone;
}

// Phone input handling
const phoneInput = document.getElementById('phone_number');
const phoneError = document.getElementById('phoneError');
let hasInteracted = false;

// Only allow digits
phoneInput.addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '');
    
    // Limit to 11 digits max
    if (this.value.length > 11) {
        this.value = this.value.substring(0, 11);
    }
    
    // Only validate if user has started typing and is clearly wrong
    const digits = this.value.replace(/\D/g, '');
    if (hasInteracted && digits.length > 0) {
        // Check if they're on wrong path (not starting with 09 or 9)
        if (!digits.startsWith('09') && !digits.startsWith('9')) {
            const validation = validateIranPhoneNumber(this.value);
            if (!validation.valid) {
                phoneError.textContent = validation.message;
                phoneError.classList.remove('hidden');
            } else {
                phoneError.classList.add('hidden');
            }
        } else {
            // Hide error if they're on right path
            phoneError.classList.add('hidden');
        }
    }
});

// Validate on blur (when user is done typing)
phoneInput.addEventListener('blur', function() {
    hasInteracted = true;
    const validation = validateIranPhoneNumber(this.value);
    if (!validation.valid) {
        phoneError.textContent = validation.message;
        phoneError.classList.remove('hidden');
    } else {
        phoneError.classList.add('hidden');
    }
});

// Mark as interacted on focus
phoneInput.addEventListener('focus', function() {
    hasInteracted = true;
});

// Handle phone form submission
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const countryCode = document.getElementById('country_code').value;
    const phoneNumber = document.getElementById('phone_number').value;
    const phoneError = document.getElementById('phoneError');
    
    // Validate phone number
    const validation = validateIranPhoneNumber(phoneNumber);
    if (!validation.valid) {
        phoneError.textContent = validation.message;
        phoneError.classList.remove('hidden');
        e.preventDefault();
        return false;
    }
    
    // Combine country code and phone number
    // Remove leading 0 if starts with 09, otherwise use as is (starts with 9)
    const digits = phoneNumber.replace(/\D/g, '');
    const fullPhoneNumber = countryCode + (digits.startsWith('09') ? digits.substring(1) : digits);
    
    submitBtn.disabled = true;
    submitText.textContent = '{{ __("Sending Code...") }}';
    loadingSpinner.classList.remove('hidden');
    phoneError.classList.add('hidden');
    
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                phone_number: fullPhoneNumber
            })
        });
        
        const data = await response.json();
        
        if (data.success && data.show_verification) {
            // Show verification form
            document.getElementById('phoneForm').classList.add('hidden');
            document.getElementById('verificationForm').classList.remove('hidden');
            document.getElementById('displayPhone').textContent = formatIranPhoneNumber(phoneNumber);
            document.getElementById('code').focus();
            startResendTimer();
        } else {
            // Show error
            phoneError.textContent = data.message || '{{ __("An error occurred. Please try again.") }}';
            phoneError.classList.remove('hidden');
        }
    } catch (error) {
        phoneError.textContent = '{{ __("Network error. Please try again.") }}';
        phoneError.classList.remove('hidden');
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
