<?php

namespace Ayoolatj\Paystack\Resources;

class Page extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/page';

    /**
     * Update page.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\ApiResource|Page
     */
    public function update(array $data)
    {
        return $this->service->update($this->id, $data);
    }

    /**
     * Delete page.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function delete()
    {
        return $this->service->delete($this->id);
    }

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
