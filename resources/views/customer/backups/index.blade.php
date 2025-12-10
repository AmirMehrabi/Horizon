@extends('layouts.customer')

@section('title', 'بکاپ‌ها و Snapshotها')

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
                'label' => 'بکاپ‌ها',
                'active' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>'
            ]
        ]
    ])
@endsection

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">بکاپ‌ها و Snapshotها</h1>
        <p class="mt-1 text-sm text-gray-500">مدیریت پشتیبان‌گیری و بازگردانی</p>
    </div>
    <div>
        <a href="{{ route('customer.backups.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            ایجاد Snapshot جدید
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Main Content: Snapshots -->
    <div class="lg:col-span-2">
        <!-- Current Snapshots -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Snapshotهای فعلی</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">نام Snapshot</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ ایجاد</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">حجم</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($snapshots as $snapshot)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $snapshot['name'] }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $snapshot['server_name'] }}</div>
                                @if(!empty($snapshot['description']))
                                <div class="text-xs text-gray-400 mt-1">{{ $snapshot['description'] }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $snapshot['created_at'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $snapshot['size'] }} {{ $snapshot['size_unit'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($snapshot['status'] === 'completed') bg-green-100 text-green-800
                                    @elseif($snapshot['status'] === 'creating') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $snapshot['status_label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    @if($snapshot['status'] === 'completed')
                                    <a href="{{ route('customer.backups.restore.show', $snapshot['id']) }}" class="text-blue-600 hover:text-blue-700">
                                        بازگردانی
                                    </a>
                                    <span class="text-gray-300">|</span>
                                    @endif
                                    <form method="POST" action="{{ route('customer.backups.destroy', $snapshot['id']) }}" class="inline" onsubmit="return confirm('آیا از حذف این Snapshot اطمینان دارید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Sidebar: Automated Backups -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-24">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">پشتیبان‌گیری خودکار</h3>
            
            <form method="POST" action="{{ route('customer.backups.settings.update') }}" class="space-y-4">
                @csrf
                
                <!-- Enable/Disable Toggle -->
                <div class="flex items-center justify-between">
                    <label class="text-sm font-medium text-gray-700">فعال / غیرفعال</label>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="enabled" value="1" {{ $backupSettings['enabled'] ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                
                <!-- Schedule -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">برنامه زمانی</label>
                    <select name="schedule" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="hourly" {{ $backupSettings['schedule'] === 'hourly' ? 'selected' : '' }}>ساعتی</option>
                        <option value="daily" {{ $backupSettings['schedule'] === 'daily' ? 'selected' : '' }}>روزانه</option>
                        <option value="weekly" {{ $backupSettings['schedule'] === 'weekly' ? 'selected' : '' }}>هفتگی</option>
                        <option value="monthly" {{ $backupSettings['schedule'] === 'monthly' ? 'selected' : '' }}>ماهانه</option>
                    </select>
                </div>
                
                <!-- Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">زمان</label>
                    <input type="time" name="time" value="{{ $backupSettings['time'] }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <!-- Retention Policy -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">سیاست نگهداری (روز)</label>
                    <input type="number" name="retention_days" value="{{ $backupSettings['retention_days'] }}" min="1" max="365" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-gray-500">پشتیبان‌های قدیمی‌تر از این تعداد روز حذف می‌شوند</p>
                </div>
                
                <!-- Last Backup Summary -->
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500 mb-2">آخرین پشتیبان‌گیری</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-900">{{ $backupSettings['last_backup'] }}</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                            موفق
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">پشتیبان‌گیری بعدی: {{ $backupSettings['next_backup'] }}</p>
                </div>
                
                <!-- Save Button -->
                <button type="submit" class="w-full mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    ذخیره تنظیمات
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
