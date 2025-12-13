@extends('layouts.customer')

@section('title', 'شبکه‌های من')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
    use Illuminate\Support\Str;
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
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
<!-- Page Header -->
<div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
    <h1 class="text-3xl font-bold text-gray-900">شبکه‌های من</h1>
                <p class="mt-1 text-sm text-gray-500">مدیریت شبکه‌های خصوصی، گروه‌های امنیتی و IP های شناور</p>
            </div>
        </div>
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

@if(isset($error))
<div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
    {{ $error }}
</div>
@endif

    <!-- Network Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Private Networks -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">شبکه‌های خصوصی</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $statistics['private_networks'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Security Groups -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">گروه‌های امنیتی</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $statistics['security_groups'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Floating IPs -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">IP های شناور</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $statistics['floating_ips'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Bandwidth Usage -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                    <p class="text-sm font-medium text-gray-500">مصرف پهنای باند</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format(($statistics['bandwidth_usage'] ?? 0) / 1024, 1) }} GB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Network Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="switchTab('networks')" id="networks-tab" class="tab-button active border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    شبکه‌های خصوصی
                </button>
                <button onclick="switchTab('security-groups')" id="security-groups-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    گروه‌های امنیتی
                </button>
                <button onclick="switchTab('floating-ips')" id="floating-ips-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    IP های شناور
                </button>
                <button onclick="switchTab('bandwidth')" id="bandwidth-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    مصرف پهنای باند
                </button>
            </nav>
        </div>

        <!-- Private Networks Tab -->
        <div id="networks-content" class="tab-content p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">شبکه‌های خصوصی</h2>
                <a href="{{ route('customer.networks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    ایجاد شبکه جدید
                </a>
            </div>

            @if($customerNetworks->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">هیچ شبکه‌ای وجود ندارد</h3>
                <p class="mt-1 text-sm text-gray-500">شبکه خصوصی جدیدی ایجاد کنید</p>
                <div class="mt-6">
                    <a href="{{ route('customer.networks.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        ایجاد شبکه جدید
                    </a>
                </div>
            </div>
            @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($customerNetworks as $network)
                @php
                    $networkSubnets = $network->relationLoaded('subnets') ? $network->getRelation('subnets') : $network->subnets()->get();
                    $networkInstances = $network->relationLoaded('instances') ? $network->getRelation('instances') : $network->instances()->get();
                @endphp
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $network->name }}</h3>
                                <p class="text-sm text-gray-500">
                                    @if($networkSubnets->isNotEmpty())
                                        {{ $networkSubnets->first()->cidr ?? 'N/A' }}
                                    @else
                                        بدون Subnet
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="relative">
                            <button onclick="toggleNetworkMenu('network-{{ $network->id }}')" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </button>
                            <div id="network-{{ $network->id }}-menu" class="hidden absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                <a href="{{ route('customer.networks.show', $network->openstack_id) }}" class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">مشاهده جزئیات</a>
                                <div class="border-t border-gray-200 my-1"></div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">وضعیت:</span>
                            @if($network->status === 'ACTIVE')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                فعال
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $network->status }}
                            </span>
                            @endif
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">سرورهای متصل:</span>
                            <span class="font-medium text-gray-900">{{ $networkInstances->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">زیرشبکه‌ها:</span>
                            <span class="font-medium text-gray-900">{{ $networkSubnets->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">ایجاد شده:</span>
                            <span class="text-gray-500">{{ $network->created_at->format('Y/m/d') }}</span>
                        </div>

                        <!-- Connected Servers -->
                        @if($networkInstances->isNotEmpty())
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-2">سرورهای متصل:</p>
                            <div class="space-y-1">
                                @foreach($networkInstances->take(3) as $instance)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">{{ $instance->name ?? 'Unnamed' }}</span>
                                    <span class="text-gray-500">{{ $instance->pivot->fixed_ip ?? 'N/A' }}</span>
                                </div>
                                @endforeach
                                @if($networkInstances->count() > 3)
                                <div class="text-xs text-gray-500 text-center pt-1">
                                    و {{ $networkInstances->count() - 3 }} سرور دیگر...
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Security Groups Tab -->
        <div id="security-groups-content" class="tab-content p-6 hidden">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">گروه‌های امنیتی</h2>
                <a href="{{ route('customer.networks.security-groups') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    مدیریت گروه‌های امنیتی
                </a>
            </div>

            @if($securityGroups->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">هیچ گروه امنیتی وجود ندارد</h3>
                <p class="mt-1 text-sm text-gray-500">گروه امنیتی جدیدی ایجاد کنید</p>
            </div>
            @else
            <div class="space-y-6">
                @foreach($securityGroups as $sg)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $sg->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $sg->description ?? 'بدون توضیحات' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @php
                                $sgInstances = $sg->instances()->get();
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $sgInstances->count() }} سرور
                            </span>
                        </div>
                    </div>

                    <!-- Rules Table -->
                    @if(!empty($sg->rules) && is_array($sg->rules))
                    <div class="overflow-x-auto w-full">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">نوع</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">پروتکل</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">پورت</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">منبع</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sg->rules as $rule)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $rule['direction'] === 'ingress' ? 'ورودی' : 'خروجی' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ strtoupper($rule['protocol'] ?? 'TCP') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">
                                        @if(isset($rule['port_range_min']) && isset($rule['port_range_max']))
                                            @if($rule['port_range_min'] === $rule['port_range_max'])
                                                {{ $rule['port_range_min'] }}
                                            @else
                                                {{ $rule['port_range_min'] }}-{{ $rule['port_range_max'] }}
                                            @endif
                                        @else
                                            همه
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $rule['remote_ip_prefix'] ?? '0.0.0.0/0' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4 text-gray-500 text-sm">
                        هیچ قانونی تعریف نشده است
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Floating IPs Tab -->
        <div id="floating-ips-content" class="tab-content p-6 hidden">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">IP های شناور</h2>
                <a href="{{ route('customer.networks.floating-ips') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    مدیریت IP های شناور
                </a>
            </div>

            @if($floatingIps->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">هیچ IP شناوری وجود ندارد</h3>
                <p class="mt-1 text-sm text-gray-500">IP شناور جدیدی تخصیص دهید</p>
            </div>
            @else
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto w-full">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">آدرس IP</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">متصل به</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ تخصیص</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($floatingIps as $fip)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">{{ $fip['ip'] }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        متصل
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $fip['instance']->name ?? 'Unnamed' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fip['instance']->created_at->format('Y/m/d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Bandwidth Usage Tab -->
        <div id="bandwidth-content" class="tab-content p-6 hidden">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">مصرف پهنای باند</h2>
            
            <!-- Bandwidth Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500">ترافیک ورودی</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format(($statistics['bandwidth_usage'] ?? 0) / 2048, 1) }} GB</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500">ترافیک خروجی</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format(($statistics['bandwidth_usage'] ?? 0) / 2048, 1) }} GB</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="{{ $isRtl ? 'mr-4' : 'ml-4' }}">
                            <p class="text-sm font-medium text-gray-500">کل مصرف</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format(($statistics['bandwidth_usage'] ?? 0) / 1024, 1) }} GB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bandwidth Chart Placeholder -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">نمودار مصرف پهنای باند (۳۰ روز گذشته)</h3>
                <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                    <p class="text-gray-500">نمودار مصرف پهنای باند</p>
                </div>
            </div>

            <!-- Per-Server Bandwidth -->
            @if($instances->isNotEmpty())
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">مصرف پهنای باند به تفکیک سرور</h3>
                </div>
                <div class="overflow-x-auto w-full">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">سرور</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ترافیک ورودی</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ترافیک خروجی</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">کل مصرف</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($instances as $instance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $instance->name ?? 'Unnamed' }}</div>
                                            @php
                                                $primaryNetwork = $instance->networks()->wherePivot('is_primary', true)->first();
                                                $primaryIp = $primaryNetwork ? $primaryNetwork->pivot->fixed_ip : 'N/A';
                                            @endphp
                                            <div class="text-sm text-gray-500">{{ $primaryIp }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">-</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">-</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">-</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// Tab switching
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.add('active', 'border-blue-500', 'text-blue-600');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
}

// Network menu toggle
function toggleNetworkMenu(networkId) {
    const menu = document.getElementById(networkId + '-menu');
    const allMenus = document.querySelectorAll('[id$="-menu"]');
    
    // Close all other menus
    allMenus.forEach(m => {
        if (m.id !== networkId + '-menu') {
            m.classList.add('hidden');
        }
    });
    
    // Toggle current menu
    menu.classList.toggle('hidden');
}

// Close menus when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick*="toggleNetworkMenu"]') && !event.target.closest('[id$="-menu"]')) {
        document.querySelectorAll('[id$="-menu"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>

<style>
.tab-button.active {
    border-bottom-color: #3b82f6;
    color: #3b82f6;
}
</style>
@endsection
