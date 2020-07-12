<?php

namespace Ayoolatj\Paystack;

use Ayoolatj\Paystack\Services\ServiceFactory;
use InvalidArgumentException;

/**
 * @property \Ayoolatj\Paystack\Services\TransactionService $transactions
 * @property \Ayoolatj\Paystack\Services\TransactionSplitService $transactionSplits
 * @property \Ayoolatj\Paystack\Services\CustomerService $customers
 * @property \Ayoolatj\Paystack\Services\SubAccountService $subaccounts
 * @property \Ayoolatj\Paystack\Services\PlanService $plans
 * @property \Ayoolatj\Paystack\Services\SubscriptionService $subscriptions
 * @property \Ayoolatj\Paystack\Services\ProductService $products
 * @property \Ayoolatj\Paystack\Services\PageService $paymentPages
 * @property \Ayoolatj\Paystack\Services\InvoiceService $invoices
 * @property \Ayoolatj\Paystack\Services\SettlementService $settlements
 * @property \Ayoolatj\Paystack\Services\TransferRecipientService $transferRecipients
 * @property \Ayoolatj\Paystack\Services\TransferService $transfers
 * @property \Ayoolatj\Paystack\Services\TransfersControlService $transfersControl
 * @property \Ayoolatj\Paystack\Services\BulkChargeService $bulkCharges
 * @property \Ayoolatj\Paystack\Services\ControlPanelService $controlPanel
 * @property \Ayoolatj\Paystack\Services\ChargeService $charge
 * @property \Ayoolatj\Paystack\Services\DisputeService $disputes
 * @property \Ayoolatj\Paystack\Services\RefundService $refunds
 * @property \Ayoolatj\Paystack\Services\VerificationService $verification
 * @property \Ayoolatj\Paystack\Services\MiscellaneousService $miscellaneous
 */
class Paystack
{
    /**
     * The Paystack secret key.
     *
     * @var string
     */
    public $secretKey;

    /**
     * The base url for the Paystack API.
     *
     * @var string
     */
    public $apiBase = 'https://api.paystack.co';

    /**
     * The Guzzle HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    public $client;

    /**
     * @var \Ayoolatj\Paystack\Services\ServiceFactory
     */
    private $serviceFactory;

    /**
     * Paystack constructor.
     *
     * @param string                  $secretKey
     * @param null|\GuzzleHttp\Client $client
     */
    public function __construct($secretKey, $client = null)
    {
        if (empty($secretKey) || ! (substr($secretKey, 0, 3) === 'sk_')) {
            throw new InvalidArgumentException("A Valid Paystack Secret Key must start with 'sk_'");
        }

        $this->secretKey = $secretKey;

        if (! is_null($client)) {
            $this->client = $client;
        }
    }

    /**
     * Get service based on defined map.
     *
     * @param  string $name
     * @return \Ayoolatj\Paystack\Services\Service
     */
    public function __get($name)
    {
        if (null === $this->serviceFactory) {
            $this->serviceFactory = new ServiceFactory($this);
        }

        return $this->serviceFactory->$name;
    }
}
