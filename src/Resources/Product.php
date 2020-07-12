<?php

namespace Ayoolatj\Paystack\Resources;

class Product extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/product';

    /**
     * Update plan.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\ApiResource|Product
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
