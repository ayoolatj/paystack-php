<?php

namespace Tests\Exceptions;

use Ayoolatj\Paystack\Exceptions\ApiException;
use Ayoolatj\Paystack\Http\Response;
use PHPUnit\Framework\TestCase;

class ApiExceptionTest extends TestCase
{
    /**
     * @var \Ayoolatj\Paystack\Http\Response
     */
    private $r;

    public function setUp(): void
    {
        $b = '{"status":false,"message":"Email address is required to create charge","errors":{}}';
        $c = 400;
        $h = [];

        $this->r = new Response($b, $c, $h);
    }

    public function testException()
    {
        $e = new ApiException($this->r, []);

        $this->assertNotNull($e);
        $this->assertEquals([], $e->getRequest());
        $this->assertEquals($this->r, $e->getResponse());
        $this->assertStringContainsString(
            'Paystack Request failed with response: Email address is required to create charge',
            $e->getMessage()
        );
        $this->assertEquals(400, $e->getCode());
    }
}
