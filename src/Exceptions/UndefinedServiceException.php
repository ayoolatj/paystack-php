<?php

namespace Ayoolatj\Paystack\Exceptions;

use Exception;

class UndefinedServiceException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param string $message
     */
    public function __construct($message = '')
    {
        parent::__construct("The service: {$message} could not be found.");
    }
}
