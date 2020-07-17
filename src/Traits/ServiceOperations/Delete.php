<?php

namespace Ayoolatj\Paystack\Traits\ServiceOperations;

trait Delete
{
    /**
     * Delete a resource on your integration.
     *
     * @param string $resourceCode
     *
     * @return \Ayoolatj\Paystack\Http\Response
     */
    public function delete($resourceCode)
    {
        return $this->request('DELETE', "{$this->getPrimaryResourceRoot()}/$resourceCode");
    }
}
