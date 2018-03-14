<?php

namespace Songshenzong\HttpClient;

use ArrayAccess;
use Serializable;
use stdClass;
use function is_array;
use function serialize;
use function unserialize;

/**
 * Class Response
 *
 * @package Songshenzong\HttpClient
 * @mixin \GuzzleHttp\Psr7\Response
 */
class Response implements ArrayAccess, Serializable
{
    /**
     * @var \GuzzleHttp\Psr7\Response $response
     */
    protected $response;

    /**
     * @var array
     */
    protected $responseArray = [];

    /**
     * Response constructor.
     *
     * @param \GuzzleHttp\Psr7\Response $response
     */
    public function __construct(\GuzzleHttp\Psr7\Response $response)
    {
        $this->response      = $response;
        $this->responseArray = $this->toArray();
    }


    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->response->$name(...$arguments);
    }


    /**
     * @return bool
     */
    public function isJson(): bool
    {
        $body = $this->response->getBody();
        if ($body === '') {
            return false;
        }

        \json_decode($body);
        if (\json_last_error()) {
            return false;
        }

        return true;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        if ($this->isJson()) {
            return json_decode($this->response->getBody(), true);
        }

        $unserialize = $this->unserialize();
        if ($unserialize === false) {
            return [];
        }

        if (is_array($unserialize)) {
            return $unserialize;
        }

        return [];

    }

    /**
     * @return object
     */
    public function toObject(): object
    {
        if ($this->isJson()) {
            return json_decode($this->response->getBody());
        } else {
            return new stdClass();
        }
    }


    /**
     * @param null $serialized
     *
     * @return mixed
     */
    public function unserialize($serialized = null)
    {
        // Set Handle
        set_error_handler(function () {
        }, E_ALL);
        $result = unserialize((string) $this->response->getBody());
        // Restores the previous error handler function
        restore_error_handler();
        if ($result === false) {
            return false;
        }
        return $result;
    }

    /**
     * String representation of object
     *
     * @return string
     */
    public function serialize(): string
    {
        return serialize((string) $this->response->getBody());
    }


    /**
     * Determine if the given offset exists.
     *
     * @param  string $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists(
            $offset, $this->responseArray
        );
    }


    /**
     * Get the value at the given offset.
     *
     * @param  string $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }


    /**
     * Set the value at the given offset.
     *
     * @param  string $offset
     * @param  mixed  $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->responseArray[$offset] = $value;
    }

    /**
     * Remove the value at the given offset.
     *
     * @param  string $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->responseArray[$offset]);
    }

    /**
     * Returns true if the parameter is defined.
     *
     * @param string $key The key
     *
     * @return bool true if the parameter exists, false otherwise
     */
    public function has($key)
    {
        return array_key_exists($key, $this->responseArray);
    }

    /**
     * Check if an input element is set on the request.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return !is_null($this->__get($key));
    }


    /**
     * Get an input element from the request.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->responseArray[$key];
    }

}
