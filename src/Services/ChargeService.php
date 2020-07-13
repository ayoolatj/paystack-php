<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Charge;

class ChargeService extends Service
{
    /**
     * Charge Resource
     *
     * @param  array $attributes
     * @return \Ayoolatj\Paystack\Resources\Charge
     */
    protected function chargeResource(array $attributes)
    {
        return new Charge($attributes, $this);
    }

    /**
     * Send card details or bank details or authorization code to start a charge.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Charge
     */
    public function charge(array $data)
    {
        return $this->chargeResource($this->request('POST', '/charge', $data)->getData());
    }

    /**
     * Submit PIN to continue a charge.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Charge
     */
    public function submitPin(array $data)
    {
        return $this->chargeResource($this->request('POST', '/charge/submit_pin', $data)->getData());
    }

    /**
     * Submit OTP to complete a charge.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Charge
     */
    public function submitOtp(array $data)
    {
        return $this->chargeResource($this->request('POST', '/charge/submit_otp', $data)->getData());
    }

    /**
     * Submit Phone when requested.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Charge
     */
    public function submitPhone(array $data)
    {
        return $this->chargeResource($this->request('POST', '/charge/submit_phone', $data)->getData());
    }

    /**
     * Submit Birthday when requested.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Charge
     */
    public function submitBirthday(array $data)
    {
        return $this->chargeResource($this->request('POST', '/charge/submit_birthday', $data)->getData());
    }

    /**
     * Submit address to continue a charge.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Charge
     */
    public function submitAddress(array $data)
    {
        return $this->chargeResource($this->request('POST', '/charge/submit_address', $data)->getData());
    }

    /**
     * When you get "pending" as a charge status or if there was an exception
     * when calling any of the /charge endpoints, wait 10 seconds or more,
     * then make a check to see if its status has changed. Don't call too early
     * as you may get a lot more pending than you should.
     *
     * @param  string $reference
     * @return \Ayoolatj\Paystack\Resources\Charge
     */
    public function checkPending($reference)
    {
        return $this->chargeResource($this->request('GET', "/charge/$reference")->getData());
    }
}
