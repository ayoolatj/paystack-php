<?php

namespace Tests\Http;

use Ayoolatj\Paystack\Contracts\ClientInterface;
use Ayoolatj\Paystack\Exceptions\ApiException;
use Ayoolatj\Paystack\Http\Request;
use Ayoolatj\Paystack\Http\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @var \Ayoolatj\Paystack\Http\Request
     */
    private $requestObject;

    /**
     * @var \Ayoolatj\Paystack\Contracts\ClientInterface
     */
    private $client;

    public function setUp(): void
    {
        $apiBase = 'https://api.paystack.co';
        $this->client = new class implements ClientInterface {
            /**
             * @inheritDoc
             */
            public function handleRequest($verb, $absUri, $params = [], $headers = [])
            {
                return ['{"status":true,"message":"a","data":{"a":"b"}}', $this->code, []];
            }
        };
        $this->requestObject = new Request('sk_', $apiBase, $this->client);
    }

    public function request($code)
    {
        $this->client->code = $code;
        $this->requestObject->request('GET', '/plans', []);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testMakeValidRequest()
    {
        $this->request(200);

        $this->assertInstanceOf(Request::class, $this->requestObject);
        $this->assertSame(200, $this->requestObject->getResponse()->code);
    }

    public function testApiExceptionOnInvalidResponse()
    {
        $this->expectException(ApiException::class);
        $this->request(300);
    }

    public function testGetRequest()
    {
        $this->request(200);

        $verb = 'GET';
        $uri = '/plans';
        $params = [];

        $this->assertEquals($this->requestObject->getRequest(), compact('verb', 'uri', 'params'));
    }

    public function testGetResponse()
    {
        $this->request(200);

        $b = '{"status":true,"message":"a","data":{"a":"b"}}';
        $h = [];

        $this->assertInstanceOf(Response::class, $this->requestObject->getResponse());
        $this->assertEquals(new Response($b, 200, $h), $this->requestObject->getResponse());
    }
}
