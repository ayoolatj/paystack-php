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

    /**
     * @var string
     */
    private $uri;

    /**
     * @var \GuzzleHttp\Client|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $client;

    public function setUp(): void
    {
        $this->client = Mockery::mock('GuzzleHttp\Client');
        $apiBase = 'https://api.paystack.co';
        $this->uri = $apiBase . '/plans';

        $this->requestObject = new Request('sk_', $apiBase, $this->client);
    }

    public function request($code)
    {
        $requestOptions = $this->requestObject->buildRequestOptions('GET', []);
        $this->client->shouldReceive('request')->once()->with('GET', $this->uri, $requestOptions)->andReturn(
            $response = Mockery::mock('GuzzleHttp\Psr7\Response')
        );

        $b = '{"status":true,"message":"a","data":{"a":"b"}}';
        $h = [];

        $response->shouldReceive('getStatusCode')->zeroOrMoreTimes()->andReturn($code);
        $response->shouldReceive('getHeaders')->zeroOrMoreTimes()->andReturn($h);
        $response->shouldReceive('getBody')->zeroOrMoreTimes()->andReturn($b);

        $this->requestObject->request('GET', '/plans', []);

        return compact('b', 'code', 'h');
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testMakeValidRequest()
    {
        $this->request(200);

        $this->assertInstanceOf(Request::class, $this->requestObject);
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
        $request = $this->request(200);
        $request = array_values($request);

        $this->assertInstanceOf(Response::class, $this->requestObject->getResponse());
        $this->assertEquals(new Response(...$request), $this->requestObject->getResponse());
    }
}
