@extends('layouts.admin')

@section('title', 'سیستم اعتبار')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">سیستم اعتبار</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت قوانین اعتبار و پاداش‌های شارژ</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل اعتبار فعال</p>
                <p class="text-2xl font-bold text-gray-900">$89,450</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">پاداش امروز</p>
                <p class="text-2xl font-bold text-gray-900">$2,340</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">اعتبار منقضی شده</p>
                <p class="text-2xl font-bold text-gray-900">$1,230</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کاربران فعال</p>
                <p class="text-2xl font-bold text-gray-900">1,234</p>
            </div>
        </div>
    </div>
</div>

<!-- Credit Rules Configuration -->
<div class="space-y-6">
    <!-- Basic Credit Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">تنظیمات پایه اعتبار</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="min_topup" class="block text-sm font-medium text-gray-700 mb-2">حداقل شارژ (USD)</label>
                <input type="number" id="min_topup" value="10.00" step="0.01" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <p class="mt-1 text-xs text-gray-500">حداقل مبلغ قابل شارژ</p>
            </div>
            <div>
                <label for="credit_expiration" class="block text-sm font-medium text-gray-700 mb-2">انقضای اعتبار (روز)</label>
                <input type="number" id="credit_expiration" value="365" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <p class="mt-1 text-xs text-gray-500">0 = بدون انقضا</p>
            </div>
            <div>
                <label for="credit_usage" class="block text-sm font-medium text-gray-700 mb-2">محدودیت استفاده</label>
                <select id="credit_usage" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="everything">همه چیز</option>
                    <option value="invoices">فقط فاکتورها</option>
                    <option value="services">فقط سرویس‌ها</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Bonus Rules -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-900">قوانین پاداش</h2>
            <button onclick="addBonusRule()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <svg class="w-4 h-4 inline {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                افزودن قانون
            </button>
        </div>
        
        <div id="bonusRulesContainer" class="space-y-4">
            <!-- Bonus Rule 1 -->
            <div class="border border-gray-200 rounded-lg p-4 bonus-rule">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-medium text-gray-900">قانون پاداش #1</h3>
                    <button onclick="removeBonusRule(this)" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">مبلغ شارژ (USD)</label>
                        <input type="number" value="100.00" step="0.01" min="0" class="topup-amount mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">پاداش (USD)</label>
                        <input type="number" value="10.00" step="0.01" min="0" class="bonus-credit mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">درصد پاداش</label>
                        <input type="text" value="10%" readonly class="bonus-percentage mt-1 block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm sm:text-sm">
                    </div>
                </div>
            </div>

            <!-- Bonus Rule 2 -->
            <div class="border border-gray-200 rounded-lg p-4 bonus-rule">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-medium text-gray-900">قانون پاداش #2</h3>
                    <button onclick="removeBonusRule(this)" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">مبلغ شارژ (USD)</label>
                        <input type="number" value="500.00" step="0.01" min="0" class="topup-amount mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">پاداش (USD)</label>
                        <input type="number" value="75.00" step="0.01" min="0" class="bonus-credit mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">درصد پاداش</label>
                        <input type="text" value="15%" readonly class="bonus-percentage mt-1 block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm sm:text-sm">
                    </div>
                </div>
            </div>

            <!-- Bonus Rule 3 -->
            <div class="border border-gray-200 rounded-lg p-4 bonus-rule">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-medium text-gray-900">قانون پاداش #3</h3>
                    <button onclick="removeBonusRule(this)" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">مبلغ شارژ (USD)</label>
                        <input type="number" value="1000.00" step="0.01" min="0" class="topup-amount mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">پاداش (USD)</label>
                        <input type="number" value="200.00" step="0.01" min="0" class="bonus-credit mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">درصد پاداش</label>
                        <input type="text" value="20%" readonly class="bonus-percentage mt-1 block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm sm:text-sm">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-400 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-blue-800">نکته</h4>
                    <p class="text-sm text-blue-700">قوانین پاداش به ترتیب اولویت اعمال می‌شوند. بالاترین مبلغ مطابق شرایط انتخاب می‌شود.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Credit Activity Log -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">فعالیت‌های اعتبار اخیر</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                            کاربر
                        </th>
                        <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                            نوع
                        </th>
                        <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                            مبلغ شارژ
                        </th>
                        <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                            پاداش
                        </th>
                        <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                            تاریخ
                        </th>
                        <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                            وضعیت
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                    <span class="text-xs font-medium text-blue-600">AC</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">ACME Corp</div>
                                    <div class="text-sm text-gray-500">acme@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                شارژ با پاداش
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            $500.00
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            +$75.00
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            2024-01-15 14:30
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                فعال
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                    <span class="text-xs font-medium text-purple-600">TS</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">TechStart</div>
                                    <div class="text-sm text-gray-500">tech@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                شارژ معمولی
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            $50.00
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            -
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            2024-01-15 12:15
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                فعال
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                    <span class="text-xs font-medium text-yellow-600">DS</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Digital Sol</div>
                                    <div class="text-sm text-gray-500">digital@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                انقضای اعتبار
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            -
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                            -$25.00
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            2024-01-14 00:00
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                منقضی شده
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Save Button -->
<div class="flex justify-end mt-8">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
        ذخیره تنظیمات اعتبار
    </button>
</div>

<script>
let bonusRuleCounter = 3;

function addBonusRule() {
    bonusRuleCounter++;
    const container = document.getElementById('bonusRulesContainer');
    const newRule = document.createElement('div');
    newRule.className = 'border border-gray-200 rounded-lg p-4 bonus-rule';
    newRule.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-sm font-medium text-gray-900">قانون پاداش #${bonusRuleCounter}</h3>
            <button onclick="removeBonusRule(this)" class="text-red-600 hover:text-red-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">مبلغ شارژ (USD)</label>
                <input type="number" value="0.00" step="0.01" min="0" class="topup-amount mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">پاداش (USD)</label>
                <input type="number" value="0.00" step="0.01" min="0" class="bonus-credit mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">درصد پاداش</label>
                <input type="text" value="0%" readonly class="bonus-percentage mt-1 block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
        </div>
    `;
    container.appendChild(newRule);
    
    // Add event listeners for automatic percentage calculation
    const topupInput = newRule.querySelector('.topup-amount');
    const bonusInput = newRule.querySelector('.bonus-credit');
    const percentageInput = newRule.querySelector('.bonus-percentage');
    
    function updatePercentage() {
        const topup = parseFloat(topupInput.value) || 0;
        const bonus = parseFloat(bonusInput.value) || 0;
        const percentage = topup > 0 ? ((bonus / topup) * 100).toFixed(1) : 0;
        percentageInput.value = percentage + '%';
    }
    
    topupInput.addEventListener('input', updatePercentage);
    bonusInput.addEventListener('input', updatePercentage);
}

function removeBonusRule(button) {
    const rule = button.closest('.bonus-rule');
    rule.remove();
}

// Add event listeners for existing rules
document.addEventListener('DOMContentLoaded', function() {
    const rules = document.querySelectorAll('.bonus-rule');
    rules.forEach(rule => {
        const topupInput = rule.querySelector('.topup-amount');
        const bonusInput = rule.querySelector('.bonus-credit');
        const percentageInput = rule.querySelector('.bonus-percentage');
        
        function updatePercentage() {
            const topup = parseFloat(topupInput.value) || 0;
            const bonus = parseFloat(bonusInput.value) || 0;
            const percentage = topup > 0 ? ((bonus / topup) * 100).toFixed(1) : 0;
            percentageInput.value = percentage + '%';
        }
        
        topupInput.addEventListener('input', updatePercentage);
        bonusInput.addEventListener('input', updatePercentage);
        
        // Calculate initial percentage
        updatePercentage();
    });
});
</script>
@endsection
