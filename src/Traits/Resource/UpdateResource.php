<?php

namespace Ayoolatj\Paystack\Traits\Resource;

trait UpdateResource
{
    /**
     * Update resource.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\ApiResource
     */
    public function update(array $data)
    {
        return $this->service->update($this->id, $data);
    }
}
