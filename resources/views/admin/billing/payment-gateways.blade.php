@extends('layouts.admin')

@section('title', 'درگاه‌های پرداخت')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.billing.sidebar')
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">درگاه‌های پرداخت</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت و پیکربندی درگاه‌های پرداخت</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل درگاه‌ها</p>
                <p class="text-2xl font-bold text-gray-900">6</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">فعال</p>
                <p class="text-2xl font-bold text-gray-900">4</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل کارمزد</p>
                <p class="text-2xl font-bold text-gray-900">$1,234</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">نرخ موفقیت</p>
                <p class="text-2xl font-bold text-gray-900">94.2%</p>
            </div>
        </div>
    </div>
</div>

<!-- Payment Gateways List -->
<div class="space-y-6">
    <!-- Stripe -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-lg bg-blue-600 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <span class="text-xl font-bold text-white">S</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Stripe</h3>
                    <p class="text-sm text-gray-500">درگاه پرداخت بین‌المللی</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    فعال
                </span>
                <button onclick="openGatewayConfig('stripe')" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    پیکربندی
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">ارزهای پشتیبانی شده</div>
                <div class="text-lg font-semibold text-gray-900">USD, EUR</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد درصدی</div>
                <div class="text-lg font-semibold text-gray-900">2.9%</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد ثابت</div>
                <div class="text-lg font-semibold text-gray-900">$0.30</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">حالت تست</div>
                <div class="text-lg font-semibold text-red-600">غیرفعال</div>
            </div>
        </div>
        
        <div class="flex items-center justify-between text-sm text-gray-500">
            <span>آخرین تراکنش: 2 ساعت پیش</span>
            <span>نرخ موفقیت: 96.5%</span>
        </div>
    </div>

    <!-- PayPal -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-lg bg-blue-500 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <span class="text-xl font-bold text-white">P</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">PayPal</h3>
                    <p class="text-sm text-gray-500">درگاه پرداخت PayPal</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    فعال
                </span>
                <button onclick="openGatewayConfig('paypal')" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    پیکربندی
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">ارزهای پشتیبانی شده</div>
                <div class="text-lg font-semibold text-gray-900">USD, EUR, GBP</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد درصدی</div>
                <div class="text-lg font-semibold text-gray-900">3.4%</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد ثابت</div>
                <div class="text-lg font-semibold text-gray-900">$0.30</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">حالت تست</div>
                <div class="text-lg font-semibold text-red-600">غیرفعال</div>
            </div>
        </div>
        
        <div class="flex items-center justify-between text-sm text-gray-500">
            <span>آخرین تراکنش: 4 ساعت پیش</span>
            <span>نرخ موفقیت: 92.8%</span>
        </div>
    </div>

    <!-- ZarinPal -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-lg bg-green-600 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <span class="text-xl font-bold text-white">ز</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">زرین‌پال</h3>
                    <p class="text-sm text-gray-500">درگاه پرداخت ایرانی</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    فعال
                </span>
                <button onclick="openGatewayConfig('zarinpal')" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    پیکربندی
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">ارزهای پشتیبانی شده</div>
                <div class="text-lg font-semibold text-gray-900">IRR</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد درصدی</div>
                <div class="text-lg font-semibold text-gray-900">1.5%</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد ثابت</div>
                <div class="text-lg font-semibold text-gray-900">0 تومان</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">حالت تست</div>
                <div class="text-lg font-semibold text-green-600">فعال</div>
            </div>
        </div>
        
        <div class="flex items-center justify-between text-sm text-gray-500">
            <span>آخرین تراکنش: 1 ساعت پیش</span>
            <span>نرخ موفقیت: 89.3%</span>
        </div>
    </div>

    <!-- Bank Mellat -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-lg bg-red-600 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <span class="text-xl font-bold text-white">م</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">بانک ملت</h3>
                    <p class="text-sm text-gray-500">درگاه پرداخت بانک ملت</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    غیرفعال
                </span>
                <button onclick="openGatewayConfig('mellat')" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    پیکربندی
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">ارزهای پشتیبانی شده</div>
                <div class="text-lg font-semibold text-gray-900">IRR</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد درصدی</div>
                <div class="text-lg font-semibold text-gray-900">2.0%</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد ثابت</div>
                <div class="text-lg font-semibold text-gray-900">500 تومان</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">حالت تست</div>
                <div class="text-lg font-semibold text-green-600">فعال</div>
            </div>
        </div>
        
        <div class="flex items-center justify-between text-sm text-gray-500">
            <span>آخرین تراکنش: هرگز</span>
            <span>نرخ موفقیت: -</span>
        </div>
    </div>

    <!-- Crypto Gateway -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-lg bg-orange-600 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <span class="text-xl font-bold text-white">₿</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">CoinGate</h3>
                    <p class="text-sm text-gray-500">درگاه پرداخت ارز دیجیتال</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    فعال
                </span>
                <button onclick="openGatewayConfig('coingate')" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    پیکربندی
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">ارزهای پشتیبانی شده</div>
                <div class="text-lg font-semibold text-gray-900">BTC, ETH, USDT</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد درصدی</div>
                <div class="text-lg font-semibold text-gray-900">1.0%</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد ثابت</div>
                <div class="text-lg font-semibold text-gray-900">$0.00</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">حالت تست</div>
                <div class="text-lg font-semibold text-green-600">فعال</div>
            </div>
        </div>
        
        <div class="flex items-center justify-between text-sm text-gray-500">
            <span>آخرین تراکنش: 3 روز پیش</span>
            <span>نرخ موفقیت: 98.1%</span>
        </div>
    </div>

    <!-- Manual Payment -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-lg bg-gray-600 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">پرداخت دستی</h3>
                    <p class="text-sm text-gray-500">واریز بانکی و پرداخت دستی</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    فعال
                </span>
                <button onclick="openGatewayConfig('manual')" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    پیکربندی
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">ارزهای پشتیبانی شده</div>
                <div class="text-lg font-semibold text-gray-900">همه</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد درصدی</div>
                <div class="text-lg font-semibold text-gray-900">0%</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">کارمزد ثابت</div>
                <div class="text-lg font-semibold text-gray-900">$0.00</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-500">تایید دستی</div>
                <div class="text-lg font-semibold text-blue-600">مطلوب</div>
            </div>
        </div>
        
        <div class="flex items-center justify-between text-sm text-gray-500">
            <span>آخرین تراکنش: 6 ساعت پیش</span>
            <span>نرخ موفقیت: 100%</span>
        </div>
    </div>
</div>

<!-- Gateway Configuration Modal -->
<div id="gatewayConfigModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="gatewayConfigTitle">پیکربندی درگاه پرداخت</h3>
                <button onclick="closeGatewayConfigModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form class="space-y-4" id="gatewayConfigForm">
                <!-- Dynamic content will be loaded here -->
            </form>
        </div>
    </div>
</div>

<script>
function openGatewayConfig(gateway) {
    const title = document.getElementById('gatewayConfigTitle');
    const form = document.getElementById('gatewayConfigForm');
    
    const configs = {
        stripe: {
            title: 'پیکربندی Stripe',
            fields: `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">کلید عمومی</label>
                        <input type="text" placeholder="pk_live_..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">کلید خصوصی</label>
                        <input type="password" placeholder="sk_live_..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">آدرس Webhook</label>
                    <input type="url" value="https://yoursite.com/webhooks/stripe" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">کارمزد درصدی (%)</label>
                        <input type="number" value="2.9" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">کارمزد ثابت (USD)</label>
                        <input type="number" value="0.30" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
                <div class="flex items-center space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
                    <label class="flex items-center">
                        <input type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">حالت تست</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">فعال</span>
                    </label>
                </div>
            `
        },
        paypal: {
            title: 'پیکربندی PayPal',
            fields: `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client ID</label>
                        <input type="text" placeholder="AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client Secret</label>
                        <input type="password" placeholder="EGnHDxD_qRPdaLdHgGYQfb394WD-Ep5XWjRvxgHF6NQjYBFp_8yrOGWKRnLdgXKBZKW0kdHGOoLoGS-WA" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">کارمزد درصدی (%)</label>
                        <input type="number" value="3.4" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">کارمزد ثابت (USD)</label>
                        <input type="number" value="0.30" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
                <div class="flex items-center space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
                    <label class="flex items-center">
                        <input type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">حالت Sandbox</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">فعال</span>
                    </label>
                </div>
            `
        },
        zarinpal: {
            title: 'پیکربندی زرین‌پال',
            fields: `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Merchant ID</label>
                    <input type="text" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">کارمزد درصدی (%)</label>
                        <input type="number" value="1.5" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">کارمزد ثابت (تومان)</label>
                        <input type="number" value="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
                <div class="flex items-center space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }}">
                    <label class="flex items-center">
                        <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">حالت تست</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" checked class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <span class="{{ $isRtl ? 'mr-2' : 'ml-2' }} text-sm text-gray-700">فعال</span>
                    </label>
                </div>
            `
        }
    };
    
    const config = configs[gateway] || { title: 'پیکربندی درگاه', fields: '<p>پیکربندی در دسترس نیست</p>' };
    
    title.textContent = config.title;
    form.innerHTML = config.fields + `
        <div class="flex justify-end space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }} pt-4 border-t">
            <button type="button" onclick="closeGatewayConfigModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors">
                انصراف
            </button>
            <button type="button" onclick="testGatewayConnection()" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                تست اتصال
            </button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                ذخیره تنظیمات
            </button>
        </div>
    `;
    
    document.getElementById('gatewayConfigModal').classList.remove('hidden');
}

function closeGatewayConfigModal() {
    document.getElementById('gatewayConfigModal').classList.add('hidden');
}

function testGatewayConnection() {
    // Simulate testing connection
    alert('در حال تست اتصال...\n\n✅ اتصال موفق!\nدرگاه پرداخت به درستی پیکربندی شده است.');
}

// Close modal when clicking outside
document.getElementById('gatewayConfigModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeGatewayConfigModal();
    }
});
</script>
@endsection
