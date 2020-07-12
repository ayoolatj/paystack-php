<?php

namespace Ayoolatj\Paystack\Services;

class ControlPanelService extends Service
{
    /**
     * Fetch the payment session timeout on your integration.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function paymentSessionTimeout()
    {
        return $this->baseResource($this->request('GET', '/integration/payment_session_timeout')->getData());
    }

    /**
     * Update the payment session timeout on your integration.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function updatePaymentSessionTimeout(array $data)
    {
        return $this->baseResource($this->request('PUT', '/integration/payment_session_timeout', $data)->getData());
    }
}
