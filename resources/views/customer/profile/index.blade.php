@extends('layouts.customer')

@section('title', 'پروفایل و امنیت')

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
                'label' => 'پروفایل',
                'active' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>'
            ]
        ]
    ])
@endsection

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-sm font-medium text-red-900">{{ session('error') }}</p>
    </div>
</div>
@endif

@if($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
    <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <p class="text-sm font-medium text-red-900 mb-2">خطاهای اعتبارسنجی:</p>
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">پروفایل و امنیت</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت اطلاعات شخصی و تنظیمات امنیتی</p>
</div>

<!-- Tabs Navigation -->
<div class="border-b border-gray-200 mb-6">
    <nav class="-mb-px flex space-x-8 {{ $isRtl ? 'space-x-reverse' : '' }}" aria-label="Tabs">
        <button onclick="showTab('profile')" id="tab-profile" class="tab-button border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            ویرایش پروفایل
        </button>
        <button onclick="showTab('password')" id="tab-password" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            تغییر رمز عبور
        </button>
        <button onclick="showTab('api-keys')" id="tab-api-keys" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            کلیدهای API
        </button>
        <button onclick="showTab('activity')" id="tab-activity" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            لاگ فعالیت‌ها
        </button>
    </nav>
</div>

<!-- Profile Tab -->
<div id="content-profile" class="tab-content">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">اطلاعات شخصی</h2>
        
        <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">نام</label>
                    <input type="text" id="first_name" name="first_name" value="{{ $user['first_name'] }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                
                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">نام خانوادگی</label>
                    <input type="text" id="last_name" name="last_name" value="{{ $user['last_name'] }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">ایمیل</label>
                    <input type="email" id="email" name="email" value="{{ $user['email'] }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">شماره تماس</label>
                    <input type="tel" id="phone" name="phone" value="{{ $user['phone'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror" required>
                    @error('phone')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- National ID -->
                <div>
                    <label for="national_id" class="block text-sm font-medium text-gray-700 mb-2">کد ملی</label>
                    <input type="text" id="national_id" name="national_id" value="{{ $user['national_id'] }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <!-- Company -->
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-2">شرکت</label>
                    <input type="text" id="company" name="company" value="{{ $user['company'] }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">آدرس</label>
                <textarea id="address" name="address" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">{{ $user['address'] }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">شهر</label>
                    <input type="text" id="city" name="city" value="{{ $user['city'] }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <!-- Postal Code -->
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">کد پستی</label>
                    <input type="text" id="postal_code" name="postal_code" value="{{ $user['postal_code'] }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <!-- Country -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">کشور</label>
                    <input type="text" id="country" name="country" value="{{ $user['country'] }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    ذخیره تغییرات
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Change Password Tab -->
<div id="content-password" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">تغییر رمز عبور</h2>
        
        <form method="POST" action="{{ route('customer.profile.change-password.update') }}" class="space-y-6 max-w-md">
            @csrf
            
            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">رمز عبور فعلی</label>
                <input type="password" id="current_password" name="current_password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <!-- New Password -->
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">رمز عبور جدید</label>
                <input type="password" id="new_password" name="new_password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                <p class="mt-1 text-xs text-gray-500">حداقل ۸ کاراکتر، شامل حروف بزرگ، کوچک و اعداد</p>
            </div>
            
            <!-- Confirm Password -->
            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">تکرار رمز عبور جدید</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    تغییر رمز عبور
                </button>
            </div>
        </form>
    </div>
</div>

<!-- API Keys Tab -->
<div id="content-api-keys" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">کلیدهای API</h2>
            <button onclick="showCreateApiKeyModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                ایجاد کلید جدید
            </button>
        </div>
        
        @if(session('api_key_created'))
        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium text-yellow-900">کلید API جدید ایجاد شد</p>
                    <p class="text-xs text-yellow-700 mt-1">لطفاً این کلید را کپی و در جای امنی ذخیره کنید. این کلید دیگر نمایش داده نخواهد شد.</p>
                    <div class="mt-3 bg-white rounded p-3 font-mono text-sm border border-yellow-300">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-900 break-all">{{ session('api_key_created') }}</span>
                            <button onclick="copyApiKey('{{ session('api_key_created') }}')" class="ml-3 text-blue-600 hover:text-blue-700 text-xs whitespace-nowrap">
                                کپی
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="space-y-4">
            @forelse($apiKeys as $apiKey)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-sm font-semibold text-gray-900">{{ $apiKey['name'] }}</h3>
                            @if(in_array('write', $apiKey['permissions']))
                            <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded">خواندن/نوشتن</span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">فقط خواندن</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                            <span>ایجاد شده: {{ $apiKey['created_at'] }}</span>
                            <span>آخرین استفاده: {{ $apiKey['last_used'] }}</span>
                        </div>
                        <div class="bg-gray-50 rounded p-3 font-mono text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">{{ $apiKey['key'] }}</span>
                                <button onclick="copyApiKey('{{ $apiKey['key'] }}')" class="text-blue-600 hover:text-blue-700 text-xs">
                                    کپی
                                </button>
                            </div>
                        </div>
                    </div>
                    <button onclick="deleteApiKey('{{ $apiKey['id'] }}')" class="ml-4 text-red-600 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
                <p class="text-sm">هیچ کلید API ایجاد نشده است</p>
            </div>
            @endforelse
        </div>
        
        @if(count($apiKeys) > 0)
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-700">
                <svg class="w-4 h-4 inline {{ $isRtl ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                کلیدهای API برای دسترسی برنامه‌نویسان به API استفاده می‌شوند. هرگز کلید خود را با دیگران به اشتراک نگذارید.
            </p>
        </div>
        @endif
    </div>
</div>

<!-- Activity Logs Tab -->
<div id="content-activity" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">لاگ فعالیت‌های حساب</h2>
            <p class="text-sm text-gray-500 mt-1">تاریخچه تمام فعالیت‌های انجام شده در حساب شما</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">زمان</th>
                        <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                        <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">IP</th>
                        <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">مکان</th>
                        <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">دستگاه</th>
                        <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activityLogs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log['timestamp'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $log['action'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log['ip'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $log['location'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $log['device'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $log['status'] === 'موفق' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $log['status'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                            هیچ فعالیتی ثبت نشده است
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create API Key Modal -->
<div id="createApiKeyModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">ایجاد کلید API جدید</h3>
        </div>
        <form method="POST" action="{{ route('customer.profile.api-keys.create') }}" class="px-6 py-4">
            @csrf
            <div class="mb-4">
                <label for="api_key_name" class="block text-sm font-medium text-gray-700 mb-2">نام کلید</label>
                <input type="text" id="api_key_name" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="مثال: کلید API اصلی" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">دسترسی‌ها</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="read" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">خواندن</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="write" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">نوشتن</span>
                    </label>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeCreateApiKeyModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                    ایجاد
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Tab switching
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active state from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('border-blue-500', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active state to selected button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-gray-500');
    activeButton.classList.add('border-blue-500', 'text-blue-600');
}

// Handle hash fragment on page load
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash.replace('#', '');
    if (hash) {
        // Map hash to tab name
        const tabMap = {
            'api-keys': 'api-keys',
            'password': 'password',
            'activity': 'activity',
            'profile': 'profile'
        };
        
        if (tabMap[hash]) {
            showTab(tabMap[hash]);
        }
    }
});

// API Key functions
function showCreateApiKeyModal() {
    document.getElementById('createApiKeyModal').classList.remove('hidden');
}

function closeCreateApiKeyModal() {
    document.getElementById('createApiKeyModal').classList.add('hidden');
}

function copyApiKey(key) {
    navigator.clipboard.writeText(key).then(() => {
        alert('کلید API کپی شد');
    });
}

function deleteApiKey(id) {
    if (confirm('آیا از حذف این کلید API اطمینان دارید؟')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("customer.profile.api-keys.delete", ":id") }}'.replace(':id', id);
        form.innerHTML = '@csrf @method("DELETE")';
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal when clicking outside
document.getElementById('createApiKeyModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateApiKeyModal();
    }
});
</script>
@endsection
