@extends('layouts.customer')

@section('title', 'ایجاد سرور جدید')

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
                'label' => 'سرورها',
                'url' => route('customer.servers.index'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>'
            ],
            [
                'label' => 'افزودن سرور',
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">ایجاد سرور جدید</h1>
        <p class="mt-1 text-sm text-gray-500">راهنمای گام به گام برای راه‌اندازی سرور مجازی</p>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }} flex-1">
                    <h3 class="text-sm font-medium text-red-800 mb-2">خطاهای اعتبارسنجی</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
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
            
            <!-- OS Type Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">نوع سیستم عامل</label>
                <div class="flex gap-4 mb-4">
                    <label class="flex items-center">
                        <input type="radio" name="os" value="ubuntu" class="mr-2" {{ old('os') === 'ubuntu' ? 'checked' : '' }} onchange="loadImages('ubuntu')">
                        <span class="text-sm text-gray-700">Ubuntu</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="os" value="debian" class="mr-2" {{ old('os') === 'debian' ? 'checked' : '' }} onchange="loadImages('debian')">
                        <span class="text-sm text-gray-700">Debian</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="os" value="centos" class="mr-2" {{ old('os') === 'centos' ? 'checked' : '' }} onchange="loadImages('centos')">
                        <span class="text-sm text-gray-700">CentOS</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="os" value="almalinux" class="mr-2" {{ old('os') === 'almalinux' ? 'checked' : '' }} onchange="loadImages('almalinux')">
                        <span class="text-sm text-gray-700">AlmaLinux</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="os" value="windows" class="mr-2" {{ old('os') === 'windows' ? 'checked' : '' }} onchange="loadImages('windows')">
                        <span class="text-sm text-gray-700">Windows</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="os" value="custom" class="mr-2" {{ old('os') === 'custom' ? 'checked' : '' }} onchange="loadImages('custom')">
                        <span class="text-sm text-gray-700">سایر</span>
                    </label>
                </div>
                @error('os')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">انتخاب تصویر</label>
                <select name="image_id" id="image-select" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('image_id') border-red-400 bg-red-50 @enderror">
                    <option value="">لطفاً ابتدا نوع سیستم عامل را انتخاب کنید</option>
                    @foreach($images as $image)
                        <option value="{{ $image->id }}" data-os-type="{{ strtolower($image->name) }}" {{ old('image_id') == $image->id ? 'selected' : '' }}>
                            {{ $image->name }} @if($image->description) - {{ $image->description }} @endif
                        </option>
                    @endforeach
                </select>
                @error('image_id')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">تصاویر موجود در منطقه شما</p>
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
                        <input type="radio" name="plan_type" value="prebuilt" class="mr-2" {{ old('plan_type', 'prebuilt') === 'prebuilt' ? 'checked' : '' }} onchange="togglePlanType()">
                        <span class="text-sm text-gray-700">پلن‌های از پیش تعریف شده</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="plan_type" value="custom" class="mr-2" {{ old('plan_type') === 'custom' ? 'checked' : '' }} onchange="togglePlanType()">
                        <span class="text-sm text-gray-700">سفارشی</span>
                    </label>
                </div>
                @error('plan_type')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prebuilt Plans (Flavors) -->
            <div id="prebuilt-plans" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @forelse($flavors as $flavor)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="flavor_id" value="{{ $flavor->id }}" class="peer hidden" data-flavor-id="{{ $flavor->id }}" {{ old('flavor_id') == $flavor->id ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $flavor->name }}</h3>
                                <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            @if($flavor->description)
                                <p class="text-xs text-gray-500 mb-3">{{ $flavor->description }}</p>
                            @endif
                            <div class="space-y-2 text-sm text-gray-600 mb-4">
                                <p>{{ $flavor->vcpus }} vCPU</p>
                                <p>{{ number_format($flavor->ram_in_gb, 1) }}GB RAM</p>
                                <p>{{ $flavor->disk }}GB Storage</p>
                                @if($flavor->ephemeral_disk > 0)
                                    <p>{{ $flavor->ephemeral_disk }}GB Ephemeral Disk</p>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                @if($flavor->pricing_monthly)
                                    <p class="text-lg font-bold text-gray-900">{{ number_format($flavor->pricing_monthly) }} تومان/ماه</p>
                                @endif
                                @if($flavor->pricing_hourly)
                                    <p class="text-sm text-gray-500">{{ number_format($flavor->pricing_hourly) }} تومان/ساعت</p>
                                @endif
                            </div>
                        </div>
                    </label>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        <p>هیچ پلنی در دسترس نیست. لطفاً با پشتیبانی تماس بگیرید.</p>
                    </div>
                @endforelse
            </div>
            @error('flavor_id')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
            @error('plan')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror

            <!-- Custom Plan -->
            <div id="custom-plan" class="hidden mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تعداد vCPU</label>
                        <input type="number" name="custom_vcpu" id="custom_vcpu" min="1" max="32" value="{{ old('custom_vcpu', 1) }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('custom_vcpu') border-red-400 bg-red-50 @enderror" oninput="calculateCustomPrice()">
                        @error('custom_vcpu')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">RAM (GB)</label>
                        <input type="number" name="custom_ram" id="custom_ram" min="1" max="128" value="{{ old('custom_ram', 2) }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('custom_ram') border-red-400 bg-red-50 @enderror" oninput="calculateCustomPrice()">
                        @error('custom_ram')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">فضای ذخیره‌سازی (GB)</label>
                        <input type="number" name="custom_storage" id="custom_storage" min="20" max="1000" value="{{ old('custom_storage', 20) }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('custom_storage') border-red-400 bg-red-50 @enderror" oninput="calculateCustomPrice()">
                        @error('custom_storage')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">پهنای باند (TB)</label>
                        <input type="number" name="custom_bandwidth" id="custom_bandwidth" min="0.1" max="10" step="0.5" value="{{ old('custom_bandwidth', 1) }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('custom_bandwidth') border-red-400 bg-red-50 @enderror" oninput="calculateCustomPrice()">
                        @error('custom_bandwidth')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-700">
                        <span class="font-medium">قیمت تخمینی:</span>
                        <span id="custom-price" class="text-lg font-bold text-blue-600">محاسبه می‌شود...</span>
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
                <!-- Network Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">انتخاب شبکه</label>
                    <select name="network_ids[]" id="network-select" multiple class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('network_ids') border-red-400 bg-red-50 @enderror" size="4">
                        @forelse($networks as $network)
                            <option value="{{ $network->id }}" {{ in_array($network->id, old('network_ids', [])) ? 'selected' : '' }}>
                                {{ $network->name }} @if($network->external) (عمومی) @else (خصوصی) @endif
                                @if($network->description) - {{ $network->description }} @endif
                            </option>
                        @empty
                            <option value="" disabled>هیچ شبکه‌ای در دسترس نیست</option>
                        @endforelse
                    </select>
                    @error('network_ids')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    @error('network_ids.*')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">برای انتخاب چند مورد، کلید Ctrl (یا Cmd در Mac) را نگه دارید</p>
                </div>

                <!-- Public IP -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="assign_public_ip" value="1" {{ old('assign_public_ip', true) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="mr-2 text-sm font-medium text-gray-700">اختصاص IP عمومی</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 mr-6">سرور شما یک آدرس IP عمومی دریافت می‌کند</p>
                </div>

                <!-- Security Groups -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">گروه‌های امنیتی</label>
                    <select name="security_groups[]" id="security-groups-select" multiple class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('security_groups') border-red-400 bg-red-50 @enderror" size="4">
                        @forelse($securityGroups as $sg)
                            <option value="{{ $sg->id }}" {{ in_array($sg->id, old('security_groups', [])) ? 'selected' : '' }}>
                                {{ $sg->name }}
                                @if($sg->description) - {{ $sg->description }} @endif
                                @if(is_array($sg->rules) && count($sg->rules) > 0)
                                    ({{ count($sg->rules) }} قانون)
                                @endif
                            </option>
                        @empty
                            <option value="" disabled>هیچ گروه امنیتی در دسترس نیست</option>
                        @endforelse
                    </select>
                    @error('security_groups')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    @error('security_groups.*')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">برای انتخاب چند مورد، کلید Ctrl (یا Cmd در Mac) را نگه دارید</p>
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
                    <select name="ssh_key_id" id="ssh-key-select" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('ssh_key_id') border-red-400 bg-red-50 @enderror" onchange="toggleSshKeyInput()">
                        <option value="">انتخاب کلید SSH موجود</option>
                        <option value="new">ایجاد کلید جدید</option>
                        @foreach($keyPairs as $keyPair)
                            <option value="{{ $keyPair->id }}" {{ old('ssh_key_id') == $keyPair->id ? 'selected' : '' }}>
                                {{ $keyPair->name }} @if($keyPair->fingerprint) ({{ substr($keyPair->fingerprint, 0, 16) }}...) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('ssh_key_id')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">یا کلید SSH عمومی خود را وارد کنید</p>
                    <textarea name="ssh_public_key" id="ssh-public-key-input" rows="4" class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm @error('ssh_public_key') border-red-400 bg-red-50 @enderror" placeholder="ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQ...">{{ old('ssh_public_key') }}</textarea>
                    @error('ssh_public_key')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Root Password -->
                <div id="password-section" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">رمز عبور root</label>
                            <input type="password" name="root_password" id="root_password" value="{{ old('root_password') }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('root_password') border-red-400 bg-red-50 @enderror">
                            @error('root_password')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">تأیید رمز عبور</label>
                            <input type="password" name="root_password_confirmation" id="root_password_confirmation" value="{{ old('root_password_confirmation') }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('root_password_confirmation') border-red-400 bg-red-50 @enderror">
                            @error('root_password_confirmation')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">رمز عبور باید حداقل ۸ کاراکتر باشد</p>
                </div>

                <!-- Instance Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام سرور (اختیاری)</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-400 bg-red-50 @enderror" placeholder="سرور من">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">اگر خالی بگذارید، نام به صورت خودکار ایجاد می‌شود</p>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات (اختیاری)</label>
                    <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-400 bg-red-50 @enderror" placeholder="توضیحات سرور">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Data (Cloud-init) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">User Data (Cloud-init) (اختیاری)</label>
                    <textarea name="user_data" rows="6" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm @error('user_data') border-red-400 bg-red-50 @enderror" placeholder="#!/bin/bash&#10;apt-get update&#10;apt-get install -y nginx">{{ old('user_data') }}</textarea>
                    @error('user_data')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">اسکریپت cloud-init برای راه‌اندازی خودکار</p>
                </div>

                <!-- Billing Cycle -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">دوره صورتحساب</label>
                    <select name="billing_cycle" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('billing_cycle') border-red-400 bg-red-50 @enderror">
                        <option value="hourly" {{ old('billing_cycle', 'hourly') === 'hourly' ? 'selected' : '' }}>ساعتی</option>
                        <option value="monthly" {{ old('billing_cycle') === 'monthly' ? 'selected' : '' }}>ماهانه</option>
                    </select>
                    @error('billing_cycle')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Auto-billing -->
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <label class="flex items-center">
                        <input type="checkbox" name="auto_billing" value="1" {{ old('auto_billing', true) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
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
const apiBaseUrl = '{{ route("customer.servers.api.images") }}';
const region = '{{ config("openstack.region") }}';

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial plan type (this will enable/disable fields appropriately)
    togglePlanType();
    
    // Set initial access method
    toggleAccessMethod();
    
    // Filter images based on initial OS selection
    const initialOs = document.querySelector('input[name="os"]:checked');
    if (initialOs) {
        loadImages(initialOs.value);
    }
    
    // Calculate initial custom price if custom plan is selected
    const initialPlanType = document.querySelector('input[name="plan_type"]:checked')?.value;
    if (initialPlanType === 'custom') {
        calculateCustomPrice();
    }
});

function nextStep(step) {
    // Validate current step
    if (currentStep === 1) {
        const osSelected = document.querySelector('input[name="os"]:checked');
        if (!osSelected) {
            alert('لطفاً یک سیستم عامل انتخاب کنید');
            return;
        }
        const imageSelect = document.getElementById('image-select');
        if (!imageSelect || !imageSelect.value) {
            alert('لطفاً یک تصویر انتخاب کنید');
            return;
        }
    } else if (currentStep === 2) {
        const planType = document.querySelector('input[name="plan_type"]:checked')?.value;
        if (planType === 'prebuilt') {
            const flavorSelected = document.querySelector('input[name="flavor_id"]:checked');
            if (!flavorSelected) {
                alert('لطفاً یک پلن انتخاب کنید');
                return;
            }
        } else if (planType === 'custom') {
            const vcpu = parseInt(document.querySelector('input[name="custom_vcpu"]').value) || 0;
            const ram = parseInt(document.querySelector('input[name="custom_ram"]').value) || 0;
            const storage = parseInt(document.querySelector('input[name="custom_storage"]').value) || 0;
            if (vcpu < 1 || ram < 1 || storage < 20) {
                alert('لطفاً مقادیر معتبر برای پلن سفارشی وارد کنید');
                return;
            }
        }
    } else if (currentStep === 4) {
        const accessMethod = document.querySelector('input[name="access_method"]:checked')?.value;
        if (accessMethod === 'ssh_key') {
            const sshKeySelect = document.getElementById('ssh-key-select');
            const sshPublicKeyInput = document.getElementById('ssh-public-key-input');
            const sshKeyId = sshKeySelect ? sshKeySelect.value : '';
            const sshPublicKey = sshPublicKeyInput ? sshPublicKeyInput.value.trim() : '';
            if (!sshKeyId && !sshPublicKey) {
                alert('لطفاً یک کلید SSH انتخاب کنید یا کلید عمومی خود را وارد کنید');
                return;
            }
        } else if (accessMethod === 'password') {
            const rootPassword = document.getElementById('root_password');
            const rootPasswordConfirm = document.getElementById('root_password_confirmation');
            const password = rootPassword ? rootPassword.value : '';
            const passwordConfirm = rootPasswordConfirm ? rootPasswordConfirm.value : '';
            if (!password || password.length < 8) {
                alert('رمز عبور باید حداقل ۸ کاراکتر باشد');
                return;
            }
            if (password !== passwordConfirm) {
                alert('رمز عبور و تأیید رمز عبور مطابقت ندارند');
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
    const planType = document.querySelector('input[name="plan_type"]:checked')?.value;
    const prebuiltPlans = document.getElementById('prebuilt-plans');
    const customPlan = document.getElementById('custom-plan');
    
    // Get custom plan input fields
    const customVcpu = document.getElementById('custom_vcpu');
    const customRam = document.getElementById('custom_ram');
    const customStorage = document.getElementById('custom_storage');
    const customBandwidth = document.getElementById('custom_bandwidth');
    
    if (planType === 'prebuilt') {
        prebuiltPlans.classList.remove('hidden');
        customPlan.classList.add('hidden');
        
        // Disable custom plan fields to prevent validation when hidden
        if (customVcpu) customVcpu.disabled = true;
        if (customRam) customRam.disabled = true;
        if (customStorage) customStorage.disabled = true;
        if (customBandwidth) customBandwidth.disabled = true;
        
        // Clear any selected flavor_id when switching to prebuilt (if needed)
        // The form will use flavor_id directly
    } else {
        prebuiltPlans.classList.add('hidden');
        customPlan.classList.remove('hidden');
        
        // Enable custom plan fields
        if (customVcpu) customVcpu.disabled = false;
        if (customRam) customRam.disabled = false;
        if (customStorage) customStorage.disabled = false;
        if (customBandwidth) customBandwidth.disabled = false;
        
        // Clear flavor_id selection when switching to custom
        const flavorInputs = document.querySelectorAll('input[name="flavor_id"]');
        flavorInputs.forEach(input => input.checked = false);
        
        calculateCustomPrice();
    }
}

function toggleAccessMethod() {
    const accessMethod = document.querySelector('input[name="access_method"]:checked')?.value;
    const sshSection = document.getElementById('ssh-key-section');
    const passwordSection = document.getElementById('password-section');
    
    // Get all SSH key related fields
    const sshKeySelect = document.getElementById('ssh-key-select');
    const sshPublicKeyInput = document.getElementById('ssh-public-key-input');
    
    // Get all password related fields
    const rootPassword = document.getElementById('root_password');
    const rootPasswordConfirm = document.getElementById('root_password_confirmation');
    
    if (accessMethod === 'ssh_key') {
        sshSection.classList.remove('hidden');
        passwordSection.classList.add('hidden');
        
        // Enable SSH key fields
        if (sshKeySelect) sshKeySelect.disabled = false;
        if (sshPublicKeyInput) {
            sshPublicKeyInput.disabled = false;
            sshPublicKeyInput.removeAttribute('required');
        }
        
        // Disable password fields
        if (rootPassword) {
            rootPassword.disabled = true;
            rootPassword.value = '';
            rootPassword.removeAttribute('required');
        }
        if (rootPasswordConfirm) {
            rootPasswordConfirm.disabled = true;
            rootPasswordConfirm.value = '';
            rootPasswordConfirm.removeAttribute('required');
        }
        
        // Update SSH key input requirement based on selection
        toggleSshKeyInput();
    } else {
        sshSection.classList.add('hidden');
        passwordSection.classList.remove('hidden');
        
        // Disable SSH key fields
        if (sshKeySelect) {
            sshKeySelect.disabled = true;
            sshKeySelect.value = '';
        }
        if (sshPublicKeyInput) {
            sshPublicKeyInput.disabled = true;
            sshPublicKeyInput.value = '';
            sshPublicKeyInput.removeAttribute('required');
        }
        
        // Enable password fields
        if (rootPassword) {
            rootPassword.disabled = false;
            rootPassword.setAttribute('required', 'required');
        }
        if (rootPasswordConfirm) {
            rootPasswordConfirm.disabled = false;
            rootPasswordConfirm.setAttribute('required', 'required');
        }
    }
}

function toggleSshKeyInput() {
    const sshKeySelect = document.getElementById('ssh-key-select');
    const sshPublicKeyInput = document.getElementById('ssh-public-key-input');
    const accessMethod = document.querySelector('input[name="access_method"]:checked')?.value;
    
    // Only modify if SSH key method is selected and field is not disabled
    if (accessMethod === 'ssh_key' && sshPublicKeyInput && !sshPublicKeyInput.disabled) {
        if (sshKeySelect.value === 'new' || sshKeySelect.value === '') {
            sshPublicKeyInput.setAttribute('required', 'required');
        } else {
            sshPublicKeyInput.removeAttribute('required');
            sshPublicKeyInput.value = '';
        }
    }
}

function loadImages(osType) {
    const imageSelect = document.getElementById('image-select');
    const currentValue = imageSelect.value;
    
    // Show loading state
    imageSelect.innerHTML = '<option value="">در حال بارگذاری...</option>';
    imageSelect.disabled = true;
    
    // Fetch images from API
    fetch(`{{ route('customer.servers.api.images') }}?os=${osType}&region=${region}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        imageSelect.innerHTML = '<option value="">انتخاب تصویر</option>';
        
        if (data.success && data.data && data.data.length > 0) {
            data.data.forEach(image => {
                const option = document.createElement('option');
                option.value = image.id;
                option.textContent = `${image.name}${image.description ? ' - ' + image.description : ''}`;
                if (image.id === currentValue) {
                    option.selected = true;
                }
                imageSelect.appendChild(option);
            });
        } else {
            imageSelect.innerHTML = '<option value="">هیچ تصویری یافت نشد</option>';
        }
        
        imageSelect.disabled = false;
    })
    .catch(error => {
        console.error('Error loading images:', error);
        imageSelect.innerHTML = '<option value="">خطا در بارگذاری تصاویر</option>';
        imageSelect.disabled = false;
    });
}

function calculateCustomPrice() {
    const vcpu = parseInt(document.querySelector('input[name="custom_vcpu"]')?.value) || 1;
    const ram = parseInt(document.querySelector('input[name="custom_ram"]')?.value) || 2;
    const storage = parseInt(document.querySelector('input[name="custom_storage"]')?.value) || 20;
    const bandwidth = parseFloat(document.querySelector('input[name="custom_bandwidth"]')?.value) || 1;
    
    // Pricing calculation (adjust based on your pricing model)
    // Base pricing: vCPU * 50000 + RAM * 30000 + Storage * 2000 + Bandwidth * 50000
    const price = (vcpu * 50000) + (ram * 30000) + (storage * 2000) + (bandwidth * 50000);
    const priceElement = document.getElementById('custom-price');
    if (priceElement) {
        priceElement.textContent = price.toLocaleString('fa-IR') + ' تومان/ماه';
    }
}

// Form submission handler
document.getElementById('vps-wizard-form').addEventListener('submit', function(e) {
    // Ensure all disabled fields are properly handled before submission
    const planType = document.querySelector('input[name="plan_type"]:checked')?.value;
    
    // Disable custom plan fields if prebuilt is selected
    if (planType === 'prebuilt') {
        const customVcpu = document.getElementById('custom_vcpu');
        const customRam = document.getElementById('custom_ram');
        const customStorage = document.getElementById('custom_storage');
        const customBandwidth = document.getElementById('custom_bandwidth');
        if (customVcpu) customVcpu.disabled = true;
        if (customRam) customRam.disabled = true;
        if (customStorage) customStorage.disabled = true;
        if (customBandwidth) customBandwidth.disabled = true;
    }
    
    // Handle access method fields
    const accessMethod = document.querySelector('input[name="access_method"]:checked')?.value;
    if (accessMethod === 'ssh_key') {
        // Disable password fields
        const rootPassword = document.getElementById('root_password');
        const rootPasswordConfirm = document.getElementById('root_password_confirmation');
        if (rootPassword) {
            rootPassword.disabled = true;
            rootPassword.removeAttribute('required');
        }
        if (rootPasswordConfirm) {
            rootPasswordConfirm.disabled = true;
            rootPasswordConfirm.removeAttribute('required');
        }
        
        // Validate SSH key
        const sshKeySelect = document.getElementById('ssh-key-select');
        const sshPublicKeyInput = document.getElementById('ssh-public-key-input');
        const sshKeyId = sshKeySelect ? sshKeySelect.value : '';
        const sshPublicKey = sshPublicKeyInput ? sshPublicKeyInput.value.trim() : '';
        if (!sshKeyId && !sshPublicKey) {
            e.preventDefault();
            alert('لطفاً یک کلید SSH انتخاب کنید یا کلید عمومی خود را وارد کنید');
            return false;
        }
    } else if (accessMethod === 'password') {
        // Disable SSH key fields
        const sshKeySelect = document.getElementById('ssh-key-select');
        const sshPublicKeyInput = document.getElementById('ssh-public-key-input');
        if (sshKeySelect) {
            sshKeySelect.disabled = true;
            sshKeySelect.value = '';
        }
        if (sshPublicKeyInput) {
            sshPublicKeyInput.disabled = true;
            sshPublicKeyInput.value = '';
            sshPublicKeyInput.removeAttribute('required');
        }
        
        // Validate password
        const rootPassword = document.getElementById('root_password');
        const rootPasswordConfirm = document.getElementById('root_password_confirmation');
        const password = rootPassword ? rootPassword.value : '';
        const passwordConfirm = rootPasswordConfirm ? rootPasswordConfirm.value : '';
        if (!password || password.length < 8) {
            e.preventDefault();
            alert('رمز عبور باید حداقل ۸ کاراکتر باشد');
            return false;
        }
        if (password !== passwordConfirm) {
            e.preventDefault();
            alert('رمز عبور و تأیید رمز عبور مطابقت ندارند');
            return false;
        }
    }
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'در حال ایجاد سرور...';
    }
});
</script>
@endsection



