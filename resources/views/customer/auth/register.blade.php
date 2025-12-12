@extends('layouts.app')

@section('title', 'Customer Registration - ' . config('app.name'))

@section('content')
@php
    $direction = config('ui.direction', 'ltr');
    $language = config('ui.language', 'en');
    $isRtl = $direction === 'rtl';
@endphp

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                {{ __('Create Customer Account') }}
            </h2>
            <p class="text-sm text-gray-500">
                {{ __('Register to access your cloud resources') }}
            </p>
        </div>

        <form class="mt-8 space-y-5" action="{{ route('customer.register') }}" method="POST" id="registrationForm">
                @csrf
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('First Name') }}</label>
                        <input id="first_name" 
                               name="first_name" 
                               type="text" 
                               required 
                               class="w-full px-4 py-3.5 border border-gray-300 bg-gray-50 rounded-lg text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-600 transition-all @error('first_name') border-red-400 bg-red-50 @enderror" 
                               placeholder="{{ __('First Name') }}"
                               value="{{ old('first_name') }}">
                        @error('first_name')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Last Name') }}</label>
                        <input id="last_name" 
                               name="last_name" 
                               type="text" 
                               required 
                               class="w-full px-4 py-3.5 border border-gray-300 bg-gray-50 rounded-lg text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-600 transition-all @error('last_name') border-red-400 bg-red-50 @enderror" 
                               placeholder="{{ __('Last Name') }}"
                               value="{{ old('last_name') }}">
                        @error('last_name')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Phone Number') }} *</label>
                    <div class="flex rounded-lg border border-gray-300 bg-gray-50 focus-within:border-blue-600 focus-within:bg-white focus-within:ring-1 focus-within:ring-blue-600 transition-all @error('phone_number') border-red-400 bg-red-50 @enderror">
                        <select id="country_code" 
                                name="country_code" 
                                class="px-4 py-3.5 bg-transparent border-0 border-r border-gray-300 rounded-l-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-0 @error('phone_number') border-red-400 @enderror"
                                style="min-width: 100px;">
                            <option value="+98" selected>🇮🇷 +98</option>
                        </select>
                        <input id="phone_number" 
                               name="phone_number" 
                               type="tel" 
                               required 
                               class="flex-1 px-4 py-3.5 bg-transparent border-0 rounded-r-lg text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 @error('phone_number') text-red-600 @enderror" 
                               placeholder="912 345 6789"
                               value="{{ old('phone_number') }}"
                               maxlength="11">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">{{ __('This will be used for SMS verification and login') }}</p>
                    @error('phone_number')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    <p id="phoneError" class="mt-2 text-sm text-red-600 font-medium hidden"></p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Email Address') }} <span class="text-gray-400 font-normal">({{ __('Optional') }})</span></label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           class="w-full px-4 py-3.5 border border-gray-300 bg-gray-50 rounded-lg text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-600 transition-all @error('email') border-red-400 bg-red-50 @enderror" 
                           placeholder="{{ __('Email Address') }}"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Company Name') }} <span class="text-gray-400 font-normal">({{ __('Optional') }})</span></label>
                    <input id="company_name" 
                           name="company_name" 
                           type="text" 
                           class="w-full px-4 py-3.5 border border-gray-300 bg-gray-50 rounded-lg text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-600 transition-all @error('company_name') border-red-400 bg-red-50 @enderror" 
                           placeholder="{{ __('Company Name') }}"
                           value="{{ old('company_name') }}">
                    @error('company_name')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" 
                            class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent text-base font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="submitBtn">
                        <span id="submitText">{{ __('Create Account') }}</span>
                        <svg class="animate-spin ml-3 h-5 w-5 text-white hidden" id="loadingSpinner" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>

                <div class="text-center pt-2">
                    <p class="text-sm text-gray-600">
                        {{ __('Already have an account?') }}
                        <a href="{{ route('customer.login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                            {{ __('Sign in here') }}
                        </a>
                    </p>
                </div>
            </form>

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

@push('scripts')
<script>
// Iran phone number validation
function validateIranPhoneNumber(phone) {
    // Remove all non-digit characters
    const digits = phone.replace(/\D/g, '');
    
    // Iran mobile numbers: 09XX XXX XXXX (11 digits starting with 09)
    // Or 9XX XXX XXXX (10 digits starting with 9, we'll add 0)
    if (digits.length === 11 && digits.startsWith('09')) {
        return true;
    }
    if (digits.length === 10 && digits.startsWith('9')) {
        return true;
    }
    return false;
}

// Format phone input
const phoneInput = document.getElementById('phone_number');
phoneInput.addEventListener('input', function(e) {
    // Only allow digits
    this.value = this.value.replace(/\D/g, '');
    
    // Auto-add leading 0 if user starts with 9
    if (this.value.length === 1 && this.value === '9') {
        this.value = '09' + this.value;
    }
    
    // Limit to 11 digits
    if (this.value.length > 11) {
        this.value = this.value.substring(0, 11);
    }
    
    // Validate and show error
    const phoneError = document.getElementById('phoneError');
    if (this.value.length > 0 && !validateIranPhoneNumber(this.value)) {
        phoneError.textContent = '{{ __("Please enter a valid Iran mobile number (09XX XXX XXXX)") }}';
        phoneError.classList.remove('hidden');
    } else {
        phoneError.classList.add('hidden');
    }
});

document.getElementById('registrationForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const countryCode = document.getElementById('country_code').value;
    const phoneNumber = document.getElementById('phone_number').value;
    const phoneError = document.getElementById('phoneError');
    
    // Validate phone number
    if (!validateIranPhoneNumber(phoneNumber)) {
        e.preventDefault();
        phoneError.textContent = '{{ __("Please enter a valid Iran mobile number (09XX XXX XXXX)") }}';
        phoneError.classList.remove('hidden');
        return false;
    }
    
    // Combine country code and phone number
    const fullPhoneNumber = countryCode + phoneNumber.replace(/^0/, '');
    
    // Update the phone number input with the full number
    document.getElementById('phone_number').value = fullPhoneNumber;
    
    submitBtn.disabled = true;
    submitText.textContent = '{{ __("Creating Account...") }}';
    loadingSpinner.classList.remove('hidden');
});
</script>
@endpush
@endsection
