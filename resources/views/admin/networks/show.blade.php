@extends('layouts.admin')

@section('title', 'جزئیات شبکه')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
    use Illuminate\Support\Str;
@endphp


@section('content')
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.networks.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    شبکه‌ها
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 mr-1 md:mr-2">{{ $network->name }}</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
    {{ session('error') }}
</div>
@endif

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-lg {{ $network->external ? 'bg-blue-100' : 'bg-purple-100' }} flex items-center justify-center">
            <svg class="w-9 h-9 {{ $network->external ? 'text-blue-600' : 'text-purple-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $network->name }}</h1>
            <p class="mt-1 text-sm text-gray-500">Network ID: {{ Str::limit($network->openstack_id, 30) }}</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        @if($network->status === 'ACTIVE')
        <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            <span class="w-2 h-2 rounded-full bg-green-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}"></span>
            فعال
        </span>
        @else
        <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
            <span class="w-2 h-2 rounded-full bg-red-500 {{ $isRtl ? 'ml-2' : 'mr-2' }}"></span>
            {{ $network->status }}
        </span>
        @endif
        <form method="POST" action="{{ route('admin.networks.destroy', $network->openstack_id) }}" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این شبکه را حذف کنید؟ این عمل غیرقابل بازگشت است.');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg font-medium text-sm transition-colors">
                حذف شبکه
            </button>
        </form>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Network Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">جزئیات شبکه</h2>
            <form method="POST" action="{{ route('admin.networks.update', $network->openstack_id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نام شبکه</label>
                    <input type="text" name="name" value="{{ $network->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $network->description }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نوع شبکه</label>
                    <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="public" {{ $network->external ? 'selected' : '' }}>عمومی</option>
                        <option value="private" {{ !$network->external ? 'selected' : '' }}>خصوصی</option>
                    </select>
                </div>
                @php
                    // Use the relationship if loaded, otherwise get it
                    $networkSubnets = $network->relationLoaded('subnets') ? $network->getRelation('subnets') : $network->subnets()->get();
                @endphp
                @if($networkSubnets->isNotEmpty())
                @foreach($networkSubnets as $subnet)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CIDR</label>
                        <input type="text" value="{{ $subnet->cidr ?? 'N/A' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                        <p class="mt-1 text-xs text-gray-500">CIDR قابل تغییر نیست</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gateway IP</label>
                        <input type="text" name="gateway_ip" value="{{ $subnet->gateway_ip }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                @endforeach
                @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-800">این شبکه Subnet ندارد</p>
                </div>
                @endif
                @if($networkSubnets->isNotEmpty())
                @foreach($networkSubnets as $subnet)
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="enable_dhcp" value="1" {{ $subnet->enable_dhcp ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="mr-2 block text-sm text-gray-700">فعال‌سازی DHCP</span>
                    </label>
                </div>
                @endforeach
                @endif
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.networks.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        انصراف
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        ذخیره تغییرات
                    </button>
                </div>
            </form>
        </div>

        <!-- Connected Instances Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Instance های متصل</h2>
            <div class="overflow-x-auto">
                @php
                    // Use the relationship if loaded, otherwise get it
                    $networkInstances = $network->relationLoaded('instances') ? $network->getRelation('instances') : $network->instances()->get();
                @endphp
                @if($networkInstances->isNotEmpty())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">نام Instance</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">IP Address</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">وضعیت</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($networkInstances as $instance)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $instance->name ?? 'Unnamed' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $instance->pivot->fixed_ip ?? 'N/A' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($instance->status === 'ACTIVE')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $instance->status }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.compute.show', $instance->openstack_id) }}" class="text-blue-600 hover:text-blue-900">مشاهده</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center py-8 text-gray-500">
                    <p>هیچ Instance ای به این شبکه متصل نیست</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات سریع</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Network ID</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">{{ Str::limit($network->openstack_id, 15) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">OpenStack ID</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">{{ Str::limit($network->openstack_id, 15) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">تاریخ ایجاد</span>
                    <span class="font-medium text-gray-900">{{ $network->created_at->format('Y/m/d') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">آخرین به‌روزرسانی</span>
                    <span class="font-medium text-gray-900">{{ $network->synced_at ? $network->synced_at->format('Y/m/d H:i') : 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">وضعیت</span>
                    @if($network->status === 'ACTIVE')
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
                    @else
                    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">{{ $network->status }}</span>
                    @endif
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">منطقه</span>
                    <span class="font-medium text-gray-900">{{ $network->region }}</span>
                </div>
                @if($network->shared)
                <div class="flex justify-between">
                    <span class="text-gray-500">اشتراکی</span>
                    <span class="font-medium text-gray-900">بله</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">آمار</h2>
            <div class="space-y-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">{{ $networkInstances->count() }}</p>
                    <p class="text-sm text-gray-500 mt-1">Instance های متصل</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">{{ $networkSubnets->count() }}</p>
                    <p class="text-sm text-gray-500 mt-1">Subnet ها</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection




