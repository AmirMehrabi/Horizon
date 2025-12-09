@extends('layouts.app')

@section('title', 'Choose Portal - ' . config('app.name'))

@section('content')
@php
    $direction = config('ui.direction', 'ltr');
    $language = config('ui.language', 'en');
    $isRtl = $direction === 'rtl';
@endphp

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                {{ __('Choose Your Portal') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Select the appropriate portal to access your account') }}
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mt-12">
            <!-- Admin Portal -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="px-6 py-8">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-blue-100 rounded-full mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 text-center mb-4">
                        {{ __('Admin Portal') }}
                    </h3>
                    
                    <p class="text-gray-600 text-center mb-6">
                        {{ __('Access the administrative dashboard to manage users, customers, and system settings.') }}
                    </p>
                    
                    <ul class="space-y-2 mb-8">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('User management') }}
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Customer oversight') }}
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('System analytics') }}
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Configuration management') }}
                        </li>
                    </ul>
                    
                    <a href="https://hub.aviato.ir/login" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md text-center block transition-colors duration-200">
                        {{ __('Access Admin Portal') }}
                    </a>
                </div>
            </div>

            <!-- Customer Portal -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="px-6 py-8">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 text-center mb-4">
                        {{ __('Customer Portal') }}
                    </h3>
                    
                    <p class="text-gray-600 text-center mb-6">
                        {{ __('Manage your cloud resources, monitor performance, and access billing information.') }}
                    </p>
                    
                    <ul class="space-y-2 mb-8">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Resource management') }}
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Performance monitoring') }}
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Billing & usage') }}
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('Support access') }}
                        </li>
                    </ul>
                    
                    <div class="space-y-3">
                        <a href="https://panel.aviato.ir/login" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md text-center block transition-colors duration-200">
                            {{ __('Sign In') }}
                        </a>
                        <a href="https://panel.aviato.ir/register" 
                           class="w-full bg-white hover:bg-gray-50 text-green-600 font-medium py-3 px-4 rounded-md text-center block border border-green-600 transition-colors duration-200">
                            {{ __('Create Account') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('landing') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                ← {{ __('Back to home') }}
            </a>
        </div>

        <!-- Info Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-8">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                    <h3 class="text-sm font-medium text-gray-900">
                        {{ __('Need Help?') }}
                    </h3>
                    <div class="mt-2 text-sm text-gray-600">
                        <p>{{ __('If you\'re unsure which portal to use:') }}</p>
                        <ul class="mt-2 {{ $isRtl ? 'pr-5' : 'pl-5' }} space-y-1 list-disc">
                            <li>{{ __('Choose Admin Portal if you\'re a system administrator') }}</li>
                            <li>{{ __('Choose Customer Portal if you\'re managing your own cloud resources') }}</li>
                            <li>{{ __('New users should create a Customer Account to get started') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
