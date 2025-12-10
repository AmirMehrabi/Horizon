@extends('layouts.customer')

@section('title', 'ایجاد سرور جدید')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('header_content')
    <nav class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}" aria-label="Breadcrumb">
        <!-- Dashboard -->
        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-all duration-200 group">
            <svg class="w-4 h-4 {{ $isRtl ? 'ml-1.5' : 'mr-1.5' }} text-gray-500 group-hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>داشبورد</span>
        </a>
        
        <!-- Arrow -->
        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $isRtl ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7' }}"></path>
        </svg>
        
        <!-- Servers -->
        <a href="{{ route('customer.servers.index') }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-all duration-200 group">
            <svg class="w-4 h-4 {{ $isRtl ? 'ml-1.5' : 'mr-1.5' }} text-gray-500 group-hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
            </svg>
            <span>سرورها</span>
        </a>
        
        <!-- Arrow -->
        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $isRtl ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7' }}"></path>
        </svg>
        
        <!-- Add Server (Current Page) -->
        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium text-gray-900 bg-gray-50">
            <span>افزودن سرور</span>
        </span>
    </nav>
@endsection

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">ایجاد سرور جدید</h1>
        <p class="mt-1 text-sm text-gray-500">راهنمای گام به گام برای راه‌اندازی سرور مجازی</p>
    </div>

    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <!-- Step 1 -->
            <div class="flex items-center flex-1">
                <div class="flex flex-col items-center flex-1">
                    <div id="step-1-indicator" class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold mb-2">
                        ۱
                    </div>
                    <span class="text-sm font-medium text-gray-900">انتخاب سیستم عامل</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2 {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                    <div id="step-1-progress" class="h-1 bg-blue-600 transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="flex items-center flex-1">
                <div class="flex flex-col items-center flex-1">
                    <div id="step-2-indicator" class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold mb-2">
                        ۲
                    </div>
                    <span class="text-sm font-medium text-gray-600">انتخاب پلن</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2 {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                    <div id="step-2-progress" class="h-1 bg-gray-200 transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="flex items-center flex-1">
                <div class="flex flex-col items-center flex-1">
                    <div id="step-3-indicator" class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold mb-2">
                        ۳
                    </div>
                    <span class="text-sm font-medium text-gray-600">تنظیمات شبکه</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2 {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                    <div id="step-3-progress" class="h-1 bg-gray-200 transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="flex items-center">
                <div class="flex flex-col items-center">
                    <div id="step-4-indicator" class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold mb-2">
                        ۴
                    </div>
                    <span class="text-sm font-medium text-gray-600">دسترسی و راه‌اندازی</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Wizard Form -->
    <form id="vps-wizard-form" action="{{ route('customer.servers.store') }}" method="POST">
        @csrf
        
        <!-- Step 1: Choose OS -->
        <div id="step-1-content" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">انتخاب سیستم عامل</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <!-- Ubuntu -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="os" value="ubuntu" class="peer hidden" required>
                    <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-900">Ubuntu</h3>
                            <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">Ubuntu 22.04 LTS</p>
                    </div>
                </label>

                <!-- Debian -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="os" value="debian" class="peer hidden">
                    <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-900">Debian</h3>
                            <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">Debian 12</p>
                    </div>
                </label>

                <!-- CentOS -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="os" value="centos" class="peer hidden">
                    <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-900">CentOS</h3>
                            <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">CentOS Stream 9</p>
                    </div>
                </label>

                <!-- AlmaLinux -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="os" value="almalinux" class="peer hidden">
                    <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-900">AlmaLinux</h3>
                            <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">AlmaLinux 9</p>
                    </div>
                </label>

                <!-- Windows -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="os" value="windows" class="peer hidden">
                    <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-900">Windows</h3>
                            <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">Windows Server 2022</p>
                    </div>
                </label>

                <!-- Custom ISO -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="os" value="custom" class="peer hidden">
                    <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-gray-900">ISO سفارشی</h3>
                            <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">آپلود ISO شخصی</p>
                    </div>
                </label>
            </div>

            <!-- Custom ISO Upload -->
            <div id="custom-iso-upload" class="hidden mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">آپلود فایل ISO</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="iso-file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>انتخاب فایل</span>
                                <input id="iso-file" name="iso_file" type="file" class="sr-only" accept=".iso">
                            </label>
                            <p class="pr-1">یا فایل را اینجا بکشید</p>
                        </div>
                        <p class="text-xs text-gray-500">ISO تا 4GB</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="nextStep(2)" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                    بعدی →
                </button>
            </div>
        </div>

        <!-- Step 2: Select Plan -->
        <div id="step-2-content" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hidden">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">انتخاب پلن</h2>
            
            <!-- Plan Type Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">نوع پلن</label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="radio" name="plan_type" value="prebuilt" class="mr-2" checked onchange="togglePlanType()">
                        <span class="text-sm text-gray-700">پلن‌های از پیش تعریف شده</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="plan_type" value="custom" class="mr-2" onchange="togglePlanType()">
                        <span class="text-sm text-gray-700">سفارشی</span>
                    </label>
                </div>
            </div>

            <!-- Prebuilt Plans -->
            <div id="prebuilt-plans" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Starter Plan -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="plan" value="starter" class="peer hidden">
                    <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Starter</h3>
                            <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <p>۱ vCPU</p>
                            <p>۲GB RAM</p>
                            <p>۲۰GB Storage</p>
                            <p>۱TB Bandwidth</p>
                        </div>
                        <p class="text-xl font-bold text-gray-900">۱۵۰,۰۰۰ تومان/ماه</p>
                    </div>
                </label>

                <!-- Standard Plan -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="plan" value="standard" class="peer hidden">
                    <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Standard</h3>
                            <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <p>۲ vCPU</p>
                            <p>۴GB RAM</p>
                            <p>۴۰GB Storage</p>
                            <p>۲TB Bandwidth</p>
                        </div>
                        <p class="text-xl font-bold text-gray-900">۳۰۰,۰۰۰ تومان/ماه</p>
                    </div>
                </label>

                <!-- Pro Plan -->
                <label class="relative cursor-pointer">
                    <input type="radio" name="plan" value="pro" class="peer hidden">
                    <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Pro</h3>
                            <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <p>۴ vCPU</p>
                            <p>۸GB RAM</p>
                            <p>۸۰GB Storage</p>
                            <p>۴TB Bandwidth</p>
                        </div>
                        <p class="text-xl font-bold text-gray-900">۶۰۰,۰۰۰ تومان/ماه</p>
                    </div>
                </label>
            </div>

            <!-- Custom Plan -->
            <div id="custom-plan" class="hidden mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تعداد vCPU</label>
                        <input type="number" name="custom_vcpu" min="1" max="32" value="1" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">RAM (GB)</label>
                        <input type="number" name="custom_ram" min="1" max="128" value="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">فضای ذخیره‌سازی (GB)</label>
                        <input type="number" name="custom_storage" min="20" max="1000" value="20" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">پهنای باند (TB)</label>
                        <input type="number" name="custom_bandwidth" min="1" max="10" step="0.5" value="1" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-700">
                        <span class="font-medium">قیمت تخمینی:</span>
                        <span id="custom-price" class="text-lg font-bold text-blue-600">۱۵۰,۰۰۰ تومان/ماه</span>
                    </p>
                </div>
            </div>

            <div class="flex justify-between">
                <button type="button" onclick="prevStep(1)" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-6 rounded-lg transition-colors">
                    ← قبلی
                </button>
                <button type="button" onclick="nextStep(3)" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                    بعدی →
                </button>
            </div>
        </div>

        <!-- Step 3: Network -->
        <div id="step-3-content" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hidden">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">تنظیمات شبکه</h2>
            
            <div class="space-y-6">
                <!-- Private Network -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="create_private_network" value="1" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="mr-2 text-sm font-medium text-gray-700">ایجاد شبکه خصوصی خودکار</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 mr-6">یک شبکه خصوصی برای ارتباط بین سرورهای شما ایجاد می‌شود</p>
                </div>

                <!-- Public IP -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="assign_public_ip" value="1" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="mr-2 text-sm font-medium text-gray-700">اختصاص IP عمومی</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 mr-6">سرور شما یک آدرس IP عمومی دریافت می‌کند</p>
                </div>

                <!-- Security Groups -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">گروه‌های امنیتی</label>
                    <select name="security_groups[]" multiple class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" size="4">
                        <option value="default">پیش‌فرض (SSH, HTTP, HTTPS)</option>
                        <option value="web">وب سرور (HTTP, HTTPS, SSH)</option>
                        <option value="database">پایگاه داده (MySQL, PostgreSQL)</option>
                        <option value="custom">سفارشی</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">برای انتخاب چند مورد، کلید Ctrl را نگه دارید</p>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <button type="button" onclick="prevStep(2)" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-6 rounded-lg transition-colors">
                    ← قبلی
                </button>
                <button type="button" onclick="nextStep(4)" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                    بعدی →
                </button>
            </div>
        </div>

        <!-- Step 4: Access -->
        <div id="step-4-content" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hidden">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">دسترسی و راه‌اندازی</h2>
            
            <div class="space-y-6">
                <!-- Access Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">روش دسترسی</label>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="radio" name="access_method" value="ssh_key" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked onchange="toggleAccessMethod()">
                            <span class="mr-2 text-sm text-gray-700">کلید SSH</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="access_method" value="password" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" onchange="toggleAccessMethod()">
                            <span class="mr-2 text-sm text-gray-700">رمز عبور root</span>
                        </label>
                    </div>
                </div>

                <!-- SSH Key -->
                <div id="ssh-key-section">
                    <label class="block text-sm font-medium text-gray-700 mb-2">کلید SSH</label>
                    <select name="ssh_key_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">انتخاب کلید SSH موجود</option>
                        <option value="new">ایجاد کلید جدید</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">یا کلید SSH خود را وارد کنید</p>
                    <textarea name="ssh_public_key" rows="4" class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQ..."></textarea>
                </div>

                <!-- Root Password -->
                <div id="password-section" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">رمز عبور root</label>
                            <input type="password" name="root_password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">تأیید رمز عبور</label>
                            <input type="password" name="root_password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">رمز عبور باید حداقل ۸ کاراکتر باشد</p>
                </div>

                <!-- User Data (Cloud-init) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">User Data (Cloud-init)</label>
                    <textarea name="user_data" rows="6" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" placeholder="#!/bin/bash&#10;apt-get update&#10;apt-get install -y nginx"></textarea>
                    <p class="text-xs text-gray-500 mt-1">اسکریپت cloud-init برای راه‌اندازی خودکار (اختیاری)</p>
                </div>

                <!-- Auto-billing -->
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <label class="flex items-center">
                        <input type="checkbox" name="auto_billing" value="1" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="mr-2 text-sm font-medium text-gray-700">صورتحساب خودکار هنگام راه‌اندازی</span>
                    </label>
                    <p class="text-xs text-gray-600 mt-1 mr-6">هزینه سرور به صورت خودکار از کیف پول شما کسر می‌شود</p>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <button type="button" onclick="prevStep(3)" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-6 rounded-lg transition-colors">
                    ← قبلی
                </button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                    راه‌اندازی سرور →
                </button>
            </div>
        </div>
    </form>
</div>

<script>
let currentStep = 1;

function nextStep(step) {
    // Validate current step
    if (currentStep === 1) {
        const osSelected = document.querySelector('input[name="os"]:checked');
        if (!osSelected) {
            alert('لطفاً یک سیستم عامل انتخاب کنید');
            return;
        }
        if (osSelected.value === 'custom') {
            const isoFile = document.getElementById('iso-file').files[0];
            if (!isoFile) {
                alert('لطفاً فایل ISO را آپلود کنید');
                return;
            }
        }
    } else if (currentStep === 2) {
        const planType = document.querySelector('input[name="plan_type"]:checked').value;
        if (planType === 'prebuilt') {
            const planSelected = document.querySelector('input[name="plan"]:checked');
            if (!planSelected) {
                alert('لطفاً یک پلن انتخاب کنید');
                return;
            }
        }
    }

    // Hide current step
    document.getElementById(`step-${currentStep}-content`).classList.add('hidden');
    
    // Show next step
    document.getElementById(`step-${step}-content`).classList.remove('hidden');
    
    // Update progress indicators
    updateProgress(currentStep, step);
    
    currentStep = step;
}

function prevStep(step) {
    // Hide current step
    document.getElementById(`step-${currentStep}-content`).classList.add('hidden');
    
    // Show previous step
    document.getElementById(`step-${step}-content`).classList.remove('hidden');
    
    // Update progress indicators
    updateProgress(currentStep, step);
    
    currentStep = step;
}

function updateProgress(fromStep, toStep) {
    // Reset all indicators
    for (let i = 1; i <= 4; i++) {
        const indicator = document.getElementById(`step-${i}-indicator`);
        const progress = document.getElementById(`step-${i}-progress`);
        
        if (i < toStep) {
            indicator.classList.remove('bg-gray-300', 'text-gray-600');
            indicator.classList.add('bg-blue-600', 'text-white');
            if (progress) progress.style.width = '100%';
        } else if (i === toStep) {
            indicator.classList.remove('bg-gray-300', 'text-gray-600');
            indicator.classList.add('bg-blue-600', 'text-white');
            if (progress) progress.style.width = '0%';
        } else {
            indicator.classList.remove('bg-blue-600', 'text-white');
            indicator.classList.add('bg-gray-300', 'text-gray-600');
            if (progress) progress.style.width = '0%';
        }
    }
}

function togglePlanType() {
    const planType = document.querySelector('input[name="plan_type"]:checked').value;
    const prebuiltPlans = document.getElementById('prebuilt-plans');
    const customPlan = document.getElementById('custom-plan');
    
    if (planType === 'prebuilt') {
        prebuiltPlans.classList.remove('hidden');
        customPlan.classList.add('hidden');
    } else {
        prebuiltPlans.classList.add('hidden');
        customPlan.classList.remove('hidden');
    }
}

function toggleAccessMethod() {
    const accessMethod = document.querySelector('input[name="access_method"]:checked').value;
    const sshSection = document.getElementById('ssh-key-section');
    const passwordSection = document.getElementById('password-section');
    
    if (accessMethod === 'ssh_key') {
        sshSection.classList.remove('hidden');
        passwordSection.classList.add('hidden');
    } else {
        sshSection.classList.add('hidden');
        passwordSection.classList.remove('hidden');
    }
}

// Show custom ISO upload when custom OS is selected
document.querySelectorAll('input[name="os"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const customUpload = document.getElementById('custom-iso-upload');
        if (this.value === 'custom') {
            customUpload.classList.remove('hidden');
        } else {
            customUpload.classList.add('hidden');
        }
    });
});

// Calculate custom plan price
document.querySelectorAll('input[name="custom_vcpu"], input[name="custom_ram"], input[name="custom_storage"], input[name="custom_bandwidth"]').forEach(input => {
    input.addEventListener('input', calculateCustomPrice);
});

function calculateCustomPrice() {
    const vcpu = parseInt(document.querySelector('input[name="custom_vcpu"]').value) || 1;
    const ram = parseInt(document.querySelector('input[name="custom_ram"]').value) || 2;
    const storage = parseInt(document.querySelector('input[name="custom_storage"]').value) || 20;
    const bandwidth = parseFloat(document.querySelector('input[name="custom_bandwidth"]').value) || 1;
    
    // Simple pricing calculation (adjust as needed)
    const price = (vcpu * 50000) + (ram * 30000) + (storage * 2000) + (bandwidth * 50000);
    document.getElementById('custom-price').textContent = price.toLocaleString('fa-IR') + ' تومان/ماه';
}
</script>
@endsection



