<?php

namespace Ayoolatj\Paystack\Resources;

class Settlement extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/settlement';

    /**
     * Get settlement transactions.
     *
     * @param  array  $query
     * @return \Ayoolatj\Paystack\Support\Paginator
     */
    public function transactions(array $query)
    {
        return $this->service->transactions($this->id, $query);
    }
}
