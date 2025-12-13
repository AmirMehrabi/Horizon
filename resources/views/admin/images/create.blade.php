@extends('layouts.admin')

@section('title', 'آپلود Image جدید')

@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.images.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Image ها
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 mr-1 md:mr-2">آپلود جدید</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">آپلود Image جدید</h1>
    <p class="mt-1 text-sm text-gray-500">آپلود Image جدید به Glance از طریق فایل یا URL</p>
</div>

@if($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Upload Form -->
<form action="{{ route('admin.images.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <!-- Upload Method Selection -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">روش آپلود</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition-colors upload-method-option" data-method="file">
                <input type="radio" name="upload_method" value="file" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                <div class="mr-3">
                    <p class="text-sm font-medium text-gray-900">آپلود فایل</p>
                    <p class="text-xs text-gray-500">آپلود فایل Image از کامپیوتر شما</p>
                </div>
            </label>
            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition-colors upload-method-option" data-method="url">
                <input type="radio" name="upload_method" value="url" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                <div class="mr-3">
                    <p class="text-sm font-medium text-gray-900">آپلود از URL</p>
                    <p class="text-xs text-gray-500">دانلود و آپلود Image از یک آدرس اینترنتی</p>
                </div>
            </label>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">اطلاعات پایه</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">نام Image <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="ubuntu-22.04-lts">
                <p class="mt-1 text-xs text-gray-500">نام منحصر به فرد برای Image</p>
            </div>
            <div>
                <label for="disk_format" class="block text-sm font-medium text-gray-700 mb-2">فرمت دیسک <span class="text-red-500">*</span></label>
                <select id="disk_format" name="disk_format" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">انتخاب Format</option>
                    <option value="qcow2" {{ old('disk_format') === 'qcow2' ? 'selected' : '' }}>QCOW2</option>
                    <option value="raw" {{ old('disk_format') === 'raw' ? 'selected' : '' }}>RAW</option>
                    <option value="iso" {{ old('disk_format') === 'iso' ? 'selected' : '' }}>ISO</option>
                    <option value="vhd" {{ old('disk_format') === 'vhd' ? 'selected' : '' }}>VHD</option>
                    <option value="vmdk" {{ old('disk_format') === 'vmdk' ? 'selected' : '' }}>VMDK</option>
                    <option value="vdi" {{ old('disk_format') === 'vdi' ? 'selected' : '' }}>VDI</option>
                </select>
            </div>
        </div>
        <div class="mt-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
            <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="توضیحات Image...">{{ old('description') }}</textarea>
        </div>
    </div>

    <!-- File Upload Section -->
    <div id="file-upload-section" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">فایل Image</h2>
        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                    <label for="image_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                        <span>انتخاب فایل</span>
                        <input id="image_file" name="image_file" type="file" class="sr-only" accept=".qcow2,.vhd,.vmdk,.raw,.iso,.vdi" onchange="updateFileName(this)">
                    </label>
                    <p class="mr-1">یا فایل را اینجا بکشید</p>
                </div>
                <p class="text-xs text-gray-500">QCOW2, VHD, VMDK, RAW, ISO, VDI تا 10 GB</p>
                <p id="file-name" class="text-sm text-gray-700 mt-2 hidden"></p>
            </div>
        </div>
    </div>

    <!-- URL Upload Section -->
    <div id="url-upload-section" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hidden">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">آدرس URL Image</h2>
        <div>
            <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">URL <span class="text-red-500">*</span></label>
            <input type="url" id="image_url" name="image_url" value="{{ old('image_url') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="https://example.com/image.qcow2">
            <p class="mt-1 text-xs text-gray-500">فقط HTTP و HTTPS مجاز است. فایل باید یکی از فرمت‌های مجاز باشد.</p>
            <div id="url-validation" class="mt-2 hidden"></div>
        </div>
    </div>

    <!-- Image Properties -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">ویژگی‌های Image</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="container_format" class="block text-sm font-medium text-gray-700 mb-2">فرمت Container</label>
                <select id="container_format" name="container_format" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="bare" {{ old('container_format', 'bare') === 'bare' ? 'selected' : '' }}>bare</option>
                    <option value="ovf" {{ old('container_format') === 'ovf' ? 'selected' : '' }}>ovf</option>
                    <option value="aki" {{ old('container_format') === 'aki' ? 'selected' : '' }}>aki</option>
                    <option value="ari" {{ old('container_format') === 'ari' ? 'selected' : '' }}>ari</option>
                    <option value="ami" {{ old('container_format') === 'ami' ? 'selected' : '' }}>ami</option>
                </select>
            </div>
            <div>
                <label for="min_disk" class="block text-sm font-medium text-gray-700 mb-2">حداقل Disk (GB)</label>
                <input type="number" id="min_disk" name="min_disk" value="{{ old('min_disk') }}" min="1" max="1000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="20">
            </div>
            <div>
                <label for="min_ram" class="block text-sm font-medium text-gray-700 mb-2">حداقل RAM (GB)</label>
                <input type="number" id="min_ram" name="min_ram" value="{{ old('min_ram') }}" min="1" max="512" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="2">
            </div>
        </div>
    </div>

    <!-- Visibility Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">تنظیمات دسترسی</h2>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">دسترسی Image <span class="text-red-500">*</span></label>
            <div class="space-y-2">
                <label class="flex items-center p-3 border-2 border-blue-500 rounded-lg bg-blue-50 cursor-pointer">
                    <input type="radio" name="visibility" value="public" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('visibility', 'public') === 'public' ? 'checked' : '' }}>
                    <div class="mr-3">
                        <p class="text-sm font-medium text-gray-900">عمومی</p>
                        <p class="text-xs text-gray-500">همه کاربران و پروژه‌ها می‌توانند از این Image استفاده کنند</p>
                    </div>
                </label>
                <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer">
                    <input type="radio" name="visibility" value="private" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('visibility') === 'private' ? 'checked' : '' }}>
                    <div class="mr-3">
                        <p class="text-sm font-medium text-gray-900">خصوصی</p>
                        <p class="text-xs text-gray-500">فقط پروژه‌های انتخاب شده می‌توانند از این Image استفاده کنند</p>
                    </div>
                </label>
                <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer">
                    <input type="radio" name="visibility" value="shared" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('visibility') === 'shared' ? 'checked' : '' }}>
                    <div class="mr-3">
                        <p class="text-sm font-medium text-gray-900">اشتراکی</p>
                        <p class="text-xs text-gray-500">Image با پروژه‌های مشخص شده به اشتراک گذاشته می‌شود</p>
                    </div>
                </label>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex items-center justify-end gap-3 pt-4">
        <a href="{{ route('admin.images.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
            انصراف
        </a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            آپلود Image
        </button>
    </div>
</form>

<script>
// Toggle upload method sections
document.addEventListener('DOMContentLoaded', function() {
    const uploadMethodRadios = document.querySelectorAll('input[name="upload_method"]');
    const fileSection = document.getElementById('file-upload-section');
    const urlSection = document.getElementById('url-upload-section');
    const fileInput = document.getElementById('image_file');
    const urlInput = document.getElementById('image_url');

    uploadMethodRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'file') {
                fileSection.classList.remove('hidden');
                urlSection.classList.add('hidden');
                fileInput.required = true;
                urlInput.required = false;
            } else {
                fileSection.classList.add('hidden');
                urlSection.classList.remove('hidden');
                fileInput.required = false;
                urlInput.required = true;
            }
        });
    });

    // URL validation
    urlInput.addEventListener('blur', function() {
        const url = this.value;
        const validationDiv = document.getElementById('url-validation');
        
        if (!url) {
            validationDiv.classList.add('hidden');
            return;
        }

        // Basic URL validation
        try {
            const urlObj = new URL(url);
            const allowedSchemes = ['http', 'https'];
            
            if (!allowedSchemes.includes(urlObj.protocol.replace(':', ''))) {
                showValidationError('فقط HTTP و HTTPS مجاز است');
                return;
            }

            // Check file extension
            const path = urlObj.pathname;
            const extension = path.split('.').pop().toLowerCase();
            const allowedExtensions = ['qcow2', 'raw', 'iso', 'vhd', 'vmdk', 'vdi'];
            
            if (!allowedExtensions.includes(extension)) {
                showValidationError('فرمت فایل معتبر نیست. فرمت‌های مجاز: ' + allowedExtensions.join(', '));
                return;
            }

            showValidationSuccess('URL معتبر است');
        } catch (e) {
            showValidationError('URL معتبر نیست');
        }
    });

    function showValidationError(message) {
        const validationDiv = document.getElementById('url-validation');
        validationDiv.className = 'mt-2 text-sm text-red-600';
        validationDiv.textContent = message;
        validationDiv.classList.remove('hidden');
    }

    function showValidationSuccess(message) {
        const validationDiv = document.getElementById('url-validation');
        validationDiv.className = 'mt-2 text-sm text-green-600';
        validationDiv.textContent = message;
        validationDiv.classList.remove('hidden');
    }
});

function updateFileName(input) {
    const fileName = input.files[0]?.name;
    const fileNameDiv = document.getElementById('file-name');
    
    if (fileName) {
        fileNameDiv.textContent = 'فایل انتخاب شده: ' + fileName;
        fileNameDiv.classList.remove('hidden');
    } else {
        fileNameDiv.classList.add('hidden');
    }
}
</script>
@endsection

