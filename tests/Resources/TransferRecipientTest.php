<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\TransferRecipient;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransferRecipientTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new TransferRecipient([], $s);

        $this->assertSame('/transferrecipient', $r->getRoot());
    }

    /**
     * @dataProvider transferRecipientProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $response = Mockery::mock($response);
        $s = Mockery::mock(Service::class);
        $p = new TransferRecipient(['id' => 10], $s);

        if (is_array($query)) {
            $s->shouldReceive($method)->with(10, $query)->andReturn($response);
            $r = $p->$method($query);
        } else {
            $s->shouldReceive($method)->with(10)->andReturn($response);
            $r = $p->$method();
        }

        $this->assertSame($response, $r);
    }

    public function transferRecipientProvider()
    {
        return [
            ['update', TransferRecipient::class, []],
            ['delete', BaseResource::class],
        ];
    }
}
