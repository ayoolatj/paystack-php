<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\Refund;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class RefundTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Refund([], $s);

        $this->assertSame('/refund', $r->getRoot());
    }
}
