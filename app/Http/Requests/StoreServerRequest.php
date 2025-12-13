<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServerRequest extends FormRequest
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
            // Step 1: OS Selection
            'os' => ['required', 'string', 'in:ubuntu,debian,centos,almalinux,windows,custom'],
            'image_id' => [
                'nullable',
                'uuid',
                'exists:openstack_images,id',
                function ($attribute, $value, $fail) {
                    // If custom OS is selected, image_id should be provided
                    if ($this->input('os') === 'custom' && empty($value)) {
                        $fail('برای سیستم عامل سفارشی، لطفاً یک تصویر انتخاب کنید.');
                    }
                },
            ],
            
            // Step 2: Plan Selection
            'plan_type' => ['required', 'string', 'in:prebuilt,custom'],
            'plan' => [
                'required_without:flavor_id',
                'required_if:plan_type,prebuilt',
                'nullable',
                'string',
                'in:starter,standard,pro',
            ],
            'flavor_id' => [
                'required_without:plan',
                'required_if:plan_type,prebuilt',
                'nullable',
                'uuid',
                'exists:openstack_flavors,id',
            ],
            
            // Custom plan fields
            'custom_vcpu' => ['required_if:plan_type,custom', 'integer', 'min:1', 'max:32'],
            'custom_ram' => ['required_if:plan_type,custom', 'integer', 'min:1', 'max:128'],
            'custom_storage' => ['required_if:plan_type,custom', 'integer', 'min:20', 'max:1000'],
            'custom_bandwidth' => ['nullable', 'numeric', 'min:0.1', 'max:10'],
            
            // Step 3: Network
            'create_private_network' => ['nullable', 'boolean'],
            'assign_public_ip' => ['nullable', 'boolean'],
            'network_ids' => ['nullable', 'array'],
            'network_ids.*' => ['uuid', 'exists:openstack_networks,id'],
            'security_groups' => ['nullable', 'array'],
            'security_groups.*' => ['uuid', 'exists:openstack_security_groups,id'],
            
            // Step 4: Access
            'access_method' => ['required', 'string', 'in:ssh_key,password'],
            'ssh_key_id' => ['nullable', 'uuid', 'exists:openstack_key_pairs,id'],
            'ssh_public_key' => ['required_if:access_method,ssh_key', 'nullable', 'string', 'max:2048'],
            'root_password' => ['required_if:access_method,password', 'nullable', 'string', 'min:8', 'max:128'],
            'root_password_confirmation' => ['required_if:access_method,password', 'nullable', 'string', 'same:root_password'],
            'user_data' => ['nullable', 'string', 'max:65535'],
            'auto_billing' => ['nullable', 'boolean'],
            'billing_cycle' => ['nullable', 'string', 'in:hourly,monthly'],
            
            // Optional fields
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'region' => ['nullable', 'string', 'max:100'],
            'availability_zone' => ['nullable', 'string', 'max:100'],
            'config_drive' => ['nullable', 'boolean'],
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
            // OS Selection
            'os.required' => 'لطفاً یک سیستم عامل انتخاب کنید',
            'os.in' => 'سیستم عامل انتخاب شده معتبر نیست',
            'image_id.exists' => 'تصویر انتخاب شده یافت نشد',
            'image_id.uuid' => 'شناسه تصویر معتبر نیست',
            
            // Plan Selection
            'plan_type.required' => 'لطفاً نوع پلن را انتخاب کنید',
            'plan_type.in' => 'نوع پلن معتبر نیست',
            'plan.required_if' => 'لطفاً یک پلن انتخاب کنید',
            'plan.in' => 'پلن انتخاب شده معتبر نیست',
            'flavor_id.exists' => 'فلور انتخاب شده یافت نشد',
            'flavor_id.uuid' => 'شناسه فلور معتبر نیست',
            
            // Custom Plan
            'custom_vcpu.required_if' => 'تعداد vCPU الزامی است',
            'custom_vcpu.min' => 'تعداد vCPU باید حداقل ۱ باشد',
            'custom_vcpu.max' => 'تعداد vCPU نمی‌تواند بیشتر از ۳۲ باشد',
            'custom_ram.required_if' => 'مقدار RAM الزامی است',
            'custom_ram.min' => 'مقدار RAM باید حداقل ۱ GB باشد',
            'custom_ram.max' => 'مقدار RAM نمی‌تواند بیشتر از ۱۲۸ GB باشد',
            'custom_storage.required_if' => 'فضای ذخیره‌سازی الزامی است',
            'custom_storage.min' => 'فضای ذخیره‌سازی باید حداقل ۲۰ GB باشد',
            'custom_storage.max' => 'فضای ذخیره‌سازی نمی‌تواند بیشتر از ۱۰۰۰ GB باشد',
            'custom_bandwidth.min' => 'پهنای باند باید حداقل ۰.۱ TB باشد',
            'custom_bandwidth.max' => 'پهنای باند نمی‌تواند بیشتر از ۱۰ TB باشد',
            
            // Network
            'network_ids.array' => 'شناسه‌های شبکه باید به صورت آرایه ارسال شوند',
            'network_ids.*.exists' => 'یکی از شبکه‌های انتخاب شده یافت نشد',
            'network_ids.*.uuid' => 'شناسه شبکه معتبر نیست',
            'security_groups.array' => 'گروه‌های امنیتی باید به صورت آرایه ارسال شوند',
            'security_groups.*.exists' => 'یکی از گروه‌های امنیتی انتخاب شده یافت نشد',
            'security_groups.*.uuid' => 'شناسه گروه امنیتی معتبر نیست',
            
            // Access
            'access_method.required' => 'لطفاً روش دسترسی را انتخاب کنید',
            'access_method.in' => 'روش دسترسی معتبر نیست',
            'ssh_key_id.exists' => 'کلید SSH انتخاب شده یافت نشد',
            'ssh_key_id.uuid' => 'شناسه کلید SSH معتبر نیست',
            'ssh_public_key.required_if' => 'کلید SSH الزامی است',
            'ssh_public_key.max' => 'کلید SSH نمی‌تواند بیشتر از ۲۰۴۸ کاراکتر باشد',
            'root_password.required_if' => 'رمز عبور root الزامی است',
            'root_password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد',
            'root_password.max' => 'رمز عبور نمی‌تواند بیشتر از ۱۲۸ کاراکتر باشد',
            'root_password_confirmation.same' => 'رمز عبور و تأیید رمز عبور مطابقت ندارند',
            'user_data.max' => 'User Data نمی‌تواند بیشتر از ۶۵۵۳۵ کاراکتر باشد',
            
            // Optional fields
            'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد',
            'description.max' => 'توضیحات نمی‌تواند بیشتر از ۱۰۰۰ کاراکتر باشد',
            'region.max' => 'نام منطقه نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد',
            'availability_zone.max' => 'نام Availability Zone نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد',
            'billing_cycle.in' => 'دوره صورتحساب معتبر نیست (hourly یا monthly)',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox values to boolean
        $this->merge([
            'create_private_network' => $this->has('create_private_network'),
            'assign_public_ip' => $this->has('assign_public_ip'),
            'auto_billing' => $this->has('auto_billing') ? true : ($this->input('auto_billing', true)),
            'config_drive' => $this->has('config_drive'),
        ]);

        // Ensure security_groups is an array
        if ($this->has('security_groups') && !is_array($this->input('security_groups'))) {
            $this->merge([
                'security_groups' => array_filter(explode(',', $this->input('security_groups'))),
            ]);
        }

        // Ensure network_ids is an array
        if ($this->has('network_ids') && !is_array($this->input('network_ids'))) {
            $this->merge([
                'network_ids' => array_filter(explode(',', $this->input('network_ids'))),
            ]);
        }
    }
}
