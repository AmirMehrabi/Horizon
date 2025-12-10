@extends('layouts.admin')

@section('title', 'جزئیات گروه امنیتی')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp


@section('content')
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.networks.security-groups') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    گروه‌های امنیتی
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 mr-1 md:mr-2">default</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-lg bg-red-100 flex items-center justify-center">
            <svg class="w-9 h-9 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">default</h1>
            <p class="mt-1 text-sm text-gray-500">Security Group ID: sg-default-001</p>
        </div>
    </div>
    <button onclick="openAddRuleModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors duration-200 flex items-center gap-2 shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        افزودن قانون
    </button>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Ingress Rules -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">قوانین Ingress</h2>
                <button onclick="openAddRuleModal('ingress')" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ افزودن قانون</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">پروتکل</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">پورت</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">منبع</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">TCP</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">22</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">0.0.0.0/0</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <button onclick="deleteRule('ingress', 1)" class="text-red-600 hover:text-red-900">حذف</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">TCP</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">80, 443</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">0.0.0.0/0</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <button onclick="deleteRule('ingress', 2)" class="text-red-600 hover:text-red-900">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Egress Rules -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">قوانین Egress</h2>
                <button onclick="openAddRuleModal('egress')" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ افزودن قانون</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">پروتکل</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">پورت</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">مقصد</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">All</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">All</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">0.0.0.0/0</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <button onclick="deleteRule('egress', 1)" class="text-red-600 hover:text-red-900">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Connected Instances -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Instance های متصل</h2>
            <div class="space-y-2">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">web-server-01</p>
                        <p class="text-xs text-gray-500">project-acme-corp</p>
                    </div>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-900">مشاهده</a>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">db-server-01</p>
                        <p class="text-xs text-gray-500">project-acme-corp</p>
                    </div>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-900">مشاهده</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Security Group ID</span>
                    <span class="font-medium text-gray-900 font-mono text-xs">sg-default-001</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">پروژه</span>
                    <span class="font-medium text-gray-900">project-acme-corp</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">تاریخ ایجاد</span>
                    <span class="font-medium text-gray-900">۱۴۰۳/۰۱/۱۵</span>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">عملیات</h2>
            <div class="space-y-2">
                <button onclick="openAddRuleModal()" class="w-full text-right px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg font-medium text-sm transition-colors">
                    افزودن قانون
                </button>
                <button onclick="deleteSecurityGroup()" class="w-full text-right px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-medium text-sm transition-colors">
                    حذف گروه
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Rule Modal -->
<div id="addRuleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">افزودن قانون</h3>
            <button onclick="closeAddRuleModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">نوع قانون</label>
                <select id="ruleType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="ingress">Ingress</option>
                    <option value="egress">Egress</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">پروتکل</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="tcp">TCP</option>
                    <option value="udp">UDP</option>
                    <option value="icmp">ICMP</option>
                    <option value="all">All</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">پورت از</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="80" min="1" max="65535">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">پورت تا</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="80" min="1" max="65535">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">منبع/مقصد</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="0.0.0.0/0" required>
                <p class="mt-1 text-xs text-gray-500">CIDR یا Security Group ID</p>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddRuleModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    انصراف
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    افزودن قانون
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddRuleModal(type) {
    if (type) {
        document.getElementById('ruleType').value = type;
    }
    document.getElementById('addRuleModal').classList.remove('hidden');
}

function closeAddRuleModal() {
    document.getElementById('addRuleModal').classList.add('hidden');
}

function deleteRule(direction, ruleId) {
    if (confirm('آیا مطمئن هستید که می‌خواهید این قانون را حذف کنید؟')) {
        // Delete rule logic
        alert('قانون حذف شد');
    }
}

function deleteSecurityGroup() {
    if (confirm('آیا مطمئن هستید که می‌خواهید این گروه امنیتی را حذف کنید؟')) {
        window.location.href = "{{ route('admin.networks.security-groups') }}";
    }
}
</script>
@endsection



