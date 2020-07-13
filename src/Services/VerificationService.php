<?php

namespace Ayoolatj\Paystack\Services;

class VerificationService extends Service
{
    /**
     * Check if an account number and BVN are linked.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function bvnMatch(array $data)
    {
        return $this->baseResource($this->request('POST', '/bvn/match', $data)->body);
    }

    /**
     * Get a customer's information by using the Bank Verification Number.
     *
     * @param string $bvn
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function resolveBvn($bvn)
    {
        return $this->baseResource($this->request('GET', "/bank/resolve_bvn/$bvn")->body);
    }

    /**
     * Confirm an account belongs to the right customer.
     *
     * @param string $account_number
     * @param string $bank_code
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function resolveAccountNumber($account_number, $bank_code)
    {
        $query = compact('account_number', 'bank_code');

        return $this->baseResource($this->request('GET', "/bank/resolve", $query)->body);
    }

    /**
     * Get more information about a customer's card.
     *
     * @param string $bin
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function resolveCardBin($bin)
    {
        return $this->baseResource($this->request('GET', "/decision/bin/$bin")->body);
    }
}
