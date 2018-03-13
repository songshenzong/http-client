<?php

namespace Songshenzong\HttpClient;

use function http_build_query;

/**
 * @property  method
 * @property  uri
 * @property  options
 */
class HttpClient
{

    /**
     * HttpClient constructor.
     */
    private function __construct()
    {
    }


    /**
     * @param string $domain
     * @param array  $query
     *
     * @return string
     */
    public static function uri(string $domain, array $query = [])
    {
        if ($query === []) {
            return $domain;
        }
        return $domain . "?" . http_build_query($query);
    }


    /**
     * @param        $method
     * @param string $uri
     * @param array  $options
     *
     * @return Response
     * @throws \InvalidArgumentException
     */
    public static function request(string $method, string $uri = '', array $options = []): Response
    {
        $client = new \GuzzleHttp\Client();
        /**
         * @var \GuzzleHttp\Psr7\Response $response
         */
        $response = $client->request($method, $uri, $options);

        return new Response($response);
    }


    /**
     * @param        $method
     * @param string $uri
     * @param array  $options
     *
     * @return static
     */
    public static function sendAsync(string $method, string $uri = '', array $options = [])
    {
        $instance          = new static;
        $instance->method  = $method;
        $instance->uri     = $uri;
        $instance->options = $options;
        return $instance;
    }


    /**
     * @param $function
     *
     * @return \GuzzleHttp\Promise\Promise
     * @throws \InvalidArgumentException
     */
    public function then($function): \GuzzleHttp\Promise\Promise
    {
        $client = new \GuzzleHttp\Client();
        // Send an asynchronous request.
        $request = new \GuzzleHttp\Psr7\Request($this->method, $this->uri, $this->options);
        /**
         * @var \GuzzleHttp\Promise\Promise $promise
         */
        $promise = $client->sendAsync($request)->then($function);
        return $promise;
    }
}
