@extends('layouts.customer')

@section('title', 'جزئیات تیکت #' . $ticket['id'])

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
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
                'label' => 'پشتیبانی',
                'url' => route('customer.support.index'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>'
            ],
            [
                'label' => 'تیکت #' . ($ticket['id'] ?? ''),
                'active' => true
            ]
        ]
    ])
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <a href="{{ route('customer.support.index') }}" class="text-blue-600 hover:text-blue-700 text-sm mb-2 inline-block">
        ← بازگشت به لیست تیکت‌ها
    </a>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">تیکت #{{ $ticket['id'] }}</h1>
            <p class="mt-1 text-sm text-gray-500">{{ $ticket['title'] }}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 text-sm font-medium rounded-full
                @if($ticket['status_color'] === 'green') bg-green-100 text-green-800
                @elseif($ticket['status_color'] === 'yellow') bg-yellow-100 text-yellow-800
                @elseif($ticket['status_color'] === 'blue') bg-blue-100 text-blue-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ $ticket['status_label'] }}
            </span>
            @if($ticket['status'] !== 'closed')
            <form method="POST" action="{{ route('customer.support.close', $ticket['id']) }}" class="inline">
                @csrf
                <button type="submit" onclick="return confirm('آیا از بستن این تیکت اطمینان دارید؟')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                    بستن تیکت
                </button>
            </form>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content: Messages -->
    <div class="lg:col-span-2">
        <!-- Ticket Metadata -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">دسته‌بندی</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $ticket['category'] }}</p>
                </div>
                <div>
                    <p class="text-gray-500">اولویت</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $ticket['priority_label'] }}</p>
                </div>
                <div>
                    <p class="text-gray-500">تاریخ ایجاد</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $ticket['created_at'] }}</p>
                </div>
                <div>
                    <p class="text-gray-500">آخرین بروزرسانی</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $ticket['updated_at'] }}</p>
                </div>
            </div>
        </div>
        
        <!-- Messages Thread -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">مکالمات</h2>
            
            <div class="space-y-6">
                @foreach($messages as $message)
                <div class="flex {{ $message['sender'] === 'user' ? ($isRtl ? 'justify-start' : 'justify-end') : ($isRtl ? 'justify-end' : 'justify-start') }}">
                    <div class="max-w-2xl {{ $message['sender'] === 'user' ? 'order-2' : 'order-1' }}">
                        <div class="flex items-center gap-2 mb-2 {{ $message['sender'] === 'user' ? ($isRtl ? 'flex-row-reverse' : 'flex-row') : ($isRtl ? 'flex-row-reverse' : 'flex-row') }}">
                            <div class="w-8 h-8 rounded-full {{ $message['sender'] === 'user' ? 'bg-blue-600' : 'bg-gray-400' }} flex items-center justify-center text-white text-sm font-medium">
                                {{ $message['sender'] === 'user' ? 'ش' : 'پ' }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $message['sender_name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $message['timestamp'] }}</p>
                            </div>
                        </div>
                        <div class="bg-{{ $message['sender'] === 'user' ? 'blue' : 'gray' }}-50 rounded-lg p-4 {{ $message['sender'] === 'user' ? ($isRtl ? 'rounded-tr-none' : 'rounded-tl-none') : ($isRtl ? 'rounded-tl-none' : 'rounded-tr-none') }}">
                            <p class="text-sm text-gray-900 whitespace-pre-line">{{ $message['content'] }}</p>
                            @if(!empty($message['attachments']))
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-xs text-gray-500 mb-2">ضمیمه‌ها:</p>
                                <div class="space-y-1">
                                    @foreach($message['attachments'] as $attachment)
                                    <a href="#" class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                        {{ $attachment['name'] }} ({{ $attachment['size'] }})
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Reply Box -->
        @if($ticket['status'] !== 'closed')
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">پاسخ به تیکت</h3>
            <form method="POST" action="{{ route('customer.support.reply', $ticket['id']) }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <textarea 
                            name="message" 
                            rows="5"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="پاسخ خود را اینجا بنویسید..."
                        ></textarea>
                    </div>
                    <div>
                        <label for="reply_attachment" class="block text-sm font-medium text-gray-700 mb-2">
                            ضمیمه فایل (اختیاری)
                        </label>
                        <input 
                            type="file" 
                            id="reply_attachment" 
                            name="attachment"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm"
                            accept=".txt,.pdf,.doc,.docx,.jpg,.png,.zip"
                        >
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            ارسال پاسخ
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @else
        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 text-center">
            <p class="text-gray-500">این تیکت بسته شده است. برای ادامه مکالمه، لطفاً یک تیکت جدید ایجاد کنید.</p>
        </div>
        @endif
    </div>
    
    <!-- Sidebar: Ticket Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-24">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات تیکت</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">شماره تیکت</p>
                    <p class="text-sm font-medium text-gray-900 mt-1">#{{ $ticket['id'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">وضعیت</p>
                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $ticket['status_label'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">دسته‌بندی</p>
                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $ticket['category'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">اولویت</p>
                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $ticket['priority_label'] }}</p>
                </div>
                @if(isset($ticket['server']))
                <div>
                    <p class="text-sm text-gray-500">سرویس مرتبط</p>
                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $ticket['server'] }}</p>
                </div>
                @endif
                <div>
                    <p class="text-sm text-gray-500">تاریخ ایجاد</p>
                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $ticket['created_at'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


