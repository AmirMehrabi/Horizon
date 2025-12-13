@extends('layouts.admin')

@section('title', 'مدیریت پروژه‌ها')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Page Header - Mobile First -->
<div class="mb-6 md:mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">مدیریت پروژه‌ها</h1>
        <p class="mt-1 text-sm text-gray-500">ایجاد و مدیریت پروژه‌های OpenStack و تخصیص منابع</p>
    </div>
        <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 md:px-6 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm w-full sm:w-auto">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
            <span>ایجاد پروژه جدید</span>
        </a>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    {{ session('error') }}
</div>
@endif

<!-- Stats Cards - Mobile First Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs md:text-sm text-gray-500 font-medium mb-1 truncate">کل پروژه‌ها</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0 {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs md:text-sm text-gray-500 font-medium mb-1 truncate">پروژه‌های فعال</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ number_format($stats['active']) }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0 {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs md:text-sm text-gray-500 font-medium mb-1 truncate">همگام‌سازی شده</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ number_format($stats['synced']) }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0 {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs md:text-sm text-gray-500 font-medium mb-1 truncate">کل کاربران</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0 {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search - Mobile First -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6 mb-6">
    <form method="GET" action="{{ route('admin.projects.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Search -->
            <div class="md:col-span-2 lg:col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">جستجو</label>
            <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="جستجو بر اساس نام پروژه یا مشتری..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    >
                    <svg class="absolute {{ $isRtl ? 'right-3' : 'left-3' }} top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
            
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">وضعیت</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>در انتظار</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>فعال</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>معلق</option>
                </select>
        </div>
        
        <!-- Sync Status Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">وضعیت همگام‌سازی</label>
                <select name="sync_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                <option value="">همه</option>
                    <option value="synced" {{ request('sync_status') === 'synced' ? 'selected' : '' }}>همگام‌سازی شده</option>
                    <option value="pending" {{ request('sync_status') === 'pending' ? 'selected' : '' }}>در انتظار</option>
                    <option value="syncing" {{ request('sync_status') === 'syncing' ? 'selected' : '' }}>در حال همگام‌سازی</option>
                    <option value="error" {{ request('sync_status') === 'error' ? 'selected' : '' }}>خطا</option>
            </select>
        </div>
        
            <!-- Customer Filter -->
        <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">مشتری</label>
                <select name="customer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">همه مشتریان</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->company_name ?: $customer->full_name }}
                        </option>
                    @endforeach
            </select>
        </div>
    </div>
        
        <div class="flex flex-col sm:flex-row gap-2 sm:justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition-colors">
                اعمال فیلتر
            </button>
            @if(request()->hasAny(['search', 'status', 'sync_status', 'customer_id']))
                <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition-colors text-center">
                    پاک کردن فیلترها
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Projects List - Mobile First -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <!-- Mobile: Card View, Desktop: Table View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-{{ $isRtl ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">پروژه</th>
                    <th class="px-4 md:px-6 py-3 text-{{ $isRtl ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">مشتری</th>
                    <th class="px-4 md:px-6 py-3 text-{{ $isRtl ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">استفاده منابع</th>
                    <th class="px-4 md:px-6 py-3 text-{{ $isRtl ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">کاربران</th>
                    <th class="px-4 md:px-6 py-3 text-{{ $isRtl ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">همگام‌سازی</th>
                    <th class="px-4 md:px-6 py-3 text-{{ $isRtl ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($projects as $project)
                    @php
                        $usage = $project->getResourceUsage();
                    @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }} min-w-0">
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $project->name }}</div>
                                    @if($project->openstack_project_id)
                                        <div class="text-xs text-gray-500 truncate">OS: {{ \Illuminate\Support\Str::limit($project->openstack_project_id, 12) }}</div>
                                    @else
                                        <div class="text-xs text-yellow-600">محلی (همگام‌سازی نشده)</div>
                                    @endif
                            </div>
                        </div>
                    </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 truncate max-w-xs">{{ $project->customer->company_name ?: $project->customer->full_name }}</div>
                            @if($project->customer->email)
                                <div class="text-xs text-gray-500 truncate max-w-xs">{{ $project->customer->email }}</div>
                            @endif
                    </td>
                        <td class="px-4 md:px-6 py-4 hidden lg:table-cell">
                            @if($project->quota)
                                <div class="space-y-1.5 min-w-[200px]">
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500">vCPU</span>
                                            <span class="text-gray-900 font-medium">{{ $usage['cores']['used'] }} / {{ $usage['cores']['total'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-blue-600 h-1.5 rounded-full transition-all" style="width: {{ min($usage['cores']['percentage'], 100) }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500">RAM</span>
                                            <span class="text-gray-900 font-medium">{{ $usage['ram']['used_gb'] }} / {{ $usage['ram']['total_gb'] }} GB</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-purple-600 h-1.5 rounded-full transition-all" style="width: {{ min($usage['ram']['percentage'], 100) }}%"></div>
                                </div>
                            </div>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">سهمیه تنظیم نشده</span>
                            @endif
                    </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap hidden xl:table-cell">
                            <div class="text-sm text-gray-900 font-medium">{{ $project->users_count }} کاربر</div>
                    </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                            @php
                                $syncStatusColors = [
                                    'synced' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'dot' => 'bg-green-500'],
                                    'syncing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'dot' => 'bg-blue-500'],
                                    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dot' => 'bg-yellow-500'],
                                    'error' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'dot' => 'bg-red-500'],
                                ];
                                $syncStatusLabels = [
                                    'synced' => 'همگام‌سازی شده',
                                    'syncing' => 'در حال همگام‌سازی',
                                    'pending' => 'در انتظار',
                                    'error' => 'خطا',
                                ];
                                $colors = $syncStatusColors[$project->sync_status] ?? $syncStatusColors['pending'];
                            @endphp
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colors['bg'] }} {{ $colors['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $colors['dot'] }} {{ $isRtl ? 'ml-1.5' : 'mr-1.5' }}"></span>
                                {{ $syncStatusLabels[$project->sync_status] ?? 'نامشخص' }}
                        </span>
                            @if($project->synced_at)
                                <div class="text-xs text-gray-500 mt-1">{{ $project->synced_at->diffForHumans() }}</div>
                            @endif
                    </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="text-blue-600 hover:text-blue-900" title="مشاهده">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-blue-600 hover:text-blue-900" title="ویرایش">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                </a>
                                @if(!$project->isSynced())
                                    <form action="{{ route('admin.projects.sync', $project->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900" title="همگام‌سازی">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </button>
                                    </form>
                                @endif
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">پروژه‌ای یافت نشد</h3>
                            <p class="mt-1 text-sm text-gray-500">شروع کنید با ایجاد یک پروژه جدید.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    ایجاد پروژه جدید
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Mobile Card View -->
    <div class="md:hidden divide-y divide-gray-200">
        @forelse($projects as $project)
            @php
                $usage = $project->getResourceUsage();
            @endphp
            <div class="p-4">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center flex-1 min-w-0">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            </div>
                        <div class="{{ $isRtl ? 'mr-3' : 'ml-3' }} flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900 truncate">{{ $project->name }}</h3>
                            <p class="text-xs text-gray-500 truncate">{{ $project->customer->company_name ?: $project->customer->full_name }}</p>
                        </div>
                    </div>
                    @php
                        $syncStatusColors = [
                            'synced' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'dot' => 'bg-green-500'],
                            'syncing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'dot' => 'bg-blue-500'],
                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dot' => 'bg-yellow-500'],
                            'error' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'dot' => 'bg-red-500'],
                        ];
                        $syncStatusLabels = [
                            'synced' => 'همگام‌سازی شده',
                            'syncing' => 'در حال همگام‌سازی',
                            'pending' => 'در انتظار',
                            'error' => 'خطا',
                        ];
                        $colors = $syncStatusColors[$project->sync_status] ?? $syncStatusColors['pending'];
                    @endphp
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $colors['bg'] }} {{ $colors['text'] }} flex-shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full {{ $colors['dot'] }} inline-block {{ $isRtl ? 'ml-1' : 'mr-1' }}"></span>
                        {{ $syncStatusLabels[$project->sync_status] ?? 'نامشخص' }}
                    </span>
                </div>
                
                @if($project->quota)
                    <div class="space-y-2 mb-3">
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500">vCPU</span>
                                <span class="text-gray-900 font-medium">{{ $usage['cores']['used'] }} / {{ $usage['cores']['total'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min($usage['cores']['percentage'], 100) }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500">RAM</span>
                                <span class="text-gray-900 font-medium">{{ $usage['ram']['used_gb'] }} / {{ $usage['ram']['total_gb'] }} GB</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ min($usage['ram']['percentage'], 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                    <div class="text-xs text-gray-500">{{ $project->users_count }} کاربر</div>
                        <div class="flex items-center gap-2">
                        <a href="{{ route('admin.projects.show', $project->id) }}" class="text-blue-600 hover:text-blue-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                        </a>
                        @if(!$project->isSynced())
                            <form action="{{ route('admin.projects.sync', $project->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">پروژه‌ای یافت نشد</h3>
                <p class="mt-1 text-sm text-gray-500">شروع کنید با ایجاد یک پروژه جدید.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        ایجاد پروژه جدید
                    </a>
                </div>
                        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if($projects->hasPages())
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
                @if($projects->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white cursor-not-allowed">
                        قبلی
                    </span>
                @else
                    <a href="{{ $projects->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                قبلی
            </a>
                @endif
                
                @if($projects->hasMorePages())
                    <a href="{{ $projects->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                بعدی
            </a>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white cursor-not-allowed">
                        بعدی
                    </span>
                @endif
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    نمایش
                        <span class="font-medium">{{ $projects->firstItem() }}</span>
                    تا
                        <span class="font-medium">{{ $projects->lastItem() }}</span>
                    از
                        <span class="font-medium">{{ $projects->total() }}</span>
                    نتیجه
                </p>
            </div>
            <div>
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
