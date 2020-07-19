<?php

namespace Ayoolatj\Paystack\Traits\ServiceOperations;

trait Create
{
    /**
     * Create a resource on your integration.
     *
     * @param array $data
     *
     * @return \Ayoolatj\Paystack\Resources\ApiResource
     */
    public function create(array $data)
    {
        $attributes = $this->request('POST', $this->getPrimaryResourceRoot(), $data)->getData();

        return new $this->primaryResource($attributes, $this);
    }
}
