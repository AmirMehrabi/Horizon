@extends('layouts.admin')

@section('title', 'کیف پول‌ها')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">کیف پول‌ها</h1>
    <p class="mt-1 text-sm text-gray-500">مدیریت کیف پول‌های کاربران و تراکنش‌ها</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل کیف پول‌ها</p>
                <p class="text-2xl font-bold text-gray-900">1,234</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل موجودی</p>
                <p class="text-2xl font-bold text-gray-900">$156,780</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">شارژ امروز</p>
                <p class="text-2xl font-bold text-gray-900">$12,450</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">موجودی کم</p>
                <p class="text-2xl font-bold text-gray-900">23</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">فیلترها</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="user_filter" class="block text-sm font-medium text-gray-700 mb-2">کاربر</label>
            <input type="text" id="user_filter" placeholder="جستجو کاربر..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <div>
            <label for="balance_filter" class="block text-sm font-medium text-gray-700 mb-2">موجودی</label>
            <select id="balance_filter" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">همه</option>
                <option value="high">بالا (>$100)</option>
                <option value="medium">متوسط ($10-$100)</option>
                <option value="low">کم (<$10)</option>
                <option value="zero">صفر</option>
            </select>
        </div>
        <div>
            <label for="status_filter" class="block text-sm font-medium text-gray-700 mb-2">وضعیت</label>
            <select id="status_filter" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">همه</option>
                <option value="active">فعال</option>
                <option value="suspended">تعلیق شده</option>
                <option value="frozen">مسدود شده</option>
            </select>
        </div>
        <div class="flex items-end">
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                اعمال فیلتر
            </button>
        </div>
    </div>
</div>

<!-- Wallets List -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">لیست کیف پول‌ها</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        کاربر
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        موجودی فعلی
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        کل شارژ
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        کل مصرف
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        آخرین تراکنش
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        وضعیت
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">عملیات</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                                <span class="text-sm font-medium text-blue-600">AC</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">ACME Corporation</div>
                                <div class="text-sm text-gray-500">acme@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">$1,234.56</div>
                        <div class="text-sm text-gray-500">موجودی بالا</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $5,670.00
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $4,435.44
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>شارژ +$500</div>
                        <div class="text-xs text-gray-500">2 ساعت پیش</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            فعال
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button onclick="openAdjustBalanceModal('acme@example.com', 1234.56)" class="text-blue-600 hover:text-blue-900">تنظیم موجودی</button>
                            <button onclick="openWalletLogsModal('acme@example.com')" class="text-green-600 hover:text-green-900">تاریخچه</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                                <span class="text-sm font-medium text-purple-600">TS</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">TechStart Inc</div>
                                <div class="text-sm text-gray-500">tech@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">$45.23</div>
                        <div class="text-sm text-gray-500">موجودی متوسط</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $890.00
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $844.77
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>مصرف -$12.50</div>
                        <div class="text-xs text-gray-500">1 روز پیش</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            فعال
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button onclick="openAdjustBalanceModal('tech@example.com', 45.23)" class="text-blue-600 hover:text-blue-900">تنظیم موجودی</button>
                            <button onclick="openWalletLogsModal('tech@example.com')" class="text-green-600 hover:text-green-900">تاریخچه</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                                <span class="text-sm font-medium text-red-600">DS</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">Digital Solutions</div>
                                <div class="text-sm text-gray-500">digital@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-red-600">$2.15</div>
                        <div class="text-sm text-gray-500">موجودی کم</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $450.00
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $447.85
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>مصرف -$8.90</div>
                        <div class="text-xs text-gray-500">3 ساعت پیش</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            هشدار موجودی
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button onclick="openAdjustBalanceModal('digital@example.com', 2.15)" class="text-blue-600 hover:text-blue-900">تنظیم موجودی</button>
                            <button onclick="openWalletLogsModal('digital@example.com')" class="text-green-600 hover:text-green-900">تاریخچه</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                                <span class="text-sm font-medium text-gray-600">SC</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">StartupCorp</div>
                                <div class="text-sm text-gray-500">startup@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-600">$0.00</div>
                        <div class="text-sm text-gray-500">موجودی صفر</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $200.00
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $200.00
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>مصرف -$15.00</div>
                        <div class="text-xs text-gray-500">1 هفته پیش</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            تعلیق شده
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button onclick="openAdjustBalanceModal('startup@example.com', 0)" class="text-blue-600 hover:text-blue-900">تنظیم موجودی</button>
                            <button onclick="openWalletLogsModal('startup@example.com')" class="text-green-600 hover:text-green-900">تاریخچه</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Adjust Balance Modal -->
<div id="adjustBalanceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">تنظیم موجودی کیف پول</h3>
                <button onclick="closeAdjustBalanceModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">کاربر</label>
                    <div id="selectedUser" class="p-3 bg-gray-50 rounded-md text-sm text-gray-900"></div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">موجودی فعلی</label>
                    <div id="currentBalance" class="p-3 bg-gray-50 rounded-md text-sm font-medium text-gray-900"></div>
                </div>
                
                <div>
                    <label for="adjustment_type" class="block text-sm font-medium text-gray-700 mb-2">نوع تنظیم</label>
                    <select id="adjustment_type" name="adjustment_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="add">افزودن اعتبار</option>
                        <option value="subtract">کسر اعتبار</option>
                        <option value="set">تنظیم مقدار مشخص</option>
                    </select>
                </div>
                
                <div>
                    <label for="adjustment_amount" class="block text-sm font-medium text-gray-700 mb-2">مبلغ (USD)</label>
                    <input type="number" id="adjustment_amount" name="adjustment_amount" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                
                <div>
                    <label for="adjustment_reason" class="block text-sm font-medium text-gray-700 mb-2">دلیل تنظیم</label>
                    <textarea id="adjustment_reason" name="adjustment_reason" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="دلیل این تنظیم را بنویسید..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }} pt-4">
                    <button type="button" onclick="closeAdjustBalanceModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors">
                        انصراف
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        اعمال تنظیم
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Wallet Logs Modal -->
<div id="walletLogsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">تاریخچه کیف پول</h3>
                <button onclick="closeWalletLogsModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase">تاریخ</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase">نوع</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase">مبلغ</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase">موجودی</th>
                            <th class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase">توضیحات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="walletLogsTableBody">
                        <!-- Dynamic content will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function openAdjustBalanceModal(email, currentBalance) {
    document.getElementById('selectedUser').textContent = email;
    document.getElementById('currentBalance').textContent = '$' + currentBalance.toFixed(2);
    document.getElementById('adjustBalanceModal').classList.remove('hidden');
}

function closeAdjustBalanceModal() {
    document.getElementById('adjustBalanceModal').classList.add('hidden');
}

function openWalletLogsModal(email) {
    // Sample data - in real app, this would be fetched from server
    const sampleLogs = [
        { date: '2024-01-15 10:30', type: 'شارژ', amount: '+$500.00', balance: '$1,234.56', description: 'شارژ دستی توسط ادمین' },
        { date: '2024-01-14 15:45', type: 'مصرف', amount: '-$12.50', balance: '$734.56', description: 'هزینه سرور - INV-2024-001' },
        { date: '2024-01-13 09:20', type: 'شارژ', amount: '+$200.00', balance: '$747.06', description: 'پرداخت آنلاین' },
        { date: '2024-01-12 14:10', type: 'مصرف', amount: '-$25.00', balance: '$547.06', description: 'هزینه پهنای باند' }
    ];
    
    const tbody = document.getElementById('walletLogsTableBody');
    tbody.innerHTML = '';
    
    sampleLogs.forEach(log => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${log.date}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${log.type === 'شارژ' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                    ${log.type}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ${log.amount.startsWith('+') ? 'text-green-600' : 'text-red-600'}">${log.amount}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${log.balance}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${log.description}</td>
        `;
        tbody.appendChild(row);
    });
    
    document.getElementById('walletLogsModal').classList.remove('hidden');
}

function closeWalletLogsModal() {
    document.getElementById('walletLogsModal').classList.add('hidden');
}

// Close modals when clicking outside
document.getElementById('adjustBalanceModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAdjustBalanceModal();
    }
});

document.getElementById('walletLogsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeWalletLogsModal();
    }
});
</script>
@endsection
