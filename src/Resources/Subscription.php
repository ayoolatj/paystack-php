<?php

namespace Ayoolatj\Paystack\Resources;

/**
 * @property string $subscriptionCode Subscription code.
 * @property string $emailToken Subscription email token.
 */
class Subscription extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/subscription';

    /**
     * Enable subscription.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function enable()
    {
        $data = ['code' => $this->subscriptionCode, 'token' => $this->emailToken];

        return $this->service->enable($data);
    }

    /**
     * Disable subscription.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function disable()
    {
        $data = ['code' => $this->subscriptionCode, 'token' => $this->emailToken];

        return $this->service->disable($data);
    }
}
