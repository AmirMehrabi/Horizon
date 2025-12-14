<?php

namespace App\Services\Sms\Gateways;

use App\Services\Sms\SmsGatewayInterface;
use Illuminate\Support\Facades\Log;
use SoapClient;

class NineEightSmsGateway implements SmsGatewayInterface
{
    private string $username;
    private string $password;
    private string $domain;
    private string $from;
    private ?SoapClient $client = null;

    public function __construct(array $config)
    {
        $this->username = $config['username'] ?? '';
        $this->password = $config['password'] ?? '';
        $this->domain = $config['domain'] ?? '';
        $this->from = $config['from'] ?? '';
    }

    /**
     * Send an SMS message via 0098sms gateway.
     *
     * @param string $to Phone number (will be formatted to: 09xxxxxxxxx)
     * @param string $message Message content
     * @param string|null $from Sender number (optional, uses config default)
     * @return array
     */
    public function send(string $to, string $message, ?string $from = null): array
    {
        try {
            // Format phone number: remove + and ensure it's in the correct format
            $to = $this->formatPhoneNumber($to);
            $from = $from ?? $this->from;

            // Validate required parameters
            if (empty($this->username)) {
                return [
                    'success' => false,
                    'message' => 'SMS gateway username not configured',
                    'error_code' => 5,
                ];
            }

            if (empty($this->password)) {
                return [
                    'success' => false,
                    'message' => 'SMS gateway password not configured',
                    'error_code' => 6,
                ];
            }

            if (empty($this->domain)) {
                return [
                    'success' => false,
                    'message' => 'SMS gateway domain not configured',
                    'error_code' => 7,
                ];
            }

            if (empty($from)) {
                return [
                    'success' => false,
                    'message' => 'SMS gateway sender number not configured',
                    'error_code' => 3,
                ];
            }

            if (empty($message)) {
                return [
                    'success' => false,
                    'message' => 'SMS message text not provided',
                    'error_code' => 4,
                ];
            }

            // Initialize SOAP client
            if (!$this->client) {
                ini_set("soap.wsdl_cache_enabled", "0");
                $this->client = new SoapClient(
                    'https://webservice.0098sms.com/service.asmx?wsdl',
                    ['encoding' => 'UTF-8']
                );
            }

            // Prepare parameters
            $parameters = [
                'username' => $this->username,
                'password' => $this->password,
                'mobileno' => $to,
                'pnlno' => $from,
                'text' => $message,
                'isflash' => false,
            ];

            // Send SMS
            $result = $this->client->SendSMS($parameters);
            $resultCode = $result->SendSMSResult ?? null;

            // Check result code
            if ($resultCode === 0 || $resultCode === '0') {
                Log::info('SMS sent successfully via 0098sms', [
                    'to' => $to,
                    'from' => $from,
                    'gateway' => $this->getName(),
                ]);

                return [
                    'success' => true,
                    'message' => 'SMS sent successfully',
                    'error_code' => 0,
                ];
            }

            // Handle error codes
            $errorMessage = $this->getErrorMessage($resultCode);
            
            Log::error('SMS sending failed via 0098sms', [
                'to' => $to,
                'from' => $from,
                'error_code' => $resultCode,
                'error_message' => $errorMessage,
            ]);

            return [
                'success' => false,
                'message' => $errorMessage,
                'error_code' => $resultCode,
            ];

        } catch (\SoapFault $e) {
            Log::error('SOAP error when sending SMS via 0098sms', [
                'to' => $to,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            return [
                'success' => false,
                'message' => 'SMS gateway connection error: ' . $e->getMessage(),
                'error_code' => -1,
            ];
        } catch (\Exception $e) {
            Log::error('Error sending SMS via 0098sms', [
                'to' => $to,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'SMS sending failed: ' . $e->getMessage(),
                'error_code' => -1,
            ];
        }
    }

    /**
     * Format phone number to 0098sms format (09xxxxxxxxx).
     * 
     * Accepts various formats and converts to: 09xxxxxxxxx (11 digits)
     * Examples:
     * - +989123456789 → 09123456789
     * - 00989123456789 → 09123456789
     * - 989123456789 → 09123456789
     * - 9123456789 → 09123456789
     * - 09123456789 → 09123456789
     *
     * @param string $phoneNumber
     * @return string
     */
    private function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Handle different input formats
        if (strlen($phone) === 13 && strpos($phone, '0098') === 0) {
            // Format: 00989123456789 → 09123456789
            $phone = '0' . substr($phone, 4);
        } elseif (strlen($phone) === 12 && strpos($phone, '0098') === 0) {
            // Format: 0098123456789 → 09123456789 (if somehow missing a digit)
            $phone = '0' . substr($phone, 4);
        } elseif (strlen($phone) === 12 && strpos($phone, '98') === 0) {
            // Format: 989123456789 → 09123456789
            $phone = '0' . substr($phone, 2);
        } elseif (strlen($phone) === 11 && strpos($phone, '98') === 0) {
            // Format: 98123456789 → 09123456789
            $phone = '0' . substr($phone, 2);
        } elseif (strlen($phone) === 10 && strpos($phone, '9') === 0) {
            // Format: 9123456789 → 09123456789
            $phone = '0' . $phone;
        } elseif (strlen($phone) === 11 && strpos($phone, '0') === 0 && strpos($phone, '09') === 0) {
            // Format: 09123456789 → 09123456789 (already correct)
            // Do nothing, already in correct format
        } elseif (strlen($phone) === 11 && strpos($phone, '0') === 0) {
            // Format: 01234567890 → might need adjustment, but keep as is for now
            // This shouldn't happen for Iranian mobile numbers, but handle gracefully
        } else {
            // If we can't determine the format, try to extract the last 10 digits and add 0
            if (strlen($phone) >= 10) {
                $last10 = substr($phone, -10);
                if (strpos($last10, '9') === 0) {
                    $phone = '0' . $last10;
                } else {
                    // Fallback: try to construct from what we have
                    $phone = '0' . $last10;
                }
            }
        }

        // Final validation: ensure it's exactly 11 digits starting with 09
        if (strlen($phone) === 11 && strpos($phone, '09') === 0) {
            return $phone;
        }

        // Log warning if format is still incorrect
        Log::warning('Phone number format may be incorrect for 0098sms', [
            'original' => $phoneNumber,
            'formatted' => $phone,
            'length' => strlen($phone),
        ]);

        // Return formatted phone (even if not perfect, let the gateway handle validation)
        return $phone;
    }

    /**
     * Get error message from error code.
     *
     * @param int|string $errorCode
     * @return string
     */
    private function getErrorMessage($errorCode): string
    {
        $errorMessages = [
            1 => 'شماره گیرنده اشتباه است',
            2 => 'گیرنده تعریف نشده است',
            3 => 'فرستنده تعریف نشده است',
            4 => 'متن تنظیم نشده است',
            5 => 'نام کاربری تنظیم نشده است',
            6 => 'کلمه عبور تنظیم نشده است',
            7 => 'نام دامین تنظیم نشده است',
            8 => 'مجوز شما باطل شده است',
            9 => 'اعتبار پیامک شما کافی نیست',
            10 => 'برای این شماره لینک تعریف نشده است',
            11 => 'عدم مجوز برای اتصال لینک',
            12 => 'نام کاربری و کلمه ی عبور اشتباه است',
            13 => 'کاراکتر غیرمجاز در متن وجود دارد',
            14 => 'سقف ارسال روزانه پر شده است',
            16 => 'عدم مجوز شماره برای ارسال از لینک',
            17 => 'خطا در شماره پنل. لطفا با پشتیبانی تماس بگیرید',
            18 => 'اتمام تاریخ اعتبار شماره پنل. برای استفاده تمدید شود',
            19 => 'تنظیمات کد opt انجام نشده است',
            20 => 'فرمت کد opt صحیح نیست',
            21 => 'تنظیمات کد opt توسط ادمین تایید نشده است',
            22 => 'اطلاعات مالک شماره ثبت و تایید نشده است',
            23 => 'هنوز اجازه ارسال به این شماره پنل داده نشده است',
            24 => 'ارسال از IP غیرمجاز انجام شده است',
        ];

        return $errorMessages[$errorCode] ?? "خطای نامشخص (کد: {$errorCode})";
    }

    /**
     * Get the gateway name.
     *
     * @return string
     */
    public function getName(): string
    {
        return '0098sms';
    }
}

