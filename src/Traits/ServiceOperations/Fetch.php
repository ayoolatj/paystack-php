<?php

namespace Ayoolatj\Paystack\Traits\ServiceOperations;

trait Fetch
{
    /**
     * Get details of a plan on your integration.
     *
     * @param string $resourceCode
     *
     * @return \Ayoolatj\Paystack\Resources\ApiResource
     */
    public function fetch($resourceCode)
    {
        $attributes = $this->request('GET', "{$this->getPrimaryResourceRoot()}/$resourceCode")->getData();

        return new $this->primaryResource($attributes, $this);
    }
}
