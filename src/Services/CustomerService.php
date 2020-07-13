<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Customer;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Create;
use Ayoolatj\Paystack\Traits\ServiceOperations\Delete;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;
use Ayoolatj\Paystack\Traits\ServiceOperations\Update;

class CustomerService extends Service
{
    use Create;
    use All;
    use Fetch;
    use Update;
    use Delete;

    /**
     * @var string
     */
    protected $primaryResource = Customer::class;

    /**
     * @var \Ayoolatj\Paystack\Services\TransactionService
     */
    protected $transactionService;

    public function __construct()
    {
        parent::__construct(...func_get_args());

        $this->transactionService = new TransactionService(...func_get_args());
    }

    /**
     * Customer Resource.
     *
     * @param array $attributes
     * @return \Ayoolatj\Paystack\Resources\Customer
     */
    public function customerResource(array $attributes)
    {
        return new Customer($attributes, $this);
    }

    /**
     * Whitelist or blacklist a customer on your integration.
     *
     * @param array $data
     *
     * @return \Ayoolatj\Paystack\Resources\Customer
     */
    public function setRisKAction(array $data)
    {
        return $this->customerResource($this->request('POST', '/customer/set_risk_action', $data)->getData());
    }

    /**
     * Whitelist a customer on your integration.
     *
     * @param  string $code
     * @return \Ayoolatj\Paystack\Resources\Customer
     */
    public function whitelist($code)
    {
        $data = [
            'customer' => $code,
            'risk_action' => 'allow',
        ];

        return $this->setRisKAction($data);
    }

    /**
     * Blacklist a customer on your integration.
     *
     * @param  string $code
     * @return \Ayoolatj\Paystack\Resources\Customer
     */
    public function blacklist($code)
    {
        $data = [
            'customer' => $code,
            'risk_action' => 'deny',
        ];

        return $this->setRisKAction($data);
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
        $data = ['authorization_code' => $authorizationCode];

        return $this->baseResource($this->request('POST', '/transaction/deactivate_authorization', $data)->getData());
    }
}
