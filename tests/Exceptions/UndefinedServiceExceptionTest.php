<?php

namespace Tests\Exceptions;

use Ayoolatj\Paystack\Exceptions\UndefinedServiceException;
use PHPUnit\Framework\TestCase;

class UndefinedServiceExceptionTest extends TestCase
{
    public function testException()
    {
        $e = new UndefinedServiceException('a');

        $this->assertNotNull($e);
        $this->assertEquals('The service: a could not be found.', $e->getMessage());
        $this->assertEquals(0, $e->getCode());
    }
}
