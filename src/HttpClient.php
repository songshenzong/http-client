<?php

namespace Songshenzong\HttpClient;

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class HttpClient
 *
 * @package Songshenzong\HttpClient
 *
 * @mixin \GuzzleHttp\Client
 *
 * @method static Response get(string | UriInterface $uri, array $options = [])
 * @method static Response head(string | UriInterface $uri, array $options = [])
 * @method static Response put(string | UriInterface $uri, array $options = [])
 * @method static Response post(string | UriInterface $uri, array $options = [])
 * @method static Response patch(string | UriInterface $uri, array $options = [])
 * @method static Response delete(string | UriInterface $uri, array $options = [])
 *
 * @method static PromiseInterface getAsync(string | UriInterface $uri, array $options = [])
 * @method static PromiseInterface headAsync(string | UriInterface $uri, array $options = [])
 * @method static PromiseInterface putAsync(string | UriInterface $uri, array $options = [])
 * @method static PromiseInterface postAsync(string | UriInterface $uri, array $options = [])
 * @method static PromiseInterface patchAsync(string | UriInterface $uri, array $options = [])
 * @method static PromiseInterface deleteAsync(string | UriInterface $uri, array $options = [])
 *
 * @method static Promise sendAsync(RequestInterface $request, array $options = [])
 * @method static Promise requestAsync($method, $uri = '', array $options = [])
 * @method static Response send(RequestInterface $request, array $options = [])
 * @method static Response request($method, $uri = '', array $options = [])
 * @method static array|null getConfig($option = null)
 */
class HttpClient
{

    /**
     * @var \GuzzleHttp\Client $client
     */
    protected static $client;


    /**
     * HttpClient constructor.
     *
     * @param array $config
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        static::$client = new \GuzzleHttp\Client($config);
    }


    /**
     * @param array $config
     *
     * @throws \InvalidArgumentException
     */
    public function config(array $config = [])
    {
        static::$client = new \GuzzleHttp\Client($config);
    }


    /**
     * @return \GuzzleHttp\Client
     * @throws \InvalidArgumentException
     */
    private static function getClient()
    {
        if (!static::$client) {
            static::$client = new \GuzzleHttp\Client();
        }
        return static::$client;
    }

    /**
     * @param string $baseUri
     * @param array  $query
     *
     * @return string
     */
    public static function uri($baseUri, array $query = [])
    {
        if ($query === []) {
            return $baseUri;
        }
        return $baseUri . '?' . http_build_query($query);
    }


    /**
     * @param $name
     * @param $arguments
     *
     * @return Response|mixed
     * @throws \InvalidArgumentException
     */
    public function __call($name, $arguments)
    {
        /**
         * @var \GuzzleHttp\Psr7\Response $response
         */
        $response = self::getClient()->$name(...$arguments);
        if ($response instanceof \GuzzleHttp\Psr7\Response) {
            return new Response($response);
        }
        return $response;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return \GuzzleHttp\Psr7\Response|Response
     * @throws \InvalidArgumentException
     */
    public static function __callStatic($name, $arguments)
    {
        /**
         * @var \GuzzleHttp\Psr7\Response $response
         */
        $response = self::getClient()->$name(...$arguments);
        if ($response instanceof \GuzzleHttp\Psr7\Response) {
            return new Response($response);
        }
        return $response;
    }

}
