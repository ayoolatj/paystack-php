<?php

namespace Ayoolatj\Paystack\Traits\ServiceOperations;

trait All
{
    /**
     * List resources available on your integration.
     *
     * @param  array $query
     * @return \Ayoolatj\Paystack\Support\Paginator
     */
    public function all(array $query = [])
    {
        return $this->paginate(
            $this->listResources($this->getPrimaryResourceRoot(), $query),
            $this->primaryResource
        );
    }
}
