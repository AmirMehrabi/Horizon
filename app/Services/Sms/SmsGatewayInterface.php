<?php

namespace App\Services\Sms;

interface SmsGatewayInterface
{
    /**
     * Send an SMS message.
     *
     * @param string $to Phone number in international format
     * @param string $message Message content
     * @param string|null $from Sender number (optional, may be provider-specific)
     * @return array Result array with 'success' boolean and 'message' string
     */
    public function send(string $to, string $message, ?string $from = null): array;

    /**
     * Get the gateway name.
     *
     * @return string
     */
    public function getName(): string;
}

