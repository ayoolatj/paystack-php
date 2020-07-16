<?php

namespace Ayoolatj\Paystack\Http;

use Ayoolatj\Paystack\Contracts\ClientInterface;
use GuzzleHttp\Client as Http;
use GuzzleHttp\RequestOptions;

class GuzzleClient implements ClientInterface
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * GuzzleClient constructor.
     */
    public function __construct()
    {
        $this->client = new Http();
    }

    /**
     * @inheritDoc
     */
    public function handleRequest($verb, $absUri, $params = [], $headers = [])
    {
        $response = $this->client->request(
            $verb,
            $absUri,
            [
                'http_errors' => false,
                'headers' => $headers,
                RequestOptions::JSON => $params
            ]
        );

        return [$response->getBody(), $response->getStatusCode(), $response->getHeaders()];
    }
}
