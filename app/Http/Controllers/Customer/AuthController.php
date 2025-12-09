<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Customer;
use App\Models\CustomerVerificationCode;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Laravel 12 uses different middleware registration
    }

    /**
     * Show the customer registration form.
     *
     * @return View
     */
    public function showRegistrationForm(): View
    {
        return view('customer.auth.register');
    }

    /**
     * Show the customer login form.
     *
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('customer.auth.login');
    }

    /**
     * Show the verification form.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function showVerificationForm(Request $request): View|RedirectResponse
    {
        $phoneNumber = $request->session()->get('verification_phone');
        
        if (!$phoneNumber) {
            return redirect()->route('customer.register')
                ->with('error', 'Please start the registration process again.');
        }

        return view('customer.auth.verify', compact('phoneNumber'));
    }

    /**
     * Handle customer registration request.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function register(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone_number' => ['required', 'string', 'max:20', 'unique:customers,phone_number'],
            'email' => ['nullable', 'email', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
        ]);

        // Clean phone number
        $phoneNumber = preg_replace('/[^0-9+]/', '', $request->phone_number);

        // Create customer record
        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $phoneNumber,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'status' => Customer::STATUS_PENDING,
        ]);

        // Generate verification code
        $verificationCode = CustomerVerificationCode::generateCode(
            $phoneNumber,
            CustomerVerificationCode::TYPE_REGISTRATION,
            $request->ip(),
            $request->userAgent()
        );

        // Store phone number in session for verification
        $request->session()->put('verification_phone', $phoneNumber);
        $request->session()->put('customer_id', $customer->id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Verification code sent to your phone.',
                'redirect' => route('customer.verify'),
            ]);
        }

        return redirect()->route('customer.verify')
            ->with('success', 'Registration successful! Please verify your phone number.');
    }

    /**
     * Handle phone number verification.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function verify(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $phoneNumber = $request->session()->get('verification_phone');
        $customerId = $request->session()->get('customer_id');

        if (!$phoneNumber || !$customerId) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please start registration again.',
                ], 400);
            }

            return redirect()->route('customer.register')
                ->with('error', 'Session expired. Please start registration again.');
        }

        $result = CustomerVerificationCode::verifyCode(
            $phoneNumber,
            $request->code,
            CustomerVerificationCode::TYPE_REGISTRATION
        );

        if (!$result['success']) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                ], 400);
            }

            return back()->withErrors(['code' => $result['message']]);
        }

        // Mark customer as verified and active
        $customer = Customer::find($customerId);
        $customer->markPhoneAsVerified();

        // Log in the customer
        Auth::guard('customer')->login($customer);
        $customer->updateLastLogin();

        // Clear session data
        $request->session()->forget(['verification_phone', 'customer_id']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Phone verified successfully!',
                'redirect' => 'https://panel.aviato.ir/dashboard',
            ]);
        }

        return redirect()->intended('https://panel.aviato.ir/dashboard')
            ->with('success', 'Welcome! Your account has been verified.');
    }

    /**
     * Handle customer login request.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function login(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'phone_number' => ['required', 'string'],
        ]);

        // Clean phone number
        $phoneNumber = preg_replace('/[^0-9+]/', '', $request->phone_number);

        // Check if customer exists and is active
        $customer = Customer::where('phone_number', $phoneNumber)
            ->where('status', Customer::STATUS_ACTIVE)
            ->first();

        if (!$customer) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active account found with this phone number.',
                ], 404);
            }

            return back()->withErrors([
                'phone_number' => 'No active account found with this phone number.'
            ]);
        }

        // Generate login verification code
        $verificationCode = CustomerVerificationCode::generateCode(
            $phoneNumber,
            CustomerVerificationCode::TYPE_LOGIN,
            $request->ip(),
            $request->userAgent()
        );

        // Store phone number in session
        $request->session()->put('login_phone', $phoneNumber);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Verification code sent to your phone.',
                'show_verification' => true,
            ]);
        }

        return view('customer.auth.login-verify', compact('phoneNumber'));
    }

    /**
     * Handle login verification.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function verifyLogin(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $phoneNumber = $request->session()->get('login_phone');

        if (!$phoneNumber) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please try logging in again.',
                ], 400);
            }

            return redirect()->route('customer.login')
                ->with('error', 'Session expired. Please try logging in again.');
        }

        $result = CustomerVerificationCode::verifyCode(
            $phoneNumber,
            $request->code,
            CustomerVerificationCode::TYPE_LOGIN
        );

        if (!$result['success']) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                ], 400);
            }

            return back()->withErrors(['code' => $result['message']]);
        }

        // Find and log in the customer
        $customer = Customer::where('phone_number', $phoneNumber)->first();
        Auth::guard('customer')->login($customer, true); // Remember the customer
        $customer->updateLastLogin();

        // Clear session data
        $request->session()->forget('login_phone');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => 'https://panel.aviato.ir/dashboard',
            ]);
        }

        return redirect()->intended('https://panel.aviato.ir/dashboard')
            ->with('success', 'Welcome back!');
    }

    /**
     * Resend verification code.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resendCode(Request $request): JsonResponse
    {
        $phoneNumber = $request->session()->get('verification_phone') 
                      ?? $request->session()->get('login_phone');
        
        if (!$phoneNumber) {
            return response()->json([
                'success' => false,
                'message' => 'No phone number found in session.',
            ], 400);
        }

        $type = $request->session()->has('verification_phone') 
                ? CustomerVerificationCode::TYPE_REGISTRATION 
                : CustomerVerificationCode::TYPE_LOGIN;

        $verificationCode = CustomerVerificationCode::generateCode(
            $phoneNumber,
            $type,
            $request->ip(),
            $request->userAgent()
        );

        return response()->json([
            'success' => true,
            'message' => 'New verification code sent to your phone.',
        ]);
    }

    /**
     * Handle customer logout request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('https://panel.aviato.ir/login');
    }
}
