<?php

namespace Ayoolatj\Paystack\Resources;

use Ayoolatj\Paystack\Traits\Resource\DeleteResource;
use Ayoolatj\Paystack\Traits\Resource\UpdateResource;

class SubAccount extends BaseResource
{
    use DeleteResource;
    use UpdateResource;

    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/subaccount';
}
