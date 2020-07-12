<?php

namespace Ayoolatj\Paystack\Services;

class MiscellaneousService extends Service
{
    /**
     * Get a list of all Nigerian banks and their properties.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function banks(array $data)
    {
        return $this->baseResource($this->request('GET', '/bank', $data)->getData());
    }

    /**
     * Gets a list of Countries that Paystack currently supports.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function countries()
    {
        return $this->baseResource($this->request('GET', '/country')->getData());
    }
}
