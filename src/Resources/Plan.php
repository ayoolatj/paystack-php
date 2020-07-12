<?php

namespace Ayoolatj\Paystack\Resources;

class Plan extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/plan';

    /**
     * Update plan.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\ApiResource|Plan
     */
    public function update(array $data)
    {
        return $this->service->update($this->id, $data);
    }

    /**
     * Delete plan.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function delete()
    {
        return $this->service->delete($this->id);
    }
}
