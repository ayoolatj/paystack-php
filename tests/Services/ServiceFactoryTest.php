<?php

namespace Tests\Services;

use Ayoolatj\Paystack\Exceptions\UndefinedServiceException;
use Ayoolatj\Paystack\Paystack;
use Ayoolatj\Paystack\Services\Service;
use Ayoolatj\Paystack\Services\ServiceFactory;
use PHPUnit\Framework\TestCase;

class ServiceFactoryTest extends TestCase
{
    /**
     * @var \Ayoolatj\Paystack\Services\ServiceFactory
     */
    private $sf;

    public function setUp(): void
    {
        $p = new Paystack('sk_');
        $this->sf = new ServiceFactory($p);
    }

    public function testGetDefinedService()
    {
        $service = $this->sf->__get('transactions');

        $this->assertInstanceOf(Service::class, $service);
    }

    public function testUndefinedServiceException()
    {
        $this->expectException(UndefinedServiceException::class);

        $this->sf->__get('undefinedService');
    }

    public function testReturnSameObjectForMultipleSameServiceCall()
    {

        $transactions1 = $this->sf->__get('transactions');
        $transactions2 = $this->sf->__get('transactions');

        $this->assertSame($transactions1, $transactions2);
    }
}
