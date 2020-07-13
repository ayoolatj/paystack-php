<?php

namespace Ayoolatj\Paystack\Services;

class TransfersControlService extends Service
{
    /**
     * @var \Ayoolatj\Paystack\Services\TransferService
     */
    protected $transferService;

    public function __construct()
    {
        parent::__construct(...func_get_args());

        $this->transferService = new TransferService(...func_get_args());
    }

    /**
     * Check Paystack account balance.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function checkBalance()
    {
        return $this->baseResource($this->request('GET', '/balance')->body);
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
        return $this->transferService->resendOtp($data);
    }

    /**
     * Disable account transfer OTP.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function disableOtp()
    {
        return $this->transferService->disableOtp();
    }

    /**
     * Finalize the request to disable OTP on your transfers.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function disableOtpFinalize(array $data)
    {
        return $this->transferService->disableOtpFinalize($data);
    }

    /**
     * Enable account transfer OTP.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function enableOtp()
    {
        return $this->transferService->enableOtp();
    }
}
