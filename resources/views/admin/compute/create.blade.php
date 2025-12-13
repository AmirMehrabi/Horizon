@extends('layouts.admin')

@section('title', 'ایجاد Instance جدید')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.compute.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Instance ها
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 mr-1 md:mr-2">ایجاد Instance جدید</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">ایجاد Instance جدید</h1>
    <p class="mt-1 text-sm text-gray-500">ایجاد Instance جدید در OpenStack</p>
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

<!-- Create Form -->
<form method="POST" action="{{ route('admin.compute.store') }}" class="space-y-6">
    @csrf

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات پایه</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">مشتری <span class="text-red-500">*</span></label>
                <select name="customer_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">انتخاب مشتری</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->company_name ?: $customer->first_name . ' ' . $customer->last_name }}
                            @if($customer->email)
                                ({{ $customer->email }})
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">نام Instance <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="web-server-01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
                <textarea name="description" rows="3" placeholder="توضیحات اختیاری..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">منابع</h2>
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image <span class="text-red-500">*</span></label>
                <select name="image_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">انتخاب Image</option>
                    @foreach($images as $image)
                        <option value="{{ $image->id }}" {{ old('image_id') == $image->id ? 'selected' : '' }}>
                            {{ $image->name }}
                            @if($image->disk_format)
                                ({{ $image->disk_format }})
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Flavor (سایز) <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($flavors as $flavor)
                        <label class="flex items-center p-4 border-2 {{ old('flavor_id') == $flavor->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                            <input type="radio" name="flavor_id" value="{{ $flavor->id }}" {{ old('flavor_id') == $flavor->id ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                                <p class="font-medium text-gray-900">{{ $flavor->name }}</p>
                                <p class="text-sm text-gray-500">{{ $flavor->vcpus }} vCPU, {{ number_format($flavor->ram / 1024) }} GB RAM, {{ $flavor->disk }} GB Disk</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">شبکه‌سازی</h2>
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Network ها <span class="text-red-500">*</span></label>
                <div class="space-y-2 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-4">
                    @foreach($networks as $network)
                        <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                            <input type="checkbox" name="network_ids[]" value="{{ $network->id }}" {{ in_array($network->id, old('network_ids', [])) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                                <p class="font-medium text-gray-900">{{ $network->name }}</p>
                                <p class="text-xs text-gray-500">{{ $network->openstack_id }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Security Groups</label>
                <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-4">
                    @foreach($securityGroups as $sg)
                        <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                            <input type="checkbox" name="security_groups[]" value="{{ $sg->id }}" {{ in_array($sg->id, old('security_groups', [])) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                                <p class="font-medium text-gray-900">{{ $sg->name }}</p>
                                <p class="text-xs text-gray-500">{{ $sg->description ?? 'بدون توضیحات' }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">دسترسی</h2>
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">روش دسترسی <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center p-4 border-2 {{ old('access_method', 'ssh_key') == 'ssh_key' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                        <input type="radio" name="access_method" value="ssh_key" {{ old('access_method', 'ssh_key') == 'ssh_key' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                            <p class="font-medium text-gray-900">SSH Key</p>
                            <p class="text-sm text-gray-500">استفاده از کلید SSH</p>
                        </div>
                    </label>
                    <label class="flex items-center p-4 border-2 {{ old('access_method') == 'password' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                        <input type="radio" name="access_method" value="password" {{ old('access_method') == 'password' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                            <p class="font-medium text-gray-900">Password</p>
                            <p class="text-sm text-gray-500">استفاده از رمز عبور</p>
                        </div>
                    </label>
                </div>
            </div>

            <div id="password-fields" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">رمز عبور Root</label>
                        <input type="password" name="root_password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تأیید رمز عبور</label>
                        <input type="password" name="root_password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">تنظیمات پیشرفته</h2>
        
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Region</label>
                    <input type="text" name="region" value="{{ old('region', config('openstack.region', 'RegionOne')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Availability Zone</label>
                    <input type="text" name="availability_zone" value="{{ old('availability_zone') }}" placeholder="nova" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">User Data (Cloud-init)</label>
                <textarea name="user_data" rows="5" placeholder="#cloud-config&#10;write_files:&#10;  - content: |&#10;      Hello World&#10;    path: /tmp/test.txt" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm">{{ old('user_data') }}</textarea>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="config_drive" value="1" {{ old('config_drive') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label class="{{ $isRtl ? 'mr-2' : 'ml-2' }} block text-sm text-gray-700">استفاده از Config Drive</label>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">صورتحساب</h2>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">دوره صورتحساب <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center p-4 border-2 {{ old('billing_cycle', 'hourly') == 'hourly' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                        <input type="radio" name="billing_cycle" value="hourly" {{ old('billing_cycle', 'hourly') == 'hourly' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                            <p class="font-medium text-gray-900">ساعتی</p>
                            <p class="text-sm text-gray-500">پرداخت بر اساس ساعت</p>
                        </div>
                    </label>
                    <label class="flex items-center p-4 border-2 {{ old('billing_cycle') == 'monthly' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                        <input type="radio" name="billing_cycle" value="monthly" {{ old('billing_cycle') == 'monthly' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }}">
                            <p class="font-medium text-gray-900">ماهانه</p>
                            <p class="text-sm text-gray-500">پرداخت بر اساس ماه</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="auto_billing" value="1" {{ old('auto_billing', true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label class="{{ $isRtl ? 'mr-2' : 'ml-2' }} block text-sm text-gray-700">صورتحساب خودکار</label>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('admin.compute.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">
            انصراف
        </a>
        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
            ایجاد Instance
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const accessMethodRadios = document.querySelectorAll('input[name="access_method"]');
    const passwordFields = document.getElementById('password-fields');

    function togglePasswordFields() {
        const selectedMethod = document.querySelector('input[name="access_method"]:checked')?.value;
        if (selectedMethod === 'password') {
            passwordFields.classList.remove('hidden');
            passwordFields.querySelector('input[name="root_password"]').required = true;
            passwordFields.querySelector('input[name="root_password_confirmation"]').required = true;
        } else {
            passwordFields.classList.add('hidden');
            passwordFields.querySelector('input[name="root_password"]').required = false;
            passwordFields.querySelector('input[name="root_password_confirmation"]').required = false;
        }
    }

    accessMethodRadios.forEach(radio => {
        radio.addEventListener('change', togglePasswordFields);
    });

    togglePasswordFields();
});
</script>
@endsection

