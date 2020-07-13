<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\Transfer;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransferTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Transfer([], $s);

        $this->assertSame('/transfer', $r->getRoot());
    }

    /**
     * @dataProvider transferProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $s = Mockery::mock(Service::class);
        $p = new Transfer(['transfer_code' => 10], $s);

        if ($query) {
            $data = ['transfer_code' => 10, 'otp' => $query];
            $s->shouldReceive($method)->with($data)->andReturn($response);
            $r = $p->$method($query);
        } else {
            $s->shouldReceive($method)->with(10)->andReturn($response);
            $r = $p->$method();
        }

        $this->assertSame($response, $r);
    }

    public function transferProvider()
    {
        $r = Mockery::mock(Transfer::class);

        return [
            ['finalize', $r, '1234'],
            ['verify', $r],
        ];
    }
}
