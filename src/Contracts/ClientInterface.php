<?php

namespace Ayoolatj\Paystack\Contracts;

interface ClientInterface
{
    /**
     * @param string $verb Http method.
     * @param string $absUri Absolute url for request.
     * @param array $params Request parameters
     * @param array $headers Request headers.
     *
     * @return array (rawResponseBody, responseStatusCode, responseHeaders)
     */
    public function handleRequest($verb, $absUri, $params = [], $headers = []);
}
