@extends('layouts.app')

@section('title', 'Customer Registration - ' . config('app.name'))

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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ __('Create Customer Account') }}
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{ __('Register to access your cloud resources') }}
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('customer.register') }}" method="POST" id="registrationForm">
            @csrf
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">{{ __('First Name') }}</label>
                        <input id="first_name" 
                               name="first_name" 
                               type="text" 
                               required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('first_name') border-red-300 @enderror" 
                               placeholder="{{ __('First Name') }}"
                               value="{{ old('first_name') }}">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">{{ __('Last Name') }}</label>
                        <input id="last_name" 
                               name="last_name" 
                               type="text" 
                               required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('last_name') border-red-300 @enderror" 
                               placeholder="{{ __('Last Name') }}"
                               value="{{ old('last_name') }}">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">{{ __('Phone Number') }} *</label>
                    <input id="phone_number" 
                           name="phone_number" 
                           type="tel" 
                           required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('phone_number') border-red-300 @enderror" 
                           placeholder="{{ __('Phone Number (e.g., +1234567890)') }}"
                           value="{{ old('phone_number') }}">
                    <p class="mt-1 text-xs text-gray-500">{{ __('This will be used for SMS verification and login') }}</p>
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }} ({{ __('Optional') }})</label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-300 @enderror" 
                           placeholder="{{ __('Email Address') }}"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">{{ __('Company Name') }} ({{ __('Optional') }})</label>
                    <input id="company_name" 
                           name="company_name" 
                           type="text" 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('company_name') border-red-300 @enderror" 
                           placeholder="{{ __('Company Name') }}"
                           value="{{ old('company_name') }}">
                    @error('company_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        id="submitBtn">
                    <span class="absolute {{ $isRtl ? 'right-0 pr-3' : 'left-0 pl-3' }} inset-y-0 flex items-center">
                        <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </span>
                    <span id="submitText">{{ __('Create Account') }}</span>
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" id="loadingSpinner" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>

            <div class="text-center space-y-2">
                <p class="text-sm text-gray-600">
                    {{ __('Already have an account?') }}
                    <a href="{{ route('customer.login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        {{ __('Sign in here') }}
                    </a>
                </p>
            </div>
        </form>

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
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    submitBtn.disabled = true;
    submitText.textContent = '{{ __("Creating Account...") }}';
    loadingSpinner.classList.remove('hidden');
});
</script>
@endpush
@endsection
