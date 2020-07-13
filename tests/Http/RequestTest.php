<?php

namespace Tests\Http;

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

    public function setUp(): void
    {
        $client = Mockery::mock('GuzzleHttp\Client');
        $apiBase = 'https://api.paystack.co';
        $uri = $apiBase . '/plans';

        $this->requestObject = new Request('sk_', $apiBase, $client);
        $requestOptions = $this->requestObject->buildRequestOptions('GET', []);
        $client->shouldReceive('request')->once()->with('GET', $uri, $requestOptions)->andReturn(
            $response = Mockery::mock('GuzzleHttp\Psr7\Response')
        );
        $response->shouldReceive('getHeaders')->zeroOrMoreTimes()->andReturn([]);
        $response->shouldReceive('getBody')->zeroOrMoreTimes()->andReturn(
            '{"status":true,"message":"a","data":{"a":"b"}}'
        );

        $this->response = $response;
    }

    public function request($code)
    {
        $this->response->shouldReceive('getStatusCode')->once()->andReturn($code);
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
