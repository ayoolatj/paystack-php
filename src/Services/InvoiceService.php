<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Invoice;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Create;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;
use Ayoolatj\Paystack\Traits\ServiceOperations\Update;

class InvoiceService extends Service
{
    use Create;
    use All;
    use Fetch;
    use Update;

    /**
     * @var string
     */
    protected $primaryResource = Invoice::class;

    /**
     * Invoice Resource.
     *
     * @param array $attributes
     * @return \Ayoolatj\Paystack\Resources\Invoice
     */
    public function invoiceResource(array $attributes)
    {
        return new Invoice($attributes, $this);
    }

    /**
     * Verify details of an invoice on your integration.
     *
     * @param string $code
     * @return \Ayoolatj\Paystack\Resources\Invoice
     */
    public function verify($code)
    {
        return $this->invoiceResource($this->request('GET', "/paymentrequest/verify/$code")->getData());
    }

    /**
     * Send notification of an invoice to your customers.
     *
     * @param  string $code
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function notify($code)
    {
        return $this->baseResource($this->request('POST', "/paymentrequest/notify/$code")->getData());
    }

    /**
     * Get invoice metrics for dashboard.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function totals()
    {
        return $this->baseResource($this->request('POST', '/paymentrequest/totals')->getData());
    }

    /**
     * Finalize a Draft Invoice.
     *
     * @param string $code
     * @return \Ayoolatj\Paystack\Resources\Invoice
     */
    public function finalize($code)
    {
        return $this->invoiceResource($this->request('POST', "/paymentrequest/finalize/$code")->getData());
    }

    /**
     * Archive invoice.
     *
     * @param  string $code
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function archive($code)
    {
        return $this->baseResource($this->request('POST', "/paymentrequest/archive/$code")->getData());
    }
}
