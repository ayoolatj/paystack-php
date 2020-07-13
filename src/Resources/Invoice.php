<?php

namespace Ayoolatj\Paystack\Resources;

use Ayoolatj\Paystack\Traits\Resource\UpdateResource;

class Invoice extends BaseResource
{
    use UpdateResource;

    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/paymentrequest';

    /**
     * Verify invoice details.
     *
     * @return Invoice
     */
    public function verify()
    {
        return $this->service->verify($this->id);
    }

    /**
     * Notify invoice customers.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function notify()
    {
        return $this->service->notify($this->id);
    }

    /**
     * Finalize a Draft Invoice.
     *
     * @return Invoice
     */
    public function finalize()
    {
        return $this->service->finalize($this->id);
    }

    /**
     * Archive invoice.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function archive()
    {
        return $this->service->archive($this->id);
    }
}
