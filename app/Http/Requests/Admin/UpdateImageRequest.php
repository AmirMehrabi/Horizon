<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateImageRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'visibility' => ['required', 'string', Rule::in(['public', 'private', 'shared', 'community'])],
            'min_disk' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'min_ram' => ['nullable', 'integer', 'min:1', 'max:512'],
            'metadata' => ['nullable', 'array'],
            'metadata.*' => ['string', 'max:255'],
            'project_ids' => ['nullable', 'array'],
            'project_ids.*' => ['uuid', 'exists:openstack_projects,id'],
        ];
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
            'visibility.required' => 'نوع دسترسی الزامی است',
            'visibility.in' => 'نوع دسترسی معتبر نیست',
            'min_disk.min' => 'حداقل دیسک باید حداقل ۱ گیگابایت باشد',
            'min_disk.max' => 'حداقل دیسک نمی‌تواند بیشتر از ۱۰۰۰ گیگابایت باشد',
            'min_ram.min' => 'حداقل RAM باید حداقل ۱ گیگابایت باشد',
            'min_ram.max' => 'حداقل RAM نمی‌تواند بیشتر از ۵۱۲ گیگابایت باشد',
        ];
    }
}

