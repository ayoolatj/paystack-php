<?php

namespace Ayoolatj\Paystack\Exceptions;

use Ayoolatj\Paystack\Http\Response;
use Exception;

class ApiException extends Exception
{
    /**
     * @var \Ayoolatj\Paystack\Http\Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $request;

    /**
     * ApiException constructor.
     *
     * @param \Ayoolatj\Paystack\Http\Response $response
     * @param array                            $request
     */
    public function __construct(Response $response, array $request)
    {
        $this->setResponse($response);
        $this->setRequest($request);

        $message = 'Paystack Request failed with response: ';
        $message .= $this->getMessageFromApiResponseBody($this->response->body);

        parent::__construct($message, $response->code);
    }

    /**
     * @return \Ayoolatj\Paystack\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \Ayoolatj\Paystack\Http\Response $response
     *
     * @return void
     */
    private function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @param array $request
     *
     * @return void
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * Get message from api response body.
     *
     * @param  array $response
     *
     * @return string
     */
    protected function getMessageFromApiResponseBody(array $response)
    {
        $message = '';

        if (! empty($response)) {
            if (array_key_exists('message', $response)) {
                $message = $response['message'];
            }

            if (array_key_exists('errors', $response) && is_array($response['errors'])) {
                $message .= " Errors: " . json_encode($response['errors']);
            }
        }

        return $message;
    }
}
