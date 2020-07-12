<?php

namespace Ayoolatj\Paystack\Resources;

/**
 * @property string $customerCode Customer's code.
 */
class Customer extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/customer';

    /**
     * Update customer.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\ApiResource|Customer
     */
    public function update(array $data)
    {
        return $this->service->update($this->customerCode, $data);
    }

    /**
     * Delete customer.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function delete()
    {
        return $this->service->delete($this->customerCode);
    }

    /**
     * Whitelist customer.
     *
     * @return Customer
     */
    public function whitelist()
    {
        return $this->service->whitelist($this->customerCode);
    }

    /**
     * Blacklist customer.
     *
     * @return Customer
     */
    public function blacklist()
    {
        return $this->service->blacklist($this->customerCode);
    }
}
