<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\Plan;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class PlanTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Plan([], $s);

        $this->assertSame('/plan', $r->getRoot());
    }

    /**
     * @dataProvider planProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $s = Mockery::mock(Service::class);
        $p = new Plan(['id' => 10], $s);

        if (is_array($query)) {
            $s->shouldReceive($method)->with(10, $query)->andReturn($response);
            $r = $p->$method($query);
        } else {
            $s->shouldReceive($method)->with(10)->andReturn($response);
            $r = $p->$method();
        }

        $this->assertSame($response, $r);
    }

    public function planProvider()
    {
        $q = [];
        $r = Mockery::mock(Plan::class);
        $bR = Mockery::mock(BaseResource::class);

        return [
            ['update', $r, $q],
            ['delete', $bR],
        ];
    }
}
