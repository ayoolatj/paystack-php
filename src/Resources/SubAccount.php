<?php

namespace Ayoolatj\Paystack\Resources;

class SubAccount extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/subaccount';

    /**
     * Update sub-account.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\ApiResource|SubAccount
     */
    public function update(array $data)
    {
        return $this->service->update($this->id, $data);
    }

    /**
     * Delete sub-account.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function delete()
    {
        return $this->service->delete($this->id);
    }
}
