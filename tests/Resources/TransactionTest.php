<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\Transaction;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Transaction([], $s);

        $this->assertSame('/transaction', $r->getRoot());
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testResourceMethods($method, $response)
    {
        $response = Mockery::mock($response);
        $s = Mockery::mock(Service::class);
        $p = new Transaction(['id' => 10], $s);

        $sMethod = $method == 'listDisputes' ? 'listTransactionDisputes' : $method;

        $s->shouldReceive($sMethod)->with(10)->andReturn($response);
        $r = $p->$method();

        $this->assertSame($response, $r);
    }

    public function transactionProvider()
    {
        return [
            ['verify', Transaction::class],
            ['timeline', BaseResource::class],
            ['listDisputes', BaseResource::class],
        ];
    }
}
