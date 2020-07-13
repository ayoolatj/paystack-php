<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\Page;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Page([], $s);

        $this->assertSame('/page', $r->getRoot());
    }

    /**
     * @dataProvider pageProvider
     */
    public function testResourceMethods($method, $response, $query = null)
    {
        $s = Mockery::mock(Service::class);
        $p = new Page(['id' => 10], $s);

        if (is_array($query)) {
            $s->shouldReceive($method)->with(10, $query)->andReturn($response);
            $r = $p->$method($query);
        } else {
            $s->shouldReceive($method)->with(10)->andReturn($response);
            $r = $p->$method();
        }

        $this->assertSame($response, $r);
    }

    public function pageProvider()
    {
        $q = [];
        $r = Mockery::mock(Page::class);
        $bR = Mockery::mock(BaseResource::class);

        return [
            ['update', $r, $q],
            ['delete', $bR],
            ['addProducts', $bR, $q],
        ];
    }
}
