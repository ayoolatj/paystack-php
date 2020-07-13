<?php

namespace Ayoolatj\Paystack\Resources;

use Ayoolatj\Paystack\Traits\Resource\UpdateResource;

class Dispute extends BaseResource
{
    use UpdateResource;

    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/dispute';

    /**
     * Provide evidence for dispute.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function addEvidence(array $data)
    {
        return $this->service->addEvidence($this->id, $data);
    }

    /**
     * Get URL to upload evidence.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function uploadUrl()
    {
        return $this->service->uploadUrl($this->id);
    }

    /**
     * Resolve dispute.
     *
     * @param array $data
     * @return Dispute
     */
    public function resolve(array $data)
    {
        return $this->service->resolve($this->id, $data);
    }
}
