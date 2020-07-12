<?php

namespace Ayoolatj\Paystack\Resources;

class Dispute extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/dispute';

    /**
     * Update dispute.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\ApiResource|Dispute
     */
    public function update(array $data)
    {
        return $this->service->update($this->id, $data);
    }

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
