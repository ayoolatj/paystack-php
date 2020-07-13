<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Subscription;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Create;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;

class SubscriptionService extends Service
{
    use Create;
    use All;
    use Fetch;

    /**
     * @var string
     */
    protected $primaryResource = Subscription::class;

    /**
     * Enable a subscription on your integration.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function enable(array $data)
    {
        return $this->baseResource($this->request('POST', '/subscription/enable', $data)->body);
    }

    /**
     * Disable a subscription on your integration.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function disable(array $data)
    {
        return $this->baseResource($this->request('POST', '/subscription/disable', $data)->body);
    }
}
