<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerApiKey;
use App\Models\CustomerActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display profile management page with tabs
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        if (!$customer) {
            return redirect()->route('customer.login');
        }

        // Format user data for view
        $user = [
            'id' => $customer->id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'phone' => $customer->phone_number,
            'national_id' => $customer->preferences['national_id'] ?? null,
            'company' => $customer->company_name,
            'address' => $customer->address,
            'city' => $customer->city,
            'postal_code' => $customer->postal_code,
            'country' => $customer->country,
            'avatar' => null,
            'created_at' => $customer->created_at ? $customer->created_at->format('Y/m/d') : null,
        ];

        // 2FA is disabled as per user request
        $twoFactorEnabled = false;
        $twoFactorSecret = null;
        $recoveryCodes = [];

        // Get real API keys
        $apiKeys = $customer->apiKeys()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($key) {
                return [
                    'id' => $key->id,
                    'name' => $key->name,
                    'key' => $key->key,
                    'last_used' => $key->last_used_at 
                        ? $key->last_used_at->format('Y/m/d - H:i') 
                        : 'هرگز',
                    'created_at' => $key->created_at->format('Y/m/d'),
                    'permissions' => $key->permissions ?? ['read'],
                ];
            })
            ->toArray();

        // Get real activity logs
        $activityLogs = $customer->activityLogs()
            ->take(50)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'action' => $log->action,
                    'ip' => $log->ip_address ?? 'نامشخص',
                    'location' => $log->location ?? 'نامشخص',
                    'device' => $log->device ?? 'Unknown',
                    'timestamp' => $log->created_at->format('Y/m/d - H:i'),
                    'status' => $log->status === 'success' ? 'موفق' : 'ناموفق',
                ];
            })
            ->toArray();

        // Log profile view (only if not already logged recently to avoid spam)
        $recentLog = $customer->activityLogs()
            ->where('action', 'مشاهده پروفایل')
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();
        
        if (!$recentLog) {
            CustomerActivityLog::log(
                $customer->id,
                'مشاهده پروفایل',
                'success',
                request()->ip(),
                request()->userAgent()
            );
        }

        return view('customer.profile.index', compact('user', 'twoFactorEnabled', 'twoFactorSecret', 'recoveryCodes', 'apiKeys', 'activityLogs'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'national_id' => ['nullable', 'string', 'max:20'],
            'company' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.profile.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Update customer data
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone;
        $customer->company_name = $request->company;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->postal_code = $request->postal_code;
        $customer->country = $request->country ?? $customer->country;
        
        // Store national_id in preferences
        $preferences = $customer->preferences ?? [];
        if ($request->national_id) {
            $preferences['national_id'] = $request->national_id;
        }
        $customer->preferences = $preferences;
        
        $customer->save();

        // Log activity
        CustomerActivityLog::log(
            $customer->id,
            'به‌روزرسانی پروفایل',
            'success',
            $request->ip(),
            $request->userAgent(),
            ['fields' => array_keys($request->except(['_token']))]
        );

        return redirect()->route('customer.profile.index')
            ->with('success', 'اطلاعات پروفایل با موفقیت به‌روزرسانی شد');
    }

    /**
     * Show 2FA setup page
     */
    public function show2FA()
    {
        // 2FA is disabled - redirect to profile
        return redirect()->route('customer.profile.index');
    }

    /**
     * Enable 2FA
     */
    public function enable2FA(Request $request)
    {
        // 2FA is disabled - redirect to profile
        return redirect()->route('customer.profile.index');
    }

    /**
     * Disable 2FA
     */
    public function disable2FA(Request $request)
    {
        // 2FA is disabled - redirect to profile
        return redirect()->route('customer.profile.index');
    }

    /**
     * Show change password form
     */
    public function showChangePassword()
    {
        return redirect()->route('customer.profile.index');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => $customer->password ? ['required', 'string'] : ['nullable'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.profile.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Check if customer has a password set
        // Since customers use SMS authentication, we'll check if password exists
        // If not, we'll create one. Otherwise, verify current password.
        if ($customer->password) {
            if (!Hash::check($request->current_password, $customer->password)) {
                CustomerActivityLog::log(
                    $customer->id,
                    'تلاش برای تغییر رمز عبور',
                    'failed',
                    $request->ip(),
                    $request->userAgent()
                );

                return redirect()->route('customer.profile.index')
                    ->withErrors(['current_password' => 'رمز عبور فعلی اشتباه است'])
                    ->withInput();
            }
        }
        // If no password is set, we allow setting a new password without current password verification
        // This is acceptable since customers use SMS authentication as primary method

        // Update password (using mutator which will hash it)
        $customer->password = $request->new_password;
        $customer->save();

        // Log activity
        CustomerActivityLog::log(
            $customer->id,
            'تغییر رمز عبور',
            'success',
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->route('customer.profile.index')
            ->with('success', 'رمز عبور با موفقیت تغییر کرد');
    }

    /**
     * Create new API key
     */
    public function createApiKey(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['in:read,write'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.profile.index')
                ->withErrors($validator)
                ->withInput();
        }

        $permissions = $request->permissions ?? ['read'];
        
        // Create API key
        $apiKey = CustomerApiKey::createForCustomer(
            $customer->id,
            $request->name,
            $permissions
        );

        // Log activity
        CustomerActivityLog::log(
            $customer->id,
            'ایجاد کلید API',
            'success',
            $request->ip(),
            $request->userAgent(),
            ['api_key_id' => $apiKey->id, 'name' => $apiKey->name]
        );

        // Store the key in session to show it once
        $request->session()->flash('api_key_created', $apiKey->key);

        return redirect()->route('customer.profile.index')
            ->with('success', 'کلید API جدید ایجاد شد. لطفاً آن را ذخیره کنید - دیگر نمایش داده نخواهد شد.');
    }

    /**
     * Delete API key
     */
    public function deleteApiKey(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();
        
        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $apiKey = CustomerApiKey::where('customer_id', $customer->id)
            ->where('id', $id)
            ->first();

        if (!$apiKey) {
            return redirect()->route('customer.profile.index')
                ->with('error', 'کلید API یافت نشد');
        }

        $apiKeyName = $apiKey->name;
        $apiKey->delete();

        // Log activity
        CustomerActivityLog::log(
            $customer->id,
            'حذف کلید API',
            'success',
            $request->ip(),
            $request->userAgent(),
            ['api_key_name' => $apiKeyName]
        );

        return redirect()->route('customer.profile.index')
            ->with('success', 'کلید API حذف شد');
    }
}
