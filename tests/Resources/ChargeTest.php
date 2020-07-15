<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\Charge;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class ChargeTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Charge([], $s);

        $this->assertSame('/charge', $r->getRoot());
    }

    /**
     * @dataProvider chargeProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $response = Mockery::mock($response);
        $s = Mockery::mock(Service::class);
        $c = new Charge(['reference' => 10], $s);

        $query = array_merge($query, ['reference' => 10]);
        $s->shouldReceive($method)->with($query)->andReturn($response);

        $r = $c->$method($query);

        $this->assertSame($response, $r);
    }

    public function chargeProvider()
    {
        return [
            ['submitPin', Charge::class, []],
            ['submitOtp', Charge::class, []],
            ['submitPhone', Charge::class, []],
            ['submitBirthday', Charge::class, []],
            ['submitAddress', Charge::class, []]
        ];
    }
}
