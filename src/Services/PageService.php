<?php

namespace Ayoolatj\Paystack\Services;

use Ayoolatj\Paystack\Resources\Page;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Create;
use Ayoolatj\Paystack\Traits\ServiceOperations\Delete;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;
use Ayoolatj\Paystack\Traits\ServiceOperations\Update;

class PageService extends Service
{
    use Create;
    use All;
    use Fetch;
    use Update;
    use Delete;

    /**
     * @var string
     */
    protected $primaryResource = Page::class;

    /**
     * Check the availability of a slug for a payment page.
     *
     * @param  string $slug
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function checkSlugAvailability($slug)
    {
        return $this->baseResource($this->request('GET', "/page/check_slug_availability/$slug")->getData());
    }

    /**
     * Add products to a payment page.
     *
     * @param  string $pageId
     * @param  array   $data
     * @return \Ayoolatj\Paystack\Resources\BaseResource
     */
    public function addProducts($pageId, array $data)
    {
        return $this->baseResource($this->request('POST', "/page/$pageId/product", $data)->getData());
    }
}
