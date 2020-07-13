<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Dispute;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;
use Ayoolatj\Paystack\Traits\ServiceOperations\Update;

class DisputeService extends Service
{
    use All;
    use Fetch;
    use Update;

    /**
     * @var string
     */
    protected $primaryResource = Dispute::class;

    /**
     * Dispute Resource.
     *
     * @param  array $attributes
     * @return \Ayoolatj\Paystack\Resources\Dispute
     */
    protected function disputeResource(array $attributes)
    {
        return new Dispute($attributes, $this);
    }

    /**
     * Retrieve disputes for a particular transaction.
     *
     * @param  string $id
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function listTransactionDisputes($id)
    {
        $collection = $this->transformCollection($this->request('GET', "/dispute/transaction/$id"), Dispute::class);

        return $this->baseResource($collection);
    }

    /**
     * Provide evidence for a dispute.
     *
     * @param string $id Dispute id.
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function addEvidence($id, array $data)
    {
        return $this->baseResource($this->request('POST', "/dispute/$id/evidence", $data)->getData());
    }

    /**
     * Get URL to upload a dispute evidence.
     *
     * @param  string $id Dispute id.
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function uploadUrl($id)
    {
        return $this->baseResource($this->request('GET', "/dispute/$id/upload_url")->getData());
    }

    /**
     * Resolve a dispute on your integration.
     *
     * @param  string $id   Dispute id.
     * @param  array  $data
     * @return \Ayoolatj\Paystack\Resources\Dispute
     */
    public function resolve($id, array $data)
    {
        return $this->disputeResource($this->request('PUT', "/dispute/$id/resolve", $data)->getData());
    }

    /**
     * Export disputes available on your integration.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function export(array $data = [])
    {
        return $this->baseResource($this->request('GET', '/dispute/export', $data)->getData());
    }
}
