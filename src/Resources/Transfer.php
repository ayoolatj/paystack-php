<?php

namespace Ayoolatj\Paystack\Resources;

/**
 * @property string $transferCode Transfer code.
 */
class Transfer extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/transfer';

    /**
     * Finalize an initiated transfer.
     *
     * @param string $otp
     * @return Transfer
     */
    public function finalize($otp)
    {
        $data = ['transfer_code' => $this->transferCode, 'otp' => $otp];

        return $this->service->finalize($data);
    }

    /**
     * Verify the transfer status.
     *
     * @return Transfer
     */
    public function verify()
    {
        return $this->service->verify($this->transferCode);
    }
}
