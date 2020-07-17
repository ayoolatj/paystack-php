<?php

namespace Ayoolatj\Paystack\Traits\ServiceOperations;

trait Update
{
    /**
     * Update details of a plan on your integration.
     *
     * @param string $resourceCodeOrId
     * @param array  $data
     *
     * @return \Ayoolatj\Paystack\Resources\ApiResource
     */
    public function update($resourceCodeOrId, array $data)
    {
        $this->request('PUT', "{$this->getPrimaryResourceRoot()}/$resourceCodeOrId", $data);

        return $this->fetch($resourceCodeOrId);
    }
}
