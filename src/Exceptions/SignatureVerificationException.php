<?php

namespace Ayoolatj\Paystack\Exceptions;

use Exception;

class SignatureVerificationException extends Exception
{
    /**
     * @var string
     */
    protected $httpBody;

    /**
     * @var string
     */
    protected $sigHeader;

    /**
     * SignatureVerificationException constructor.
     *
     * @param string $message
     * @param string $httpBody
     * @param string $sigHeader
     */
    public function __construct($message, $httpBody = '', $sigHeader = '')
    {
        $this->setHttpBody($httpBody);
        $this->setsigHeader($sigHeader);

        parent::__construct($message);
    }

    /**
     * @return string
     */
    public function getHttpBody()
    {
        return $this->httpBody;
    }

    /**
     * @param string $httpBody
     * @return void
     */
    public function setHttpBody($httpBody)
    {
        $this->httpBody = $httpBody;
    }

    /**
     * @return string
     */
    public function getSigHeader()
    {
        return $this->sigHeader;
    }

    /**
     * @param string $sigHeader
     * @return void
     */
    public function setSigHeader($sigHeader)
    {
        $this->sigHeader = $sigHeader;
    }
}
