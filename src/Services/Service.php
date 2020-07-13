<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Http\Request;
use Ayoolatj\Paystack\Http\Response;
use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Support\Paginator;

abstract class Service
{
    /**
     * @var \Ayoolatj\Paystack\Paystack
     */
    protected $paystack;

    /**
     * @var array
     */
    protected $lastRequest;

    /**
     * @var \Ayoolatj\Paystack\Http\Response
     */
    protected $lastResponse;

    /**
     * @var \Ayoolatj\Paystack\Http\Request
     */
    protected $apiRequest;

    /**
     * @var string
     */
    protected $primaryResource;

    /**
     * @var string
     */
    protected $primaryResourceRoot;

    /**
     * Create a service instance.
     *
     * @param \Ayoolatj\Paystack\Paystack $paystack
     */
    public function __construct($paystack)
    {
        $this->paystack = $paystack;
        $this->apiRequest = new Request($this->paystack->secretKey, $this->paystack->apiBase, $this->paystack->client);

        if (! empty($this->primaryResource)) {
            $this->primaryResourceRoot = (new $this->primaryResource([], $this))->getRoot();
        }
    }

    /**
     * Make a service request.
     *
     * @param string $verb
     * @param string $uri
     * @param array  $params
     *
     * @return \Ayoolatj\Paystack\Http\Response
     */
    protected function request($verb, $uri, array $params = [])
    {
        $request = $this->apiRequest->request($verb, $uri, $params);
        $response = $request->getResponse();

        $this->setLastResponse($response);
        $this->setLastRequest($request->getRequest());

        return $response;
    }

    /**
     * The last response from the Paystack API.
     *
     * @return \Ayoolatj\Paystack\Http\Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Sets the last response from the Paystack API.
     *
     * @param \Ayoolatj\Paystack\Http\Response $lastResponse
     *
     * @return void
     */
    public function setLastResponse($lastResponse)
    {
        $this->lastResponse = $lastResponse;
    }

    /**
     * Get the last request to the Paystack API.
     *
     * @return array
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * Sets the last request to the Paystack API.
     *
     * @param array $lastRequest
     *
     * @return void
     */
    public function setLastRequest($lastRequest)
    {
        $this->lastRequest = $lastRequest;
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param \Ayoolatj\Paystack\Http\Response $response
     * @param string                           $class
     *
     * @return array
     */
    protected function transformCollection(Response $response, $class = '')
    {
        return array_map(
            function ($data) use ($class) {
                return empty($class) ? $data : new $class($data, $this);
            },
            $response->getData()
        );
    }

    /**
     * Converts response into a paginator.
     *
     * @param \Ayoolatj\Paystack\Http\Response $response
     * @param string                           $class
     *
     * @return \Ayoolatj\Paystack\Support\Paginator
     */
    protected function paginate(Response $response, $class = '')
    {
        $items = $this->transformCollection($response, $class);

        return new Paginator($items, $response->getMeta(), $this);
    }

    /**
     * List resources available on your integration.
     *
     * @param  string $uri
     * @param  array  $query
     * @return \Ayoolatj\Paystack\Http\Response
     */
    public function listResources($uri, array $query)
    {
        return $this->request('GET', $uri, $query);
    }

    /**
     * Base resource.
     *
     * @param array $attributes
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function baseResource(array $attributes)
    {
        return new BaseResource($attributes, $this);
    }
}
