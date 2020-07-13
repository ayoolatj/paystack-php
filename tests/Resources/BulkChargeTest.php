<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\BulkCharge;
use Ayoolatj\Paystack\Services\Service;
use Ayoolatj\Paystack\Support\Paginator;
use Mockery;
use PHPUnit\Framework\TestCase;

class BulkChargeTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $b = new BulkCharge([], $s);

        $this->assertSame('/bulkcharge', $b->getRoot());
    }

    /**
     * @dataProvider bulkChargeProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $s = Mockery::mock(Service::class);
        $b = new BulkCharge(['batch_code' => 10], $s);

        if (is_array($query)) {
            $s->shouldReceive($method)->with(10, $query)->andReturn($response);
            $r = $b->$method($query);
        } else {
            $s->shouldReceive($method)->andReturn($response);
            $r = $b->$method();
        }

        $this->assertSame($response, $r);
    }

    public function bulkChargeProvider()
    {
        $q = [];
        $bR = Mockery::mock(BaseResource::class);

        return [
            ['pause', $bR],
            ['fetchCharges', Mockery::mock(Paginator::class), $q],
            ['resume', $bR]
        ];
    }
}
