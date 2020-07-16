<?php

namespace Ayoolatj\Paystack\Http;

use Ayoolatj\Paystack\Exceptions\ApiException;

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
     * @var \Ayoolatj\Paystack\Contracts\ClientInterface
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
     * @param string                                            $secretKey
     * @param string                                            $apiBase
     * @param \Ayoolatj\Paystack\Contracts\ClientInterface|null $client
     */
    public function __construct($secretKey, $apiBase, $client = null)
    {
        $this->secretKey = $secretKey;
        $this->apiBase = $apiBase;
        $this->client = $client ?: new GuzzleClient();
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
        [$rawBody, $statusCode, $headers] = $this->client->handleRequest(
            $verb,
            $this->apiBase . $uri,
            $params,
            [
                'Authorization' => 'Bearer '.$this->secretKey,
                'Content-Type' => 'application/json',
            ]
        );

        $response = new Response($rawBody, $statusCode, $headers);

        if ($response->code < 200 || $response->code >= 300 || ! $response->getStatus()) {
            throw new ApiException($response, $request);
        }

        $this->setRequest($request);
        $this->setResponse($response);

        return $this;
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
