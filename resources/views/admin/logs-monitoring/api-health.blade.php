@extends('layouts.admin')

@section('title', 'سلامت API')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.logs-monitoring.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">سلامت API</h1>
    <p class="mt-1 text-sm text-gray-500">وضعیت سرویس‌های OpenStack</p>
</div>

<!-- API Status Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Nova (Compute)</h3>
            <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">آنلاین</span>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Response Time</span>
                <span class="font-medium text-gray-900">120ms</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Uptime</span>
                <span class="font-medium text-gray-900">99.9%</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Version</span>
                <span class="font-medium text-gray-900">25.0.0</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Neutron (Network)</h3>
            <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">آنلاین</span>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Response Time</span>
                <span class="font-medium text-gray-900">95ms</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Uptime</span>
                <span class="font-medium text-gray-900">99.8%</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Version</span>
                <span class="font-medium text-gray-900">21.0.0</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Cinder (Storage)</h3>
            <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 rounded-full">هشدار</span>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Response Time</span>
                <span class="font-medium text-gray-900">450ms</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Uptime</span>
                <span class="font-medium text-gray-900">98.5%</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Version</span>
                <span class="font-medium text-gray-900">19.0.0</span>
            </div>
        </div>
    </div>
</div>

<!-- Additional Services -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Glance (Image)</h3>
            <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">آنلاین</span>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Response Time</span>
                <span class="font-medium text-gray-900">80ms</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Uptime</span>
                <span class="font-medium text-gray-900">99.9%</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Keystone (Identity)</h3>
            <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">آنلاین</span>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Response Time</span>
                <span class="font-medium text-gray-900">60ms</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Uptime</span>
                <span class="font-medium text-gray-900">100%</span>
            </div>
        </div>
    </div>
</div>
@endsection

