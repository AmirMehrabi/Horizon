<?php

namespace App\Services\Sms;

use App\Services\Sms\Gateways\NineEightSmsGateway;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private SmsGatewayInterface $gateway;

    public function __construct()
    {
        $this->gateway = $this->createGateway();
    }

    /**
     * Create the appropriate SMS gateway based on configuration.
     *
     * @return SmsGatewayInterface
     */
    private function createGateway(): SmsGatewayInterface
    {
        $gatewayType = config('sms.gateway', '0098sms');

        return match ($gatewayType) {
            '0098sms' => new NineEightSmsGateway([
                'username' => config('sms.0098sms.username'),
                'password' => config('sms.0098sms.password'),
                'domain' => config('sms.0098sms.domain'),
                'from' => config('sms.0098sms.from'),
            ]),
            // Add more gateways here in the future
            // 'kavenegar' => new KavenegarGateway([...]),
            // 'twilio' => new TwilioGateway([...]),
            default => throw new \InvalidArgumentException("Unsupported SMS gateway: {$gatewayType}"),
        };
    }

    /**
     * Send an SMS message.
     *
     * @param string $to Phone number
     * @param string $message Message content
     * @param string|null $from Sender number (optional)
     * @return array
     */
    public function send(string $to, string $message, ?string $from = null): array
    {
        return $this->gateway->send($to, $message, $from);
    }

    /**
     * Send verification code SMS in Farsi.
     *
     * @param string $to Phone number
     * @param string $code Verification code
     * @param string $type Type of verification (registration/login)
     * @return array
     */
    public function sendVerificationCode(string $to, string $code, string $type = 'registration'): array
    {
        $message = $this->getVerificationMessage($code, $type);
        return $this->send($to, $message);
    }

    /**
     * Send credentials SMS in Farsi (for registration).
     *
     * @param string $to Phone number
     * @param string $phoneNumber Customer phone number
     * @param string $code Verification code
     * @return array
     */
    public function sendRegistrationCredentials(string $to, string $phoneNumber, string $code): array
    {
        $message = $this->getRegistrationMessage($phoneNumber, $code);
        return $this->send($to, $message);
    }

    /**
     * Send login credentials SMS in Farsi.
     *
     * @param string $to Phone number
     * @param string $code Verification code
     * @return array
     */
    public function sendLoginCredentials(string $to, string $code): array
    {
        $message = $this->getLoginMessage($code);
        return $this->send($to, $message);
    }

    /**
     * Get verification message in Farsi.
     *
     * @param string $code
     * @param string $type
     * @return string
     */
    private function getVerificationMessage(string $code, string $type): string
    {
        if ($type === 'login') {
            return $this->getLoginMessage($code);
        }

        return $this->getRegistrationMessage('', $code);
    }

    /**
     * Get registration message in Farsi.
     *
     * @param string $phoneNumber
     * @param string $code
     * @return string
     */
    private function getRegistrationMessage(string $phoneNumber, string $code): string
    {
        $appName = config('app.name', 'آویاتو');
        
        $message = "سلام و خوش آمدید به {$appName}\n\n";
        $message .= "کد تأیید ثبت‌نام شما: {$code}\n\n";
        
        if (!empty($phoneNumber)) {
            $message .= "شماره تلفن: {$phoneNumber}\n";
        }
        
        $message .= "این کد به مدت ۱۵ دقیقه معتبر است.\n\n";
        $message .= "در صورت عدم درخواست این پیامک، لطفاً آن را نادیده بگیرید.";

        return $message;
    }

    /**
     * Get login message in Farsi.
     *
     * @param string $code
     * @return string
     */
    private function getLoginMessage(string $code): string
    {
        $appName = config('app.name', 'آویاتو');
        
        $message = "کد ورود به {$appName}\n\n";
        $message .= "کد تأیید شما: {$code}\n\n";
        $message .= "این کد به مدت ۱۵ دقیقه معتبر است.\n\n";
        $message .= "در صورت عدم درخواست این پیامک، لطفاً آن را نادیده بگیرید.";

        return $message;
    }
}

