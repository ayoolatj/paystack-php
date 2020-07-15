<?php

namespace Tests;

use Ayoolatj\Paystack\Exceptions\UndefinedServiceException;
use Ayoolatj\Paystack\Paystack;
use Ayoolatj\Paystack\Services\Service;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\TestCase;

class PaystackTest extends TestCase
{
    public function testConstructWithInvalidKey()
    {
        $this->expectException(InvalidArgumentException::class);

        new Paystack('key');
    }

    public function testConstructorWithClient()
    {
        $http = Mockery::mock('GuzzleHttp\Client');

        $p = new Paystack('sk_', $http);

        $this->assertSame($http, $p->client);
    }

    public function testGetDefinedService()
    {
        $paystack = new Paystack('sk_');
        $service = $paystack->__get('transactions');

        $this->assertInstanceOf(Service::class, $service);
    }

    public function testUndefinedServiceException()
    {
        $this->expectException(UndefinedServiceException::class);

        $paystack = new Paystack('sk_');
        $paystack->__get('undefinedService');
    }
}
