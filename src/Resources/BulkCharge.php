<?php

namespace Ayoolatj\Paystack\Resources;

/**
 * @property  string $batchCode The batch code for the bulk charge.
 */
class BulkCharge extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/bulkcharge';

    /**
     * Retrieve charges associated with a bulk charge batch.
     *
     * @param array $query
     * @return \Ayoolatj\Paystack\Support\Paginator
     */
    public function fetchCharges(array $query)
    {
        return $this->service->fetchCharges($this->batchCode, $query);
    }

    /**
     * Pause processing a bulk charge batch.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function pause()
    {
        return $this->service->pause($this->batchCode);
    }

    /**
     * Resume processing a bulk charge batch.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function resume()
    {
        return $this->service->resume($this->batchCode);
    }
}
