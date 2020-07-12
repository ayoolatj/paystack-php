<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\SubAccount;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Create;
use Ayoolatj\Paystack\Traits\ServiceOperations\Delete;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;
use Ayoolatj\Paystack\Traits\ServiceOperations\Update;

class SubAccountService extends Service
{
    use Create;
    use All;
    use Fetch;
    use Update;
    use Delete;

    /**
     * @var string
     */
    protected $primaryResource = SubAccount::class;
}
