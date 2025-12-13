@extends('layouts.customer')

@section('title', 'ایجاد شبکه جدید')

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
                'label' => 'شبکه‌های من',
                'url' => route('customer.networks.index'),
            ],
            [
                'label' => 'ایجاد شبکه جدید',
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">ایجاد شبکه خصوصی جدید</h1>
        <p class="mt-1 text-sm text-gray-500">شبکه خصوصی برای اتصال سرورهای خود ایجاد کنید</p>
    </div>

    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('customer.networks.store') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">نام شبکه <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="my-private-network">
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">توضیحات (اختیاری)</label>
                <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="توضیحات شبکه...">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="cidr" class="block text-sm font-medium text-gray-700 mb-2">CIDR Block (اختیاری)</label>
                <select id="cidr" name="cidr" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="handleCidrChange(this)">
                    <option value="">انتخاب CIDR</option>
                    <option value="192.168.0.0/24" {{ old('cidr') === '192.168.0.0/24' ? 'selected' : '' }}>۱۹۲.۱۶۸.۰.۰/۲۴ (۲۵۶ آدرس)</option>
                    <option value="10.0.0.0/16" {{ old('cidr') === '10.0.0.0/16' ? 'selected' : '' }}>۱۰.۰.۰.۰/۱۶ (۶۵۵۳۶ آدرس)</option>
                    <option value="172.16.0.0/16" {{ old('cidr') === '172.16.0.0/16' ? 'selected' : '' }}>۱۷۲.۱۶.۰.۰/۱۶ (۶۵۵۳۶ آدرس)</option>
                    <option value="custom">سفارشی</option>
                </select>
                <input type="text" id="custom-cidr" name="custom_cidr" value="{{ old('custom_cidr') }}" class="hidden w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="مثال: 10.0.1.0/24">
                <p class="mt-1 text-xs text-gray-500">CIDR block برای تعیین محدوده IP شبکه</p>
                @error('cidr')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="gateway_ip" class="block text-sm font-medium text-gray-700 mb-2">Gateway IP (اختیاری)</label>
                <input type="text" id="gateway_ip" name="gateway_ip" value="{{ old('gateway_ip') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="10.0.0.1">
                <p class="mt-1 text-xs text-gray-500">آدرس IP gateway برای این شبکه</p>
                @error('gateway_ip')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="enable_dhcp" value="1" {{ old('enable_dhcp', true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} block text-sm text-gray-700">فعال‌سازی DHCP</span>
                </label>
                <p class="mt-1 text-xs text-gray-500">فعال‌سازی DHCP برای تخصیص خودکار IP</p>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('customer.networks.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    انصراف
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    ایجاد شبکه
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function handleCidrChange(select) {
    const customCidrInput = document.getElementById('custom-cidr');
    if (select.value === 'custom') {
        customCidrInput.classList.remove('hidden');
        customCidrInput.required = true;
    } else {
        customCidrInput.classList.add('hidden');
        customCidrInput.required = false;
        customCidrInput.value = '';
    }
}

// Handle form submission to use custom CIDR if selected
document.querySelector('form').addEventListener('submit', function(e) {
    const cidrSelect = document.getElementById('cidr');
    const customCidr = document.getElementById('custom-cidr');
    
    if (cidrSelect.value === 'custom' && customCidr.value) {
        // Create a hidden input with the custom CIDR value
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'cidr';
        hiddenInput.value = customCidr.value;
        this.appendChild(hiddenInput);
        
        // Remove the custom_cidr input to avoid confusion
        customCidr.name = '';
    }
});
</script>
@endsection

