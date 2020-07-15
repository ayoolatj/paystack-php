<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\Dispute;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class DisputeTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Dispute([], $s);

        $this->assertSame('/dispute', $r->getRoot());
    }

    /**
     * @dataProvider disputeProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $response = Mockery::mock($response);
        $s = Mockery::mock(Service::class);
        $d = new Dispute(['id' => 10], $s);

        if (is_array($query)) {
            $s->shouldReceive($method)->with(10, $query)->andReturn($response);
            $r = $d->$method($query);
        } else {
            $s->shouldReceive($method)->with(10)->andReturn($response);
            $r = $d->$method();
        }

        $this->assertSame($response, $r);
    }

    public function disputeProvider()
    {
        return [
            ['update', Dispute::class, []],
            ['addEvidence', BaseResource::class, []],
            ['uploadUrl', BaseResource::class],
            ['resolve', Dispute::class, []],
        ];
    }
}
