<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\Split;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class SplitTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Split([], $s);

        $this->assertSame('/split', $r->getRoot());
    }

    /**
     * @dataProvider splitProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $response = Mockery::mock($response);
        $s = Mockery::mock(Service::class);
        $split = new Split(['id' => 10], $s);

        if (is_array($query)) {
            $s->shouldReceive($method)->with(10, $query)->andReturn($response);
            $r = $split->$method($query);
        } else {
            $s->shouldReceive($method)->with(10, ['subaccount' => $query])->andReturn($response);
            $r = $split->$method($query);
        }

        $this->assertSame($response, $r);
    }

    public function splitProvider()
    {
        return [
            ['update', Split::class, []],
            ['addOrUpdateSubaccount', Split::class, []],
            ['removeSubaccount', BaseResource::class, 20],
        ];
    }
}
