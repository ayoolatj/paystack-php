<?php

namespace Ayoolatj\Paystack;

use Ayoolatj\Paystack\Exceptions\SignatureVerificationException;

class Webhook
{
    /**
     * Verify paystack event.
     *
     * @param string $eventBody
     * @param string $paystackSigHeader
     * @param string $secret
     *
     * @return bool
     * @throws \Ayoolatj\Paystack\Exceptions\SignatureVerificationException
     */
    public static function verifyEvent($eventBody, $paystackSigHeader, $secret)
    {
        if ($paystackSigHeader !== hash_hmac('sha512', $eventBody, $secret)) {
            throw new SignatureVerificationException('Unable to verify paystack event', $eventBody, $paystackSigHeader);
        }

        return true;
    }
}
