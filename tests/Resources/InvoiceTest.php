<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\Invoice;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Invoice([], $s);

        $this->assertSame('/paymentrequest', $r->getRoot());
    }

    /**
     * @dataProvider disputeProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $s = Mockery::mock(Service::class);
        $i = new Invoice(['id' => 10], $s);

        if (is_array($query)) {
            $s->shouldReceive($method)->with(10, $query)->andReturn($response);
            $r = $i->$method($query);
        } else {
            $s->shouldReceive($method)->with(10)->andReturn($response);
            $r = $i->$method();
        }

        $this->assertSame($response, $r);
    }

    public function disputeProvider()
    {
        $q = [];
        $r = Mockery::mock(Invoice::class);
        $bR = Mockery::mock(BaseResource::class);

        return [
            ['verify', $r],
            ['notify', $bR],
            ['update', $r, $q],
            ['finalize', $r],
            ['archive', $bR],
        ];
    }
}
