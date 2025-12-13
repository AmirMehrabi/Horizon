@extends('layouts.admin')

@section('title', 'جزئیات پروژه')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Breadcrumb -->
<nav class="mb-6 flex items-center space-x-2 text-sm text-gray-500">
    <a href="{{ route('admin.projects.index') }}" class="hover:text-gray-700">پروژه‌ها</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
    </svg>
    <span class="text-gray-900">{{ $project->name }}</span>
</nav>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
    {{ session('success') }}
</div>
@endif

<!-- Header -->
<div class="mb-6 md:mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $project->name }}</h1>
            <p class="mt-1 text-sm text-gray-500">{{ $project->description ?: 'بدون توضیحات' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.projects.edit', $project->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                ویرایش
            </a>
            @if(!$project->isSynced())
                <form action="{{ route('admin.projects.sync', $project->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        همگام‌سازی
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Project Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات پروژه</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">نام پروژه</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $project->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">مشتری</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $project->customer->company_name ?: $project->customer->full_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">وضعیت</dt>
                    <dd class="mt-1">
                        @php
                            $statusColors = [
                                'active' => 'bg-green-100 text-green-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'suspended' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ \App\Models\Project::getStatuses()[$project->status] ?? $project->status }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">وضعیت همگام‌سازی</dt>
                    <dd class="mt-1">
                        @php
                            $syncColors = [
                                'synced' => 'bg-green-100 text-green-800',
                                'syncing' => 'bg-blue-100 text-blue-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'error' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $syncColors[$project->sync_status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ \App\Models\Project::getSyncStatuses()[$project->sync_status] ?? $project->sync_status }}
                        </span>
                    </dd>
                </div>
                @if($project->openstack_project_id)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">OpenStack Project ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $project->openstack_project_id }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">منطقه</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $project->region }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">تاریخ ایجاد</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $project->created_at->format('Y/m/d H:i') }}</dd>
                </div>
                @if($project->synced_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">آخرین همگام‌سازی</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $project->synced_at->format('Y/m/d H:i') }}</dd>
                    </div>
                @endif
            </dl>
            @if($project->description)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <dt class="text-sm font-medium text-gray-500 mb-2">توضیحات</dt>
                    <dd class="text-sm text-gray-900">{{ $project->description }}</dd>
                </div>
            @endif
        </div>

        <!-- Resource Usage -->
        @if($project->quota)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">استفاده از منابع</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">vCPU</span>
                            <span class="text-sm font-bold text-gray-900">{{ $resourceUsage['cores']['used'] }} / {{ $resourceUsage['cores']['total'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full transition-all" style="width: {{ min($resourceUsage['cores']['percentage'], 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ number_format($resourceUsage['cores']['percentage'], 1) }}% استفاده شده</p>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">RAM</span>
                            <span class="text-sm font-bold text-gray-900">{{ $resourceUsage['ram']['used_gb'] }} / {{ $resourceUsage['ram']['total_gb'] }} GB</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-purple-600 h-3 rounded-full transition-all" style="width: {{ min($resourceUsage['ram']['percentage'], 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ number_format($resourceUsage['ram']['percentage'], 1) }}% استفاده شده</p>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">ذخیره‌سازی</span>
                            <span class="text-sm font-bold text-gray-900">{{ $resourceUsage['gigabytes']['used'] }} / {{ $resourceUsage['gigabytes']['total'] }} GB</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-orange-600 h-3 rounded-full transition-all" style="width: {{ min($resourceUsage['gigabytes']['percentage'], 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ number_format($resourceUsage['gigabytes']['percentage'], 1) }}% استفاده شده</p>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Instance ها</span>
                            <span class="text-sm font-bold text-gray-900">{{ $resourceUsage['instances']['used'] }} / {{ $resourceUsage['instances']['total'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-600 h-3 rounded-full transition-all" style="width: {{ min($resourceUsage['instances']['percentage'], 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ number_format($resourceUsage['instances']['percentage'], 1) }}% استفاده شده</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">عملیات سریع</h2>
            <div class="space-y-2">
                <a href="{{ route('admin.projects.edit', $project->id) }}" class="block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                    ویرایش پروژه
                </a>
                <button onclick="openQuotaModal()" class="block w-full text-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium">
                    مدیریت سهمیه
                </button>
                <button onclick="openUsersModal()" class="block w-full text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                    مدیریت کاربران
                </button>
                @if(!$project->isSynced())
                    <form action="{{ route('admin.projects.sync', $project->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium">
                            همگام‌سازی با OpenStack
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Quota Summary -->
        @if($project->quota)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">سهمیه</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Instance ها</dt>
                        <dd class="font-medium text-gray-900">{{ $project->quota->instances }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">vCPU</dt>
                        <dd class="font-medium text-gray-900">{{ $project->quota->cores }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">RAM</dt>
                        <dd class="font-medium text-gray-900">{{ number_format($project->quota->ram / 1024, 0) }} GB</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">ذخیره‌سازی</dt>
                        <dd class="font-medium text-gray-900">{{ $project->quota->gigabytes }} GB</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Floating IP</dt>
                        <dd class="font-medium text-gray-900">{{ $project->quota->floating_ips }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Network ها</dt>
                        <dd class="font-medium text-gray-900">{{ $project->quota->networks }}</dd>
                    </div>
                </dl>
            </div>
        @endif

        <!-- Users -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">کاربران</h2>
                <span class="text-sm text-gray-500">{{ $project->users->count() }} کاربر</span>
            </div>
            @if($project->users->count() > 0)
                <div class="space-y-2">
                    @foreach($project->users->take(5) as $user)
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-medium">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->pivot->role }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($project->users->count() > 5)
                        <button onclick="openUsersModal()" class="text-xs text-blue-600 hover:text-blue-800">
                            مشاهده همه کاربران
                        </button>
                    @endif
                </div>
            @else
                <p class="text-sm text-gray-500">هیچ کاربری اختصاص داده نشده است</p>
                <button onclick="openUsersModal()" class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                    افزودن کاربر
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Quota Modal -->
<div id="quotaModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[80vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">تخصیص سهمیه</h3>
            <button onclick="closeQuotaModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.projects.quota.update', $project->id) }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">vCPU</label>
                    <input type="number" name="cores" value="{{ $project->quota->cores ?? 100 }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">RAM (MB)</label>
                    <input type="number" name="ram" value="{{ $project->quota->ram ?? 204800 }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Instance ها</label>
                    <input type="number" name="instances" value="{{ $project->quota->instances ?? 20 }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ذخیره‌سازی (GB)</label>
                    <input type="number" name="gigabytes" value="{{ $project->quota->gigabytes ?? 2048 }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Floating IP</label>
                    <input type="number" name="floating_ips" value="{{ $project->quota->floating_ips ?? 50 }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Network ها</label>
                    <input type="number" name="networks" value="{{ $project->quota->networks ?? 10 }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Router ها</label>
                    <input type="number" name="routers" value="{{ $project->quota->routers ?? 5 }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Volume ها</label>
                    <input type="number" name="volumes" value="{{ $project->quota->volumes ?? 50 }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" required>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeQuotaModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    ذخیره سهمیه
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openQuotaModal() {
    document.getElementById('quotaModal').classList.remove('hidden');
}
function closeQuotaModal() {
    document.getElementById('quotaModal').classList.add('hidden');
}
function openUsersModal() {
    // TODO: Implement users modal
    alert('مدیریت کاربران به زودی اضافه خواهد شد');
}
</script>
@endsection

