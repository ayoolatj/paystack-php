<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Transfer;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;

class TransferService extends Service
{
    use All;
    use Fetch;

    /**
     * @var string
     */
    protected $primaryResource = Transfer::class;

    /**
     * @param  array $attributes
     * @return \Ayoolatj\Paystack\Resources\Transfer
     */
    public function transferResource(array $attributes)
    {
        return new Transfer($attributes, $this);
    }

    /**
     * Status of transfer object returned will be 'pending' if OTP is disabled.
     * In the event that an OTP is required, status will read 'otp'.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Transfer
     */
    public function initiate(array $data)
    {
        return $this->transferResource($this->request('POST', $this->primaryResourceRoot, $data)->getData());
    }

    /**
     * Finalize an initiated transfer.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Transfer
     */
    public function finalize(array $data)
    {
        return $this->transferResource($this->request('POST', '/transfer/finalize', $data)->getData());
    }

    /**
     * You need to disable the Transfers OTP requirement to use this endpoint.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function initiateBulk(array $data)
    {
        $collection = $this->transformCollection(
            $this->request('POST', '/transfer/bulk', $data),
            $this->primaryResource
        );

        return $this->baseResource($collection);
    }

    /**
     * Verify the status of a transfer on your integration.
     *
     * @param  string $reference
     * @return \Ayoolatj\Paystack\Resources\Transfer
     */
    public function verify($reference)
    {
        return $this->transferResource($this->request('GET', "/transfer/verify/$reference")->getData());
    }

    /**
     * Generates a new OTP and sends to customer in the event they are
     * having trouble receiving one.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function resendOtp(array $data)
    {
        return $this->baseResource($this->request('POST', '/transfer/resend_otp', $data)->getData());
    }

    /**
     * Disable account transfer OTP.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function disableOtp()
    {
        return $this->baseResource($this->request('POST', '/transfer/disable_otp')->getData());
    }

    /**
     * Finalize the request to disable OTP on your transfers.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function disableOtpFinalize(array $data)
    {
        return $this->baseResource($this->request('POST', '/transfer/disable_otp_finalize', $data)->getData());
    }

    /**
     * Enable account transfer OTP.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function enableOtp()
    {
        return $this->baseResource($this->request('POST', '/transfer/enable_otp')->getData());
    }
}
