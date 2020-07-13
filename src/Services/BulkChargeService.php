<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\BulkCharge;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;

class BulkChargeService extends Service
{
    use All;
    use Fetch;

    /**
     * @var string
     */
    protected $primaryResource = BulkCharge::class;

    /**
     * BulkCharge Resource
     *
     * @param  array $attributes
     * @return \Ayoolatj\Paystack\Resources\BulkCharge
     */
    protected function bulkChargeResource(array $attributes)
    {
        return new BulkCharge($attributes, $this);
    }

    /**
     * Send an array of objects with authorization codes and amount, in kobo
     * if currency is NGN and pesewas, if currency is GHS. so we can process
     * transactions as a batch.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\BulkCharge
     */
    public function initiate(array $data)
    {
        return $this->bulkChargeResource($this->request('POST', '/bulkcharge', $data)->getData());
    }

    /**
     * Retrieve the charges associated with a specified batch code.
     *
     * @param  string $idOrCode
     * @param  array  $data
     * @return \Ayoolatj\Paystack\Support\Paginator
     */
    public function fetchCharges($idOrCode, array $data)
    {
        return $this->paginate($this->request('GET', "/bulkcharge/$idOrCode/charges", $data));
    }

    /**
     * Use this endpoint to pause processing a batch.
     *
     * @param string $batchCode
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function pause($batchCode)
    {
        return $this->baseResource($this->request('GET', "/bulkcharge/pause/$batchCode")->body);
    }

    /**
     * Use this endpoint to resume processing a batch.
     *
     * @param  string $batchCode
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function resume($batchCode)
    {
        return $this->baseResource($this->request('GET', "/bulkcharge/pause/$batchCode")->body);
    }
}
