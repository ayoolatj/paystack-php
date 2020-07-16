<?php

namespace Tests\Http;

use Ayoolatj\Paystack\Http\GuzzleClient;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GuzzleClientTest extends TestCase
{
    /**
     * @var \Ayoolatj\Paystack\Http\GuzzleClient
     */
    private $guzzleClient;

    /**
     * @var string
     */
    private $uri;

    public function setUp(): void
    {
        $apiBase = 'https://api.paystack.co';
        $this->uri = $apiBase.'/plans';
        $requestOptions = [
            'http_errors' => false,
            'headers' => [],
            RequestOptions::JSON => []
        ];

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->once()->with('GET', $this->uri, $requestOptions)->andReturn(
            $response = Mockery::mock('GuzzleHttp\Psr7\Response')
        );
        $response->shouldReceive('getStatusCode')->zeroOrMoreTimes()->andReturn(200);
        $response->shouldReceive('getHeaders')->zeroOrMoreTimes()->andReturn([]);
        $response->shouldReceive('getBody')->zeroOrMoreTimes()->andReturn(
            '{"status":true,"message":"a","data":{"a":"b"}}'
        );

        $guzzleClientReflector = new ReflectionClass(GuzzleClient::class);
        $clientProperty = $guzzleClientReflector->getProperty('client');
        $clientProperty->setAccessible(true);

        $this->guzzleClient = new GuzzleClient();
        $clientProperty->setValue($this->guzzleClient, $client);
    }

    public function testHandleRequest()
    {
        $response = $this->guzzleClient->handleRequest('GET', $this->uri, [], []);
        $expected = [
            '{"status":true,"message":"a","data":{"a":"b"}}',
            200,
            []
        ];

        $this->assertIsArray($response);
        $this->assertSame($expected, $response);
    }
}
