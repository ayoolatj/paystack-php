<?php

namespace Ayoolatj\Paystack\Traits;

trait HasService
{
    /**
     * The last response from the Paystack API.
     *
     * @return \Ayoolatj\Paystack\Http\Response
     */
    public function getLastResponse()
    {
        return $this->service->getlastResponse();
    }

    /**
     * Get the last request to the Paystack API.
     *
     * @return array
     */
    public function getLastRequest()
    {
        return $this->service->getLastRequest();
    }
}
