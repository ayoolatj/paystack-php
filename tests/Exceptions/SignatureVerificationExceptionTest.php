<?php

namespace Tests\Exceptions;

use Ayoolatj\Paystack\Exceptions\SignatureVerificationException;
use PHPUnit\Framework\TestCase;

class SignatureVerificationExceptionTest extends TestCase
{
    public function testException()
    {
        $e = new SignatureVerificationException('a', 'b', 'c');

        $this->assertNotNull($e);
        $this->assertEquals('a', $e->getMessage());
        $this->assertEquals('b', $e->getHttpBody());
        $this->assertEquals('c', $e->getSigHeader());
        $this->assertEquals(0, $e->getCode());
    }
}
