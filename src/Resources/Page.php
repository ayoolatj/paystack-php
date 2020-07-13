<?php

namespace Ayoolatj\Paystack\Resources;

use Ayoolatj\Paystack\Traits\Resource\DeleteResource;
use Ayoolatj\Paystack\Traits\Resource\UpdateResource;

class Page extends BaseResource
{
    use DeleteResource;
    use UpdateResource;

    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/page';

    /**
     * Add products to page.
     *
     * @param  array   $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function addProducts(array $data)
    {
        return $this->service->addProducts($this->id, $data);
    }
}
