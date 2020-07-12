<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Refund;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Create;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;

class RefundService extends Service
{
    use All;
    use Create;
    use Fetch;

    /**
     * @var string
     */
    protected $primaryResource = Refund::class;
}
