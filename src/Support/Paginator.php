<?php

namespace Ayoolatj\Paystack\Support;

use ArrayAccess;
use ArrayIterator;
use Ayoolatj\Paystack\Contracts\Arrayable;
use Ayoolatj\Paystack\Services\Service;
use Ayoolatj\Paystack\Traits\HasService;
use Countable;
use IteratorAggregate;
use JsonSerializable;

class Paginator implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable, Arrayable
{
    use HasService;

    /**
     * All of the items being paginated.
     *
     * @var array
     */
    protected $items;

    /**
     * The number of items per page.
     *
     * @var int
     */
    protected $perPage;

    /**
     * The current page.
     *
     * @var int
     */
    protected $page;

    /**
     * The total number of items.
     *
     * @var int
     */
    protected $total;

    /**
     * The total number of pages.
     *
     * @var int
     */
    protected $pageCount;

    /**
     * @var \Ayoolatj\Paystack\Services\Service
     */
    protected $service;

    /**
     * @var array
     */
    protected $query;

    /**
     * Pagination constructor.
     *
     * @param array                                 $items
     * @param array                                 $meta    (total, skipped, perPage, page, pageCount)
     * @param \Ayoolatj\Paystack\Services\Service   $service
     */
    public function __construct(array $items, $meta, $service)
    {
        $this->items = $items;
        $this->page = $meta['page'];
        $this->perPage = $meta['perPage'];
        $this->total = $meta['total'];
        $this->pageCount = $meta['pageCount'];
        $this->query = $service->getLastRequest()['params'];
        $this->service = $service;
    }

    /**
     * Determine if the given item exists.
     *
     * @param  mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get the item at the given offset.
     *
     * @param  mixed $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return array_key_exists($key, $this->items) ? $this->items[$key] : null;
    }

    /**
     * Set the item at the given offset.
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at the given key.
     *
     * @param  mixed $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Get the number of items for the current page.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Get an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'data' => $this->items,
            'page' => $this->page,
            'perPage' => $this->perPage,
            'total' => $this->total,
            'pageCount' => $this->pageCount,
        ];
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * A generator that can be used to iterate across all objects across
     * all pages. As page boundaries are encountered, the next page will
     * be fetched automatically for continued iteration.
     *
     * @return \Generator|\Ayoolatj\Paystack\Support\Paginator[]
     */
    public function autoPagingIterator()
    {
        $page = $this;

        while (true) {
            foreach ($page as $item) {
                yield $item;
            }

            if ($page->page === $page->pageCount) {
                break;
            }

            $page = $page->nextPage();
        }
    }

    /**
     * Fetches the next page in the resource list.
     *
     * @return \Ayoolatj\Paystack\Support\Paginator
     */
    public function nextPage()
    {
        $query = $this->query ?: [];
        $query = array_merge($query, ['page' => $this->page + 1]);

        return $this->service->all($query);
    }

    /**
     * @param \Ayoolatj\Paystack\Services\Service $service
     */
    public function setService(Service $service): void
    {
        $this->service = $service;
    }
}
