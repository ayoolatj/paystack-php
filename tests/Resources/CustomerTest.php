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
        $response = Mockery::mock($response);
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
        return [
            ['update', Customer::class, []],
            ['delete', BaseResource::class],
            ['whitelist', Customer::class],
            ['blacklist', Customer::class],
        ];
    }
}
