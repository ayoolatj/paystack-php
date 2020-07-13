<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Split;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Create;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;
use Ayoolatj\Paystack\Traits\ServiceOperations\Update;

/**
 * The Transaction Splits Service enables merchants split the settlement for a transaction
 * across their payout account, and one or more Sub accounts.
 */
class TransactionSplitService extends Service
{
    use Create;
    use All;
    use Fetch;
    use Update;

    /**
     * @var string
     */
    protected $primaryResource = Split::class;

    /**
     * Split resource.
     *
     * @param array $attributes
     * @return \Ayoolatj\Paystack\Resources\Split
     */
    public function splitResource(array $attributes)
    {
        return new Split($attributes, $this);
    }

    /**
     * Add a Sub account to a Transaction Split, or update the share of an
     * existing Sub account in a Transaction Split.
     *
     * @param  string $id
     * @param  array  $data
     * @return \Ayoolatj\Paystack\Resources\Split
     */
    public function addOrUpdateSubaccount($id, array $data)
    {
        $attributes = $this->request('POST', "/split/$id/subaccount/add", $data)->getData();

        return $this->splitResource($attributes);
    }

    /**
     * Remove a sub account from a transaction split.
     *
     * @param string $id
     * @param array  $data
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function removeSubaccount($id, array $data)
    {
        return $this->baseResource($this->request('POST', "/split/$id/subaccount/remove", $data)->body);
    }
}
