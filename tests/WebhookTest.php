<?php

namespace Tests;

use Ayoolatj\Paystack\Exceptions\SignatureVerificationException;
use Ayoolatj\Paystack\Webhook;
use PHPUnit\Framework\TestCase;

class WebhookTest extends TestCase
{
    public function testVerifyWebhookEvent()
    {
        $eventBody = 'eventBody';
        $secret = 'secret';
        $paystackSigHeader = hash_hmac('sha512', $eventBody, $secret);

        $verify = Webhook::verifyEvent($eventBody, $paystackSigHeader, $secret);

        $this->assertTrue($verify);
    }

    public function testSignatureVerificationException()
    {
        $this->expectException(SignatureVerificationException::class);

        Webhook::verifyEvent('', '', '');
    }
}
