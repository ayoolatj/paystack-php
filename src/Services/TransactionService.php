<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Transaction;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;

/**
 * The Transactions API allows you create and manage payments on your integration.
 *
 */
class TransactionService extends Service
{
    use All;
    use Fetch;

    /**
     * @var string
     */
    protected $primaryResource = Transaction::class;

    /**
     * Transaction Resource
     *
     * @param  array $attributes
     * @return \Ayoolatj\Paystack\Resources\Transaction
     */
    protected function transactionResource(array $attributes)
    {
        return new Transaction($attributes, $this);
    }

    /**
     * Initialize a transaction.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Transaction
     */
    public function initialize(array $data)
    {
        $attributes = $this->request('POST', '/transaction/initialize', $data)->getData();

        return $this->transactionResource($attributes);
    }

    /**
     * Confirm the status of a transaction
     *
     * @param  string $reference
     * @return \Ayoolatj\Paystack\Resources\Transaction
     */
    public function verify($reference)
    {
        $attributes = $this->request('GET', "/transaction/verify/reference/$reference")->getData();

        return $this->transactionResource($attributes);
    }

    /**
     * All authorizations marked as reusable can be charged with this
     * endpoint whenever you need to receive payments.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Transaction
     */
    public function chargeAuthorization(array $data)
    {
        $attributes = $this->request('POST', '/transaction/charge_authorization', $data)->getData();

        return $this->transactionResource($attributes);
    }

    /**
     * All mastercard and visa authorizations can be checked with this
     * endpoint to know if they have funds for the payment you seek.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function checkAuthorization(array $data)
    {
        $attributes = $this->request('POST', '/transaction/check_authorization', $data)->getData();

        return $this->baseResource($attributes);
    }

    /**
     * View the timeline of a transaction.
     *
     * @param int|string $idOrReference
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function timeline($idOrReference)
    {
        return $this->baseResource($this->request('GET', "/transaction/timeline/$idOrReference")->body);
    }

    /**
     * Total amount received on your account.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function totals()
    {
        return $this->baseResource($this->request('GET', '/transaction/totals')->body);
    }

    /**
     * Export transactions carried out on your integration.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function export(array $data)
    {
        return $this->baseResource($this->request('GET', '/transaction/export', $data)->body);
    }

    /**
     * Retrieve part of a payment from a customer.
     *
     * @param  array $data
     * @return \Ayoolatj\Paystack\Resources\Transaction
     */
    public function partialDebit(array $data)
    {
        $attributes = $this->request('POST', '/transaction/partial_debit', $data)->getData();

        return $this->transactionResource($attributes);
    }

    /**
     * Deactivate an authorization when the card needs to be forgotten.
     *
     * @param string $authorizationCode
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function deactivateAuthorization($authorizationCode)
    {
        return $this->paystack->customers->deactivateAuthorization($authorizationCode);
    }

    /**
     * Retrieve disputes for a particular transaction.
     *
     * @param string $transactionId
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function listTransactionDisputes($transactionId)
    {
        return $this->paystack->disputes->listTransactionDisputes($transactionId);
    }
}
