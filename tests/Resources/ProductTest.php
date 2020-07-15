<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\Product;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Product([], $s);

        $this->assertSame('/product', $r->getRoot());
    }

    /**
     * @dataProvider productProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $response = Mockery::mock($response);
        $s = Mockery::mock(Service::class);
        $p = new Product(['id' => 10], $s);

        if (is_array($query)) {
            $s->shouldReceive($method)->with(10, $query)->andReturn($response);
            $r = $p->$method($query);
        } else {
            $s->shouldReceive($method)->with(10)->andReturn($response);
            $r = $p->$method();
        }

        $this->assertSame($response, $r);
    }

    public function productProvider()
    {
        return [
            ['update', Product::class, []],
            ['delete', BaseResource::class],
        ];
    }
}
