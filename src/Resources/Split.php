<?php

namespace Ayoolatj\Paystack\Resources;

use Ayoolatj\Paystack\Traits\Resource\UpdateResource;

class Split extends BaseResource
{
    use UpdateResource;

    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/split';

    /**
     * Add a sub-account, or update the share of an existing sub account.
     *
     * @param array $data
     * @return Split
     */
    public function addOrUpdateSubaccount(array $data)
    {
        return $this->service->addOrUpdateSubaccount($this->id, $data);
    }

    /**
     * Remove a sub-account.
     *
     * @param string $subaccount
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function removeSubaccount($subaccount)
    {
        $data = compact('subaccount');

        return $this->service->removeSubaccount($this->id, $data);
    }
}
