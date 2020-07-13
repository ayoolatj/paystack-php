<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\Customer;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Customer([], $s);

        $this->assertSame('/customer', $r->getRoot());
    }

    /**
     * @dataProvider customerProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $s = Mockery::mock(Service::class);
        $c = new Customer(['id' => 10], $s);

        if (is_array($query)) {
            $s->shouldReceive($method)->with(10, $query)->andReturn($response);
            $r = $c->$method($query);
        } else {
            $s->shouldReceive($method)->with(10)->andReturn($response);
            $r = $c->$method();
        }

        $this->assertSame($response, $r);
    }

    public function customerProvider()
    {
        $q = [];
        $r = Mockery::mock(Customer::class);

        return [
            ['update', $r, $q],
            ['delete', Mockery::mock(BaseResource::class)],
            ['whitelist', $r],
            ['blacklist', $r],
        ];
    }
}
