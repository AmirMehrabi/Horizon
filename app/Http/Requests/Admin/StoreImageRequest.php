<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'disk_format' => ['required', 'string', Rule::in(['qcow2', 'raw', 'iso', 'vhd', 'vmdk', 'vdi'])],
            'container_format' => ['nullable', 'string', Rule::in(['bare', 'ovf', 'aki', 'ari', 'ami'])],
            'visibility' => ['required', 'string', Rule::in(['public', 'private', 'shared', 'community'])],
            'min_disk' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'min_ram' => ['nullable', 'integer', 'min:1', 'max:512'],
            'upload_method' => ['required', 'string', Rule::in(['file', 'url'])],
            'image_file' => [
                'required_if:upload_method,file',
                'nullable',
                'file',
                'mimes:qcow2,raw,iso,vhd,vmdk,vdi',
                'max:' . (10 * 1024), // 10 GB in MB
            ],
            'image_url' => [
                'required_if:upload_method,url',
                'nullable',
                'url',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($this->input('upload_method') === 'url' && $value) {
                        // Validate URL scheme
                        $parsedUrl = parse_url($value);
                        if (!in_array($parsedUrl['scheme'] ?? '', ['http', 'https'])) {
                            $fail('Only HTTP and HTTPS URLs are allowed.');
                        }

                        // Validate file extension
                        $path = parse_url($value, PHP_URL_PATH);
                        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                        $allowedExtensions = ['qcow2', 'raw', 'iso', 'vhd', 'vmdk', 'vdi'];
                        
                        if (!in_array($extension, $allowedExtensions)) {
                            $fail('Invalid file type in URL. Allowed extensions: ' . implode(', ', $allowedExtensions));
                        }

                        // Check for private IPs
                        $host = $parsedUrl['host'] ?? '';
                        if (filter_var($host, FILTER_VALIDATE_IP)) {
                            if (!filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                                $fail('Private or reserved IP addresses are not allowed.');
                            }
                        }
                    }
                },
            ],
            'metadata' => ['nullable', 'array'],
            'metadata.*' => ['string', 'max:255'],
            'project_ids' => ['nullable', 'array'],
            'project_ids.*' => ['uuid', 'exists:openstack_projects,id'],
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'نام Image الزامی است',
            'name.max' => 'نام Image نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد',
            'disk_format.required' => 'فرمت دیسک الزامی است',
            'disk_format.in' => 'فرمت دیسک معتبر نیست',
            'visibility.required' => 'نوع دسترسی الزامی است',
            'visibility.in' => 'نوع دسترسی معتبر نیست',
            'upload_method.required' => 'روش آپلود الزامی است',
            'upload_method.in' => 'روش آپلود معتبر نیست',
            'image_file.required_if' => 'فایل Image الزامی است',
            'image_file.file' => 'فایل ارسالی معتبر نیست',
            'image_file.mimes' => 'فرمت فایل باید یکی از موارد زیر باشد: qcow2, raw, iso, vhd, vmdk, vdi',
            'image_file.max' => 'حجم فایل نمی‌تواند بیشتر از ۱۰ گیگابایت باشد',
            'image_url.required_if' => 'آدرس URL Image الزامی است',
            'image_url.url' => 'آدرس URL معتبر نیست',
            'min_disk.min' => 'حداقل دیسک باید حداقل ۱ گیگابایت باشد',
            'min_disk.max' => 'حداقل دیسک نمی‌تواند بیشتر از ۱۰۰۰ گیگابایت باشد',
            'min_ram.min' => 'حداقل RAM باید حداقل ۱ گیگابایت باشد',
            'min_ram.max' => 'حداقل RAM نمی‌تواند بیشتر از ۵۱۲ گیگابایت باشد',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set default container format if not provided
        if (!$this->has('container_format')) {
            $this->merge(['container_format' => 'bare']);
        }
    }
}

