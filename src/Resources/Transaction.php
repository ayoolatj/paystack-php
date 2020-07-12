<?php

namespace Ayoolatj\Paystack\Resources;

class Transaction extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/transaction';

    /**
     * Confirm transaction status.
     *
     * @return Transaction
     */
    public function verify()
    {
        return $this->service->verify($this->id);
    }

    /**
     * View the transaction timeline.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function timeline()
    {
        return $this->service->timeline($this->id);
    }

    /**
     * Retrieve disputes for a particular transaction.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function listDisputes()
    {
        return $this->service->listTransactionDisputes($this->id);
    }
}
