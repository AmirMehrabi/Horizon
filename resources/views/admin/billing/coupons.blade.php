@extends('layouts.admin')

@section('title', 'کوپن‌های تخفیف')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Page Header -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">کوپن‌های تخفیف</h1>
        <p class="mt-1 text-sm text-gray-500">مدیریت کوپن‌ها و کدهای تخفیف</p>
    </div>
    <button onclick="openCreateCouponModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
        <svg class="w-5 h-5 inline {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        ایجاد کوپن جدید
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل کوپن‌ها</p>
                <p class="text-2xl font-bold text-gray-900">24</p>
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
                <p class="text-2xl font-bold text-gray-900">18</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">استفاده شده</p>
                <p class="text-2xl font-bold text-gray-900">156</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center {{ $isRtl ? 'ml-4' : 'mr-4' }}">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">کل تخفیف</p>
                <p class="text-2xl font-bold text-gray-900">$2,450</p>
            </div>
        </div>
    </div>
</div>

<!-- Coupons List -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">لیست کوپن‌ها</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        کد کوپن
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        نوع تخفیف
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        مقدار
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        اعمال به
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        تاریخ انقضا
                    </th>
                    <th scope="col" class="px-6 py-3 {{ $isRtl ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                        استفاده
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
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">WELCOME50</div>
                                <div class="text-sm text-gray-500">کوپن خوشامدگویی</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            درصدی
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">50%</div>
                        <div class="text-xs text-gray-500">حداکثر $100</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        همه سرویس‌ها
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-12-31
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <div class="w-16 bg-gray-200 rounded-full h-2 {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 45%"></div>
                            </div>
                            <span class="text-xs">45/100</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            فعال
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button class="text-blue-600 hover:text-blue-900">ویرایش</button>
                            <button class="text-red-600 hover:text-red-900">حذف</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">STORAGE20</div>
                                <div class="text-sm text-gray-500">تخفیف ذخیره‌سازی</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            مبلغ ثابت
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">$20</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ذخیره‌سازی
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-06-30
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <div class="w-16 bg-gray-200 rounded-full h-2 {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 80%"></div>
                            </div>
                            <span class="text-xs">24/30</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            فعال
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button class="text-blue-600 hover:text-blue-900">ویرایش</button>
                            <button class="text-red-600 hover:text-red-900">حذف</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center {{ $isRtl ? 'ml-3' : 'mr-3' }}">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">EXPIRED10</div>
                                <div class="text-sm text-gray-500">کوپن منقضی شده</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            درصدی
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-medium">10%</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        پلن‌ها
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2024-01-31
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex items-center">
                            <div class="w-16 bg-gray-200 rounded-full h-2 {{ $isRtl ? 'ml-2' : 'mr-2' }}">
                                <div class="bg-red-600 h-2 rounded-full" style="width: 100%"></div>
                            </div>
                            <span class="text-xs">50/50</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            منقضی شده
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap {{ $isRtl ? 'text-left' : 'text-right' }} text-sm font-medium">
                        <div class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}">
                            <button class="text-gray-600 hover:text-gray-900">مشاهده</button>
                            <button class="text-red-600 hover:text-red-900">حذف</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Create Coupon Modal -->
<div id="createCouponModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">ایجاد کوپن جدید</h3>
                <button onclick="closeCreateCouponModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="coupon_code" class="block text-sm font-medium text-gray-700 mb-2">کد کوپن</label>
                        <input type="text" id="coupon_code" name="coupon_code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="مثال: WELCOME50">
                    </div>
                    <div>
                        <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-2">نوع تخفیف</label>
                        <select id="discount_type" name="discount_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="percentage">درصدی</option>
                            <option value="fixed">مبلغ ثابت</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-2">مقدار تخفیف</label>
                        <input type="number" id="discount_value" name="discount_value" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="max_discount_cap" class="block text-sm font-medium text-gray-700 mb-2">حداکثر تخفیف (USD)</label>
                        <input type="number" id="max_discount_cap" name="max_discount_cap" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
                
                <div>
                    <label for="applies_to" class="block text-sm font-medium text-gray-700 mb-2">اعمال به</label>
                    <select id="applies_to" name="applies_to" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="all">همه سرویس‌ها</option>
                        <option value="plans">پلن‌ها</option>
                        <option value="storage">ذخیره‌سازی</option>
                        <option value="network">شبکه</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="duration_type" class="block text-sm font-medium text-gray-700 mb-2">نوع مدت</label>
                        <select id="duration_type" name="duration_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="one_time">یک بار</option>
                            <option value="repeating">تکراری</option>
                        </select>
                    </div>
                    <div>
                        <label for="duration_months" class="block text-sm font-medium text-gray-700 mb-2">مدت (ماه)</label>
                        <input type="number" id="duration_months" name="duration_months" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="valid_from" class="block text-sm font-medium text-gray-700 mb-2">تاریخ شروع</label>
                        <input type="date" id="valid_from" name="valid_from" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="valid_to" class="block text-sm font-medium text-gray-700 mb-2">تاریخ انقضا</label>
                        <input type="date" id="valid_to" name="valid_to" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
                
                <div>
                    <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-2">محدودیت استفاده</label>
                    <input type="number" id="usage_limit" name="usage_limit" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="تعداد دفعات قابل استفاده">
                </div>
                
                <div class="flex justify-end space-x-4 {{ $isRtl ? 'space-x-reverse' : '' }} pt-4">
                    <button type="button" onclick="closeCreateCouponModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors">
                        انصراف
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        ایجاد کوپن
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreateCouponModal() {
    document.getElementById('createCouponModal').classList.remove('hidden');
}

function closeCreateCouponModal() {
    document.getElementById('createCouponModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('createCouponModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateCouponModal();
    }
});
</script>
@endsection
