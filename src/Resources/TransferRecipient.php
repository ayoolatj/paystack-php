<?php

namespace Ayoolatj\Paystack\Resources;

class TransferRecipient extends BaseResource
{
    /**
     * Resource root.
     *
     * @var string
     */
    protected $root = '/transferrecipient';

    /**
     * Update transfer recipients.
     *
     * @param array $data
     * @return \Ayoolatj\Paystack\Resources\ApiResource|TransferRecipient
     */
    public function update(array $data)
    {
        return $this->service->update($this->id, $data);
    }

    /**
     * Delete transfer recipients.
     *
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function delete()
    {
        return $this->service->delete($this->id);
    }
}
