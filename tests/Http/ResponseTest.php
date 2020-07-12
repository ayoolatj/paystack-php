<?php

namespace Tests\Http;

use Ayoolatj\Paystack\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @var \Ayoolatj\Paystack\Http\Response
     */
    private $r;

    public function setUp(): void
    {
        $b = '{"status":true,"message":"a","data":{"a":"b"}}';
        $c = 200;
        $h = [];

        $this->r = new Response($b, $c, $h);
    }

    public function testGetStatus()
    {
        $this->assertTrue($this->r->getStatus());
    }

    public function testGetMessage()
    {
        $this->assertEquals('a', $this->r->getMessage());
    }

    public function testGetData()
    {
        $this->assertEquals(['a' => 'b'], $this->r->getData());
    }

    public function testGetMeta()
    {
        $this->assertEquals([], $this->r->getMeta());
    }
}
