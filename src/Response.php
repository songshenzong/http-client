<?php

namespace Songshenzong\HttpClient;

use ArrayAccess;
use Serializable;
use SimpleXMLElement;
use Songshenzong\Support\Strings;
use stdClass;

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
    public function isJson()
    {
        return Strings::isJson((string) $this->response->getBody());
    }

    /**
     * @return bool
     */
    public function isXml()
    {
        return Strings::isXml((string) $this->response->getBody());
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return Strings::toArray((string) $this->response->getBody());
    }

    /**
     * @return stdClass|SimpleXMLElement
     */
    public function toObject()
    {
        return Strings::toObject((string) $this->response->getBody());
    }


    /**
     * @param null $serialized
     *
     * @return mixed
     */
    public function unserialize($serialized = null)
    {
        if ($this->response) {
            return Strings::unserialize((string) $this->response->getBody());
        }

        return null;
    }

    /**
     * String representation of object
     *
     * @return string
     */
    public function serialize()
    {
        if ($this->response) {
            return serialize((string) $this->response->getBody());
        }

        return serialize(null);
    }

    /**
     * @return bool
     */
    public function isSerialized()
    {
        return Strings::isSerialized((string) $this->response->getBody());
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
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
        return null !== $this->__get($key);
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


    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->responseArray[$name] = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->response->getBody();
    }
}
