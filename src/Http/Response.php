<?php

namespace Ayoolatj\Paystack\Http;

use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * Response Headers.
     *
     * @var array
     */
    public $headers;

    /**
     * Response body.
     *
     * @var array
     */
    public $body;

    /**
     * Response HTTP code.
     *
     * @var int
     */
    public $code;

    /**
     * Response constructor.
     *
     * @param string $rawBody Raw response body.
     * @param int $rCode Status code.
     * @param array $rHeaders Headers.
     */
    public function __construct($rawBody, $rCode, array $rHeaders)
    {
        $this->body = json_decode($rawBody, true) ?: [];
        $this->code = $rCode;
        $this->headers = $rHeaders;
    }

    /**
     * Get Paystack API response status.
     *
     * @return bool
     */
    public function getStatus()
    {
        return isset($this->body['status']) ? $this->body['status'] : false;
    }

    /**
     * Get Paystack API response message.
     *
     * @return string
     */
    public function getMessage()
    {
        return isset($this->body['message']) ? $this->body['message'] : '';
    }

    /**
     * Get Paystack API response data.
     *
     * @return array|mixed
     */
    public function getData()
    {
        return isset($this->body['data']) ? $this->body['data'] : [];
    }

    /**
     * Get Paystack API response meta.
     *
     * @return array|mixed
     */
    public function getMeta()
    {
        return isset($this->body['meta']) ? $this->body['meta'] : [];
    }
}
