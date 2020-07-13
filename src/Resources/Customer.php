<?php

namespace Ayoolatj\Paystack\Resources;

use Ayoolatj\Paystack\Traits\Resource\DeleteResource;
use Ayoolatj\Paystack\Traits\Resource\UpdateResource;

/**
 * @property string $customerCode Customer's code.
 */
class Customer extends BaseResource
{
    use DeleteResource;
    use UpdateResource;

    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/customer';

    /**
     * Whitelist customer.
     *
     * @return Customer
     */
    public function whitelist()
    {
        return $this->service->whitelist($this->id);
    }

    /**
     * Blacklist customer.
     *
     * @return Customer
     */
    public function blacklist()
    {
        return $this->service->blacklist($this->id);
    }
}
