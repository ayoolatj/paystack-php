<?php

namespace Ayoolatj\Paystack\Resources;

class Invoice extends BaseResource
{
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
     * Update invoice.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\ApiResource|Invoice
     */
    public function update(array $data)
    {
        return $this->service->update($this->id, $data);
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
