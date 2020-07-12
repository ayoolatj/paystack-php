<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Settlement;
use Ayoolatj\Paystack\Resources\Transaction;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;

class SettlementService extends Service
{
    use All;

    /**
     * @var string
     */
    protected $primaryResource = Settlement::class;

    /**
     * Get the transactions that make up a particular settlement.
     *
     * @param  string $id    Settlement id
     * @param  array  $query
     * @return \Ayoolatj\Paystack\Support\Paginator
     */
    public function transactions($id, array $query = [])
    {
        return $this->paginate(
            $this->listResources("/settlement/$id/transactions", $query),
            Transaction::class
        );
    }
}
