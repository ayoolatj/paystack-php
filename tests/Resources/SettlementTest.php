<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\Settlement;
use Ayoolatj\Paystack\Services\Service;
use Ayoolatj\Paystack\Support\Paginator;
use Mockery;
use PHPUnit\Framework\TestCase;

class SettlementTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Settlement([], $s);

        $this->assertSame('/settlement', $r->getRoot());
    }

    /**
     * @dataProvider settlementProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $response = Mockery::mock($response);
        $s = Mockery::mock(Service::class);
        $settlement = new Settlement(['id' => 10], $s);

        $s->shouldReceive($method)->with(10, $query)->andReturn($response);
        $r = $settlement->$method($query);


        $this->assertSame($response, $r);
    }

    public function settlementProvider()
    {
        return [
            ['transactions', Paginator::class, []],
        ];
    }
}
