<?php

namespace Ayoolatj\Paystack\Http;

use Ayoolatj\Paystack\Exceptions\ApiException;
use GuzzleHttp\Client as Http;

class Request
{
    /**
     * The Paystack secret key.
     *
     * @var string
     */
    protected $secretKey;

    /**
     * The base url for the Paystack API.
     *
     * @var string
     */
    protected $apiBase;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $request;

    /**
     * @var \Ayoolatj\Paystack\Http\Response
    */
    protected $response;

    /**
     * Request constructor.
     *
     * @param string                  $secretKey
     * @param string                  $apiBase
     * @param null|\GuzzleHttp\Client $client
     */
    public function __construct($secretKey, $apiBase, $client = null)
    {
        $this->secretKey = $secretKey;
        $this->apiBase = $apiBase;

        $this->client = $client ?: new Http();
    }

    /**
     * Make request to Paystack API and return the response.
     *
     * @param string $verb
     * @param string $uri
     * @param array  $params
     *
     * @return self
     * @throws \Ayoolatj\Paystack\Exceptions\ApiException
     */
    public function request($verb, $uri, array $params = [])
    {
        $request = compact('verb', 'uri', 'params');
        $response = $this->client->request(
            $verb,
            $this->buildRequestUri($uri),
            $this->buildRequestOptions($verb, $params)
        );

        $response = new Response($response->getBody(), $response->getStatusCode(), $response->getHeaders());

        if ($response->code < 200 || $response->code >= 300 || ! $response->getStatus()) {
            throw new ApiException($response, $request);
        }

        $this->setRequest($request);
        $this->setResponse($response);

        return $this;
    }

    /**
     * Build request uri.
     *
     * @param string $uri
     *
     * @return string
     */
    private function buildRequestUri($uri)
    {
        return $this->apiBase . $uri;
    }

    /**
     * Build request options.
     *
     * @param string $verb
     * @param array  $params
     *
     * @return array
     */
    public function buildRequestOptions($verb, array $params = [])
    {
        $default_options = [
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey,
                'Accept' => 'application/json',
            ],
        ];
        $key = ('get' === strtolower($verb)) ? 'query' : 'form_params';
        $query_options = empty($params) ? [] : [$key => $params];

        return array_merge($default_options, $query_options);
    }

    /**
     * Get Request array.
     *
     * @return array
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set request.
     *
     * @param array $request
     *
     * @return void
     */
    protected function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Ayoolatj\Paystack\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param \Ayoolatj\Paystack\Http\Response $response
     *
     * @return void
     */
    protected function setResponse($response)
    {
        $this->response = $response;
    }
}
