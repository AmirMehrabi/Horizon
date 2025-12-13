@extends('layouts.customer')

@section('title', 'جزئیات شبکه')

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
                'url' => route('customer.networks.index'),
            ],
            [
                'label' => $network->name,
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
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
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-9 h-9 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
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
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Network Details Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">جزئیات شبکه</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">نام شبکه</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $network->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">وضعیت</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">
                                @if($network->status === 'ACTIVE')
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">فعال</span>
                                @else
                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">{{ $network->status }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    @if($network->description)
                    <div>
                        <p class="text-sm text-gray-500">توضیحات</p>
                        <p class="text-sm text-gray-900 mt-1">{{ $network->description }}</p>
                    </div>
                    @endif

                    <div>
                        <p class="text-sm text-gray-500">نوع شبکه</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">
                            @if($network->external)
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">عمومی</span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">خصوصی</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Subnets Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">زیرشبکه‌ها</h2>
                @php
                    $networkSubnets = $network->relationLoaded('subnets') ? $network->getRelation('subnets') : $network->subnets()->get();
                @endphp
                @if($networkSubnets->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <p>این شبکه Subnet ندارد</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($networkSubnets as $subnet)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-medium text-gray-900">{{ $subnet->name }}</h3>
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">IPv{{ $subnet->ip_version }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">CIDR</p>
                                <p class="font-medium text-gray-900">{{ $subnet->cidr ?? 'N/A' }}</p>
                            </div>
                            @if($subnet->gateway_ip)
                            <div>
                                <p class="text-gray-500">Gateway</p>
                                <p class="font-medium text-gray-900">{{ $subnet->gateway_ip }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-gray-500">DHCP</p>
                                <p class="font-medium text-gray-900">{{ $subnet->enable_dhcp ? 'فعال' : 'غیرفعال' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Connected Instances Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">سرورهای متصل</h2>
                @php
                    $networkInstances = $network->relationLoaded('instances') ? $network->getRelation('instances') : $network->instances()->get();
                @endphp
                @if($networkInstances->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <p>هیچ سروری به این شبکه متصل نیست</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">نام سرور</th>
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
                                    @if($instance->status === 'active')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $instance->status }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('customer.servers.show', $instance->id) }}" class="text-blue-600 hover:text-blue-900">مشاهده</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
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
                        <span class="text-gray-500">تاریخ ایجاد</span>
                        <span class="font-medium text-gray-900">{{ $network->created_at->format('Y/m/d') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">آخرین به‌روزرسانی</span>
                        <span class="font-medium text-gray-900">{{ $network->synced_at ? $network->synced_at->format('Y/m/d H:i') : 'N/A' }}</span>
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
                        <p class="text-sm text-gray-500 mt-1">سرورهای متصل</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900">{{ $networkSubnets->count() }}</p>
                        <p class="text-sm text-gray-500 mt-1">Subnet ها</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

