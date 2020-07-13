<?php

namespace Ayoolatj\Paystack\Traits\Resource;

trait DeleteResource
{
    /**
     * Delete resource.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function delete()
    {
        return $this->service->delete($this->id);
    }
}
