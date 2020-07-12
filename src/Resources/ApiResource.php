<?php

namespace Ayoolatj\Paystack\Resources;

use ArrayAccess;
use Ayoolatj\Paystack\Contracts\Arrayable;
use Ayoolatj\Paystack\Services\Service;
use Ayoolatj\Paystack\Traits\HasService;

/**
 * Base Resource
 *
 * @property string $id Unique id fo the object
 *
 * TODO: Convert date to DateTime
 */
abstract class ApiResource implements Arrayable, ArrayAccess
{
    use HasService;

    /**
     * @var \Ayoolatj\Paystack\Services\Service
     */
    protected $service;

    /**
     * The resource's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The resource's root.
     *
     * @var string
     */
    protected $root;

    /**
     * API Resource Constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->fill();
    }

    /**
     * Fill the resource with the array of attributes.
     *
     * @return void
     */
    protected function fill()
    {
        foreach ($this->attributes as $key => $value) {
            $key = $this->camelCase($key);

            $this->{$key} = $value;
        }
    }

    /**
     * Convert the key name to camel case.
     *
     * @param  string $key
     * @return string
     */
    protected function camelCase($key)
    {
        $parts = explode('_', $key);

        foreach ($parts as $i => $part) {
            if ($i !== 0) {
                $parts[$i] = ucfirst($part);
            }
        }

        return str_replace(' ', '', implode(' ', $parts));
    }

    /**
     * Get the resource's root.
     *
     * @return string
     */
    public function getRoot()
    {
        return $this->root ?: '';
    }

    /**
     * Determine if the given item exists.
     *
     * @param  mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Get the item at the given offset.
     *
     * @param  mixed $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : null;
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
        $this->attributes[$key] = $value;
    }

    /**
     * Unset the item at the given key.
     *
     * @param  mixed $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->attributes[$key]);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * @param \Ayoolatj\Paystack\Services\Service $service
     */
    public function setService(Service $service): void
    {
        $this->service = $service;
    }
}
