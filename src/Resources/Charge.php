<?php

namespace Ayoolatj\Paystack\Resources;

/**
 * @property string $reference Charge transaction reference.
 */
class Charge extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/charge';

    /**
     * Submit PIN to continue a charge.
     *
     * @param array $data
     * @return Charge
     */
    public function submitPin(array $data)
    {
        $data = array_merge($data, ['reference' => $this->reference]);

        return $this->service->submitPin($data);
    }

    /**
     * Submit OTP to complete a charge.
     *
     * @param array $data
     * @return Charge
     */
    public function submitOtp(array $data)
    {
        $data = array_merge($data, ['reference' => $this->reference]);

        return $this->service->submitOtp($data);
    }

    /**
     * Submit Phone when requested.
     *
     * @param array $data
     * @return Charge
     */
    public function submitPhone(array $data)
    {
        $data = array_merge($data, ['reference' => $this->reference]);

        return $this->service->submitPhone($data);
    }

    /**
     * Submit Birthday when requested.
     *
     * @param array $data
     * @return Charge
     */
    public function submitBirthday(array $data)
    {
        $data = array_merge($data, ['reference' => $this->reference]);

        return $this->service->submitBirthday($data);
    }

    /**
     * Submit address to continue a charge.
     *
     * @param array $data
     * @return Charge
     */
    public function submitAddress(array $data)
    {
        $data = array_merge($data, ['reference' => $this->reference]);

        return $this->service->submitAddress($data);
    }
}
