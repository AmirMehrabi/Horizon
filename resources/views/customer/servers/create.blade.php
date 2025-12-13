@extends('layouts.customer')

@section('title', 'ایجاد سرور جدید')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
    
    // Get available images for "Other" category (cirros)
    $otherImages = $images->filter(function($image) {
        return stripos($image->name, 'cirros') !== false;
    });
    
    // Popular distros list with icon paths
    $popularDistros = [
        ['id' => 'ubuntu', 'name' => 'Ubuntu', 'icon' => 'icons8-ubuntu-100.png'],
        ['id' => 'debian', 'name' => 'Debian', 'icon' => 'icons8-debian-100.png'],
        ['id' => 'centos', 'name' => 'CentOS', 'icon' => 'icons8-centos-100.png'],
        ['id' => 'almalinux', 'name' => 'AlmaLinux', 'icon' => 'AlmaLinux_Icon_Logo.svg'],
        ['id' => 'rocky', 'name' => 'Rocky Linux', 'icon' => 'Rocky_Linux_logo.svg'],
        ['id' => 'fedora', 'name' => 'Fedora', 'icon' => 'icons8-fedora-100.png'],
        ['id' => 'opensuse', 'name' => 'openSUSE', 'icon' => 'icons8-suse-100.png'],
        ['id' => 'arch', 'name' => 'Arch Linux', 'icon' => 'icons8-arch-linux-100.png'],
    ];
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
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">ایجاد سرور جدید</h1>
        <p class="mt-1 text-sm text-gray-500">پیکربندی و راه‌اندازی سرور مجازی خود</p>
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

    <!-- Main Layout: Form + Sidebar -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Form Section (Scrollable) -->
        <div class="flex-1 lg:max-w-3xl">
            <form id="server-create-form" action="{{ route('customer.servers.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Operating System Selection -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">انتخاب سیستم عامل</h2>
                    
                    <!-- Popular Distributions Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
                        @foreach($popularDistros as $distro)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="os" value="{{ $distro['id'] }}" class="peer hidden" data-distro="{{ $distro['id'] }}" onchange="handleDistroChange('{{ $distro['id'] }}')">
                                <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all text-center">
                                    <!-- Distro Logo -->
                                    <div class="w-12 h-12 mx-auto mb-2 flex items-center justify-center">
                                        <img src="{{ asset('assets/os-icons/' . $distro['icon']) }}" alt="{{ $distro['name'] }}" class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-sm font-medium text-gray-700">{{ $distro['name'] }}</div>
                                    <div class="mt-2">
                                        <select name="image_id_{{ $distro['id'] }}" id="image-select-{{ $distro['id'] }}" class="w-full text-xs border border-gray-300 rounded px-2 py-1 hidden peer-checked:block" disabled>
                                            <option value="">انتخاب نسخه</option>
                                        </select>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                        
                        <!-- Other Option -->
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="os" value="custom" class="peer hidden" data-distro="custom" onchange="handleDistroChange('custom')">
                            <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all text-center">
                                <div class="w-12 h-12 mx-auto mb-2 flex items-center justify-center">
                                    <img src="{{ asset('assets/os-icons/icons8-linux-100.png') }}" alt="Other" class="w-full h-full object-contain">
                                </div>
                                <div class="text-sm font-medium text-gray-700">سایر</div>
                                <div class="mt-2">
                                    <select name="image_id" id="image-select-custom" class="w-full text-xs border border-gray-300 rounded px-2 py-1 hidden peer-checked:block" onchange="updateChecklist()">
                                        <option value="">انتخاب تصویر</option>
                                        @foreach($otherImages as $image)
                                            <option value="{{ $image->id }}" {{ old('image_id') == $image->id ? 'selected' : '' }}>
                                                {{ $image->name }} @if($image->description) - {{ $image->description }} @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </label>
                </div>
                    
                @error('os')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
                @error('image_id')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

                <!-- Plan Selection -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">انتخاب پلن</h2>
                    
                    <!-- Plan Type Toggle -->
                    <div class="mb-4">
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
            </div>

            <!-- Prebuilt Plans (Flavors) -->
                    <div id="prebuilt-plans" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($flavors as $flavor)
                    <label class="relative cursor-pointer">
                                <input type="radio" name="flavor_id" value="{{ $flavor->id }}" class="peer hidden" data-flavor-id="{{ $flavor->id }}" data-hourly="{{ $flavor->pricing_hourly ?? 0 }}" data-monthly="{{ $flavor->pricing_monthly ?? 0 }}" {{ old('flavor_id') == $flavor->id ? 'checked' : '' }} onchange="updatePricing(); updateChecklist();">
                                <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-base font-semibold text-gray-900">{{ $flavor->name }}</h3>
                                <svg class="w-5 h-5 text-blue-600 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                                    <div class="space-y-1 text-sm text-gray-600 mb-3">
                                        <div class="flex justify-between">
                                            <span>vCPU:</span>
                                            <span class="font-medium">{{ $flavor->vcpus }}</span>
                            </div>
                                        <div class="flex justify-between">
                                            <span>RAM:</span>
                                            <span class="font-medium">{{ number_format($flavor->ram_in_gb, 1) }} GB</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Storage:</span>
                                            <span class="font-medium">{{ $flavor->disk }} GB</span>
                                        </div>
                            </div>
                        </div>
                    </label>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                                <p>هیچ پلنی در دسترس نیست</p>
                    </div>
                @endforelse
            </div>

            <!-- Custom Plan -->
                    <div id="custom-plan" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تعداد vCPU</label>
                                <input type="number" name="custom_vcpu" id="custom_vcpu" min="1" max="32" value="{{ old('custom_vcpu', 1) }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" oninput="calculateCustomPrice(); updateChecklist();">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">RAM (GB)</label>
                                <input type="number" name="custom_ram" id="custom_ram" min="1" max="128" value="{{ old('custom_ram', 2) }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" oninput="calculateCustomPrice(); updateChecklist();">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">فضای ذخیره‌سازی (GB)</label>
                                <input type="number" name="custom_storage" id="custom_storage" min="20" max="1000" value="{{ old('custom_storage', 20) }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" oninput="calculateCustomPrice(); updateChecklist();">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">پهنای باند (TB)</label>
                                <input type="number" name="custom_bandwidth" id="custom_bandwidth" min="0.1" max="10" step="0.5" value="{{ old('custom_bandwidth', 1) }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" oninput="calculateCustomPrice(); updateChecklist();">
                    </div>
                </div>
            </div>

                    @error('flavor_id')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
        </div>

                <!-- Network Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">تنظیمات شبکه</h2>
                    
                    <div class="space-y-4">
                <!-- Network Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">انتخاب شبکه</label>
                            <select name="network_ids[]" id="network-select" multiple class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" size="4" onchange="updateChecklist()">
                        @forelse($networks as $network)
                            <option value="{{ $network->id }}" {{ in_array($network->id, old('network_ids', [])) ? 'selected' : '' }}>
                                {{ $network->name }} @if($network->external) (عمومی) @else (خصوصی) @endif
                            </option>
                        @empty
                            <option value="" disabled>هیچ شبکه‌ای در دسترس نیست</option>
                        @endforelse
                    </select>
                    <p class="text-xs text-gray-500 mt-1">برای انتخاب چند مورد، کلید Ctrl (یا Cmd در Mac) را نگه دارید</p>
                </div>

                <!-- Public IP -->
                <div>
                    <label class="flex items-center">
                                <input type="checkbox" name="assign_public_ip" value="1" {{ old('assign_public_ip', true) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" onchange="updateChecklist()">
                        <span class="mr-2 text-sm font-medium text-gray-700">اختصاص IP عمومی</span>
                    </label>
                </div>

                <!-- Security Groups -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">گروه‌های امنیتی</label>
                            <select name="security_groups[]" id="security-groups-select" multiple class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" size="4" onchange="updateChecklist()">
                        @forelse($securityGroups as $sg)
                            <option value="{{ $sg->id }}" {{ in_array($sg->id, old('security_groups', [])) ? 'selected' : '' }}>
                                {{ $sg->name }}
                                @if($sg->description) - {{ $sg->description }} @endif
                            </option>
                        @empty
                            <option value="" disabled>هیچ گروه امنیتی در دسترس نیست</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>

                <!-- Access Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">دسترسی و راه‌اندازی</h2>
                    
                    <div class="space-y-4">
                <!-- Access Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">روش دسترسی</label>
                    <div class="space-y-3">
                        <label class="flex items-center">
                                    <input type="radio" name="access_method" value="ssh_key" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked onchange="toggleAccessMethod(); updateChecklist();">
                            <span class="mr-2 text-sm text-gray-700">کلید SSH</span>
                        </label>
                        <label class="flex items-center">
                                    <input type="radio" name="access_method" value="password" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" onchange="toggleAccessMethod(); updateChecklist();">
                            <span class="mr-2 text-sm text-gray-700">رمز عبور root</span>
                        </label>
                    </div>
                </div>

                <!-- SSH Key -->
                <div id="ssh-key-section">
                    <label class="block text-sm font-medium text-gray-700 mb-2">کلید SSH</label>
                            <select name="ssh_key_id" id="ssh-key-select" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 mb-2" onchange="toggleSshKeyInput(); updateChecklist();">
                        <option value="">انتخاب کلید SSH موجود</option>
                        <option value="new">ایجاد کلید جدید</option>
                        @foreach($keyPairs as $keyPair)
                            <option value="{{ $keyPair->id }}" {{ old('ssh_key_id') == $keyPair->id ? 'selected' : '' }}>
                                {{ $keyPair->name }} @if($keyPair->fingerprint) ({{ substr($keyPair->fingerprint, 0, 16) }}...) @endif
                            </option>
                        @endforeach
                    </select>
                            <p class="text-xs text-gray-500 mb-2">یا کلید SSH عمومی خود را وارد کنید</p>
                            <textarea name="ssh_public_key" id="ssh-public-key-input" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" placeholder="ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQ..." onchange="updateChecklist()">{{ old('ssh_public_key') }}</textarea>
                </div>

                <!-- Root Password -->
                <div id="password-section" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">رمز عبور root</label>
                                    <input type="password" name="root_password" id="root_password" value="{{ old('root_password') }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" onchange="updateChecklist()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">تأیید رمز عبور</label>
                                    <input type="password" name="root_password_confirmation" id="root_password_confirmation" value="{{ old('root_password_confirmation') }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" onchange="updateChecklist()">
                        </div>
                    </div>
                </div>

                <!-- Instance Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام سرور (اختیاری)</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="سرور من">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات (اختیاری)</label>
                            <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="توضیحات سرور">{{ old('description') }}</textarea>
                </div>

                        <!-- User Data -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">User Data (Cloud-init) (اختیاری)</label>
                            <textarea name="user_data" rows="6" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" placeholder="#!/bin/bash&#10;apt-get update&#10;apt-get install -y nginx">{{ old('user_data') }}</textarea>
                </div>

                <!-- Billing Cycle -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">دوره صورتحساب</label>
                            <select name="billing_cycle" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" onchange="updatePricing()">
                        <option value="hourly" {{ old('billing_cycle', 'hourly') === 'hourly' ? 'selected' : '' }}>ساعتی</option>
                        <option value="monthly" {{ old('billing_cycle') === 'monthly' ? 'selected' : '' }}>ماهانه</option>
                    </select>
                </div>

                <!-- Auto-billing -->
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <label class="flex items-center">
                        <input type="checkbox" name="auto_billing" value="1" {{ old('auto_billing', true) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="mr-2 text-sm font-medium text-gray-700">صورتحساب خودکار هنگام راه‌اندازی</span>
                    </label>
                </div>
                    </div>
                </div>
            </form>
            </div>

        <!-- Sticky Sidebar -->
        <div class="lg:w-80 lg:sticky lg:top-6 lg:self-start">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">خلاصه پیکربندی</h3>
                
                <!-- Checklist -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-center" id="checklist-os">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-gray-600">سیستم عامل</span>
                    </div>
                    <div class="flex items-center" id="checklist-flavor">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-gray-600">پلن</span>
                    </div>
                    <div class="flex items-center" id="checklist-network">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-gray-600">شبکه</span>
                    </div>
                    <div class="flex items-center" id="checklist-access">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-gray-600">دسترسی</span>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="border-t border-gray-200 pt-4 mb-6">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">قیمت ساعتی:</span>
                            <span class="text-lg font-bold text-gray-900" id="pricing-hourly">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">قیمت ماهانه:</span>
                            <span class="text-lg font-bold text-gray-900" id="pricing-monthly">-</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" form="server-create-form" id="submit-button" disabled class="w-full bg-gray-300 text-gray-500 font-medium py-3 px-4 rounded-lg transition-colors cursor-not-allowed">
                    راه‌اندازی سرور
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const apiBaseUrl = '{{ route("customer.servers.api.images") }}';
const region = '{{ config("openstack.region") }}';

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    togglePlanType();
    toggleAccessMethod();
    updateChecklist();
    updatePricing();
    
    // Add change listener to custom image select
    const customImageSelect = document.getElementById('image-select-custom');
    if (customImageSelect) {
        customImageSelect.addEventListener('change', updateChecklist);
    }
});

function handleDistroChange(distroId) {
    // Hide all version dropdowns and remove name attribute
    document.querySelectorAll('[id^="image-select-"]').forEach(select => {
        select.classList.add('hidden');
        select.disabled = true;
        if (select.name === 'image_id') {
            select.removeAttribute('name');
        }
    });
    
    // Show and enable the selected distro's dropdown
    const select = document.getElementById(`image-select-${distroId}`);
    if (select) {
        select.classList.remove('hidden');
        select.disabled = false;
        
        // For "Other" (custom), set name directly
        if (distroId === 'custom') {
            select.name = 'image_id';
            // Remove any existing hidden input
            const hiddenInput = document.querySelector('input[name="image_id"][type="hidden"]');
            if (hiddenInput) {
                hiddenInput.remove();
            }
        } else {
            // For other distros, load images and sync to hidden field
            loadImagesForDistro(distroId, select);
        }
    }
    
    updateChecklist();
}

function loadImagesForDistro(distroId, selectElement) {
    selectElement.innerHTML = '<option value="">در حال بارگذاری...</option>';
    selectElement.disabled = true;
    
    fetch(`${apiBaseUrl}?os=${distroId}&region=${region}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        selectElement.innerHTML = '<option value="">انتخاب نسخه</option>';
        
        if (data.success && data.data && data.data.length > 0) {
            data.data.forEach(image => {
                const option = document.createElement('option');
                option.value = image.id;
                option.textContent = `${image.name}${image.description ? ' - ' + image.description : ''}`;
                selectElement.appendChild(option);
            });
        } else {
            selectElement.innerHTML = '<option value="">هیچ نسخه‌ای یافت نشد</option>';
        }
        
        selectElement.disabled = false;
        
        // Sync to hidden image_id field on change
        selectElement.addEventListener('change', function syncImageId() {
            let hiddenInput = document.querySelector('input[name="image_id"][type="hidden"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'image_id';
                document.getElementById('server-create-form').appendChild(hiddenInput);
            }
            hiddenInput.value = this.value;
            updateChecklist();
        });
        
        // Trigger change if there's a selected value
        if (selectElement.value) {
            selectElement.dispatchEvent(new Event('change'));
        }
    })
    .catch(error => {
        console.error('Error loading images:', error);
        selectElement.innerHTML = '<option value="">خطا در بارگذاری</option>';
        selectElement.disabled = false;
    });
}

function updateChecklist() {
    // Check OS selection
        const osSelected = document.querySelector('input[name="os"]:checked');
    const osCheck = document.getElementById('checklist-os');
    let imageId = '';
    
    if (osSelected) {
        if (osSelected.value === 'custom') {
            // For "Other", check the custom select directly
            const customSelect = document.getElementById('image-select-custom');
            imageId = customSelect ? customSelect.value : '';
        } else {
            // For other distros, check the hidden input or the select
            const hiddenInput = document.querySelector('input[name="image_id"][type="hidden"]');
            if (hiddenInput) {
                imageId = hiddenInput.value;
            } else {
                const distroSelect = document.getElementById(`image-select-${osSelected.value}`);
                imageId = distroSelect ? distroSelect.value : '';
            }
        }
        
        if (imageId) {
            osCheck.querySelector('svg').classList.remove('text-gray-400');
            osCheck.querySelector('svg').classList.add('text-green-500');
        } else {
            osCheck.querySelector('svg').classList.remove('text-green-500');
            osCheck.querySelector('svg').classList.add('text-gray-400');
        }
    } else {
        osCheck.querySelector('svg').classList.remove('text-green-500');
        osCheck.querySelector('svg').classList.add('text-gray-400');
    }
    
    // Check Flavor selection
        const planType = document.querySelector('input[name="plan_type"]:checked')?.value;
    const flavorCheck = document.getElementById('checklist-flavor');
        if (planType === 'prebuilt') {
            const flavorSelected = document.querySelector('input[name="flavor_id"]:checked');
        if (flavorSelected) {
            flavorCheck.querySelector('svg').classList.remove('text-gray-400');
            flavorCheck.querySelector('svg').classList.add('text-green-500');
        } else {
            flavorCheck.querySelector('svg').classList.remove('text-green-500');
            flavorCheck.querySelector('svg').classList.add('text-gray-400');
            }
        } else if (planType === 'custom') {
        const vcpu = parseInt(document.getElementById('custom_vcpu')?.value) || 0;
        const ram = parseInt(document.getElementById('custom_ram')?.value) || 0;
        const storage = parseInt(document.getElementById('custom_storage')?.value) || 0;
        if (vcpu > 0 && ram > 0 && storage >= 20) {
            flavorCheck.querySelector('svg').classList.remove('text-gray-400');
            flavorCheck.querySelector('svg').classList.add('text-green-500');
        } else {
            flavorCheck.querySelector('svg').classList.remove('text-green-500');
            flavorCheck.querySelector('svg').classList.add('text-gray-400');
        }
    } else {
        flavorCheck.querySelector('svg').classList.remove('text-green-500');
        flavorCheck.querySelector('svg').classList.add('text-gray-400');
    }
    
    // Check Network (at least one network selected)
    const networkCheck = document.getElementById('checklist-network');
    const networkSelect = document.getElementById('network-select');
    if (networkSelect && networkSelect.selectedOptions.length > 0) {
        networkCheck.querySelector('svg').classList.remove('text-gray-400');
        networkCheck.querySelector('svg').classList.add('text-green-500');
    } else {
        networkCheck.querySelector('svg').classList.remove('text-green-500');
        networkCheck.querySelector('svg').classList.add('text-gray-400');
    }
    
    // Check Access
    const accessCheck = document.getElementById('checklist-access');
        const accessMethod = document.querySelector('input[name="access_method"]:checked')?.value;
        if (accessMethod === 'ssh_key') {
        const sshKeyId = document.getElementById('ssh-key-select')?.value;
        const sshPublicKey = document.getElementById('ssh-public-key-input')?.value.trim();
        if (sshKeyId || sshPublicKey) {
            accessCheck.querySelector('svg').classList.remove('text-gray-400');
            accessCheck.querySelector('svg').classList.add('text-green-500');
        } else {
            accessCheck.querySelector('svg').classList.remove('text-green-500');
            accessCheck.querySelector('svg').classList.add('text-gray-400');
            }
        } else if (accessMethod === 'password') {
        const password = document.getElementById('root_password')?.value;
        const passwordConfirm = document.getElementById('root_password_confirmation')?.value;
        if (password && password.length >= 8 && password === passwordConfirm) {
            accessCheck.querySelector('svg').classList.remove('text-gray-400');
            accessCheck.querySelector('svg').classList.add('text-green-500');
        } else {
            accessCheck.querySelector('svg').classList.remove('text-green-500');
            accessCheck.querySelector('svg').classList.add('text-gray-400');
        }
    } else {
        accessCheck.querySelector('svg').classList.remove('text-green-500');
        accessCheck.querySelector('svg').classList.add('text-gray-400');
    }
    
    // Enable/disable submit button
    const allChecked = 
        osCheck.querySelector('svg').classList.contains('text-green-500') &&
        flavorCheck.querySelector('svg').classList.contains('text-green-500') &&
        networkCheck.querySelector('svg').classList.contains('text-green-500') &&
        accessCheck.querySelector('svg').classList.contains('text-green-500');
    
    const submitButton = document.getElementById('submit-button');
    if (allChecked) {
        submitButton.disabled = false;
        submitButton.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
        submitButton.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
    } else {
        submitButton.disabled = true;
        submitButton.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
        submitButton.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
    }
}

function updatePricing() {
    const planType = document.querySelector('input[name="plan_type"]:checked')?.value;
    let hourly = 0;
    let monthly = 0;
    
    if (planType === 'prebuilt') {
        const flavorSelected = document.querySelector('input[name="flavor_id"]:checked');
        if (flavorSelected) {
            hourly = parseFloat(flavorSelected.dataset.hourly) || 0;
            monthly = parseFloat(flavorSelected.dataset.monthly) || 0;
        }
    } else if (planType === 'custom') {
        // Calculate custom pricing
        const vcpu = parseInt(document.getElementById('custom_vcpu')?.value) || 1;
        const ram = parseInt(document.getElementById('custom_ram')?.value) || 2;
        const storage = parseInt(document.getElementById('custom_storage')?.value) || 20;
        const bandwidth = parseFloat(document.getElementById('custom_bandwidth')?.value) || 1;
        
        // Base pricing calculation
        monthly = (vcpu * 50000) + (ram * 30000) + (storage * 2000) + (bandwidth * 50000);
        hourly = monthly / 730; // Approximate hourly
    }
    
    // Update display
    const billingCycle = document.querySelector('select[name="billing_cycle"]')?.value;
    const hourlyEl = document.getElementById('pricing-hourly');
    const monthlyEl = document.getElementById('pricing-monthly');
    
    if (hourly > 0) {
        hourlyEl.textContent = hourly.toLocaleString('fa-IR') + ' تومان';
    } else {
        hourlyEl.textContent = '-';
    }
    
    if (monthly > 0) {
        monthlyEl.textContent = monthly.toLocaleString('fa-IR') + ' تومان';
        } else {
        monthlyEl.textContent = '-';
    }
}

function togglePlanType() {
    const planType = document.querySelector('input[name="plan_type"]:checked')?.value;
    const prebuiltPlans = document.getElementById('prebuilt-plans');
    const customPlan = document.getElementById('custom-plan');
    
    const customVcpu = document.getElementById('custom_vcpu');
    const customRam = document.getElementById('custom_ram');
    const customStorage = document.getElementById('custom_storage');
    const customBandwidth = document.getElementById('custom_bandwidth');
    
    if (planType === 'prebuilt') {
        prebuiltPlans.classList.remove('hidden');
        customPlan.classList.add('hidden');
        
        if (customVcpu) customVcpu.disabled = true;
        if (customRam) customRam.disabled = true;
        if (customStorage) customStorage.disabled = true;
        if (customBandwidth) customBandwidth.disabled = true;
    } else {
        prebuiltPlans.classList.add('hidden');
        customPlan.classList.remove('hidden');
        
        if (customVcpu) customVcpu.disabled = false;
        if (customRam) customRam.disabled = false;
        if (customStorage) customStorage.disabled = false;
        if (customBandwidth) customBandwidth.disabled = false;
        
        calculateCustomPrice();
    }
    
    updatePricing();
    updateChecklist();
}

function calculateCustomPrice() {
    updatePricing();
}

function toggleAccessMethod() {
    const accessMethod = document.querySelector('input[name="access_method"]:checked')?.value;
    const sshSection = document.getElementById('ssh-key-section');
    const passwordSection = document.getElementById('password-section');
    
    const sshKeySelect = document.getElementById('ssh-key-select');
    const sshPublicKeyInput = document.getElementById('ssh-public-key-input');
    const rootPassword = document.getElementById('root_password');
    const rootPasswordConfirm = document.getElementById('root_password_confirmation');
    
    if (accessMethod === 'ssh_key') {
        sshSection.classList.remove('hidden');
        passwordSection.classList.add('hidden');
        
        if (sshKeySelect) sshKeySelect.disabled = false;
        if (sshPublicKeyInput) sshPublicKeyInput.disabled = false;
        
        if (rootPassword) {
            rootPassword.disabled = true;
            rootPassword.value = '';
        }
        if (rootPasswordConfirm) {
            rootPasswordConfirm.disabled = true;
            rootPasswordConfirm.value = '';
        }
        
        toggleSshKeyInput();
    } else {
        sshSection.classList.add('hidden');
        passwordSection.classList.remove('hidden');
        
        if (sshKeySelect) {
            sshKeySelect.disabled = true;
            sshKeySelect.value = '';
        }
        if (sshPublicKeyInput) {
            sshPublicKeyInput.disabled = true;
            sshPublicKeyInput.value = '';
        }
        
        if (rootPassword) rootPassword.disabled = false;
        if (rootPasswordConfirm) rootPasswordConfirm.disabled = false;
    }
    
    updateChecklist();
}

function toggleSshKeyInput() {
    const sshKeySelect = document.getElementById('ssh-key-select');
    const sshPublicKeyInput = document.getElementById('ssh-public-key-input');
    const accessMethod = document.querySelector('input[name="access_method"]:checked')?.value;
    
    if (accessMethod === 'ssh_key' && sshPublicKeyInput && !sshPublicKeyInput.disabled) {
        if (sshKeySelect.value === 'new' || sshKeySelect.value === '') {
            sshPublicKeyInput.setAttribute('required', 'required');
        } else {
            sshPublicKeyInput.removeAttribute('required');
        }
    }
}

// Form submission handler
document.getElementById('server-create-form').addEventListener('submit', function(e) {
    // Ensure image_id is set correctly
    const osSelected = document.querySelector('input[name="os"]:checked');
    if (osSelected) {
        if (osSelected.value === 'custom') {
            // For "Other", the select already has name="image_id"
            const customSelect = document.getElementById('image-select-custom');
            if (!customSelect || !customSelect.value) {
                e.preventDefault();
                alert('لطفاً یک تصویر انتخاب کنید');
                return false;
            }
        } else {
            // For other distros, ensure hidden input exists and has value
            const distroSelect = document.getElementById(`image-select-${osSelected.value}`);
            if (!distroSelect || !distroSelect.value) {
                e.preventDefault();
                alert('لطفاً یک نسخه انتخاب کنید');
                return false;
            }
            
            let hiddenInput = document.querySelector('input[name="image_id"][type="hidden"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'image_id';
                this.appendChild(hiddenInput);
            }
            hiddenInput.value = distroSelect.value;
        }
    } else {
        e.preventDefault();
        alert('لطفاً یک سیستم عامل انتخاب کنید');
        return false;
    }
    
    // Disable custom plan fields if prebuilt is selected
    const planType = document.querySelector('input[name="plan_type"]:checked')?.value;
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
    } else if (accessMethod === 'password') {
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
    }
    
    // Show loading state
    const submitButton = document.getElementById('submit-button');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'در حال ایجاد سرور...';
    }
});
</script>
@endsection
