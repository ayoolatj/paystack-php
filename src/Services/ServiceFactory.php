<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Exceptions\UndefinedServiceException;

class ServiceFactory
{
    /**
     * @var \Ayoolatj\Paystack\Paystack
     */
    private $paystack;

    /**
     * @var array
     */
    private $services;

    /**
     * @var string[]
     */
    private static $map = [
        'transactions' => TransactionService::class,
        'transactionSplits' => TransactionSplitService::class,
        'customers' => CustomerService::class,
        'subaccounts' => SubAccountService::class,
        'plans' => PlanService::class,
        'subscriptions' => SubscriptionService::class,
        'products' => ProductService::class,
        'paymentPages' => PageService::class,
        'invoices' => InvoiceService::class,
        'settlements' => SettlementService::class,
        'transferRecipients' => TransferRecipientService::class,
        'transfers' => TransferService::class,
        'transfersControl' => TransfersControlService::class,
        'bulkCharges' => BulkChargeService::class,
        'controlPanel' => ControlPanelService::class,
        'charge' => ChargeService::class,
        'disputes' => DisputeService::class,
        'refunds' => RefundService::class,
        'verification' => VerificationService::class,
        'miscellaneous' => MiscellaneousService::class,
    ];

    /**
     * ServiceFactory constructor.
     *
     * @param \Ayoolatj\Paystack\Paystack $paystack
     */
    public function __construct($paystack)
    {
        $this->paystack = $paystack;
        $this->services = [];
    }

    /**
     * @param  string $name
     * @return string|null
     */
    protected function getServiceClass($name)
    {
        return array_key_exists($name, self::$map) ? self::$map[$name] : null;
    }

    /**
     * @param string $name
     *
     * @return \Ayoolatj\Paystack\Services\Service
     *
     * @throws \Ayoolatj\Paystack\Exceptions\UndefinedServiceException
     */
    public function __get($name)
    {
        $serviceClass = $this->getServiceClass($name);

        if (is_null($serviceClass)) {
            throw new UndefinedServiceException($name);
        }

        if (! array_key_exists($name, $this->services)) {
            $this->services[$name] = new $serviceClass($this->paystack);
        }

        return $this->services[$name];
    }
}
