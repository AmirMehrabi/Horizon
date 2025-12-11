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
            'image_id' => ['nullable', 'uuid', 'exists:openstack_images,id'],
            
            // Step 2: Plan Selection
            'plan_type' => ['required', 'string', 'in:prebuilt,custom'],
            'plan' => ['required_if:plan_type,prebuilt', 'string', 'in:starter,standard,pro'],
            'flavor_id' => ['nullable', 'uuid', 'exists:openstack_flavors,id'],
            
            // Custom plan fields
            'custom_vcpu' => ['required_if:plan_type,custom', 'integer', 'min:1', 'max:32'],
            'custom_ram' => ['required_if:plan_type,custom', 'integer', 'min:1', 'max:128'],
            'custom_storage' => ['required_if:plan_type,custom', 'integer', 'min:20', 'max:1000'],
            'custom_bandwidth' => ['nullable', 'numeric', 'min:0.1', 'max:10'],
            
            // Step 3: Network
            'create_private_network' => ['nullable', 'boolean'],
            'assign_public_ip' => ['nullable', 'boolean'],
            'security_groups' => ['nullable', 'array'],
            'security_groups.*' => ['string'],
            
            // Step 4: Access
            'access_method' => ['required', 'string', 'in:ssh_key,password'],
            'ssh_key_id' => ['nullable', 'string'],
            'ssh_public_key' => ['required_if:access_method,ssh_key', 'nullable', 'string'],
            'root_password' => ['required_if:access_method,password', 'nullable', 'string', 'min:8'],
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
            'os.required' => 'لطفاً یک سیستم عامل انتخاب کنید',
            'plan_type.required' => 'لطفاً نوع پلن را انتخاب کنید',
            'plan.required_if' => 'لطفاً یک پلن انتخاب کنید',
            'access_method.required' => 'لطفاً روش دسترسی را انتخاب کنید',
            'ssh_public_key.required_if' => 'کلید SSH الزامی است',
            'root_password.required_if' => 'رمز عبور root الزامی است',
            'root_password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد',
            'root_password_confirmation.same' => 'رمز عبور و تأیید رمز عبور مطابقت ندارند',
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
    }
}
