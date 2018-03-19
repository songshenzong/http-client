<?php

namespace Songshenzong\HttpClient\Test;

use PHPUnit\Framework\TestCase;
use Songshenzong\HttpClient\HttpClient;
use Songshenzong\HttpClient\Response;

class HttpClientTest extends TestCase
{
    /**
     * @var string
     */
    public static $uri;


    /**
     * @var Response
     */
    public static $response;

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testUri()
    {
        static::$uri = HttpClient::uri('https://packagist.org/search.json', ['q' => 'songshenzong']);
        $this->assertEquals('https://packagist.org/search.json?q=songshenzong', static::$uri);
    }

    /**
     * @depends testUri
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testIsJson()
    {
        static::$response = HttpClient::get(static::$uri);
        $this->assertEquals(true, static::$response->isJson());
    }


    /**
     * @depends testUri
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testIsXml()
    {
        $this->assertEquals(false, static::$response->isXml());
    }

    /**
     * @depends testIsJson
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testToArray()
    {
        $this->assertArrayHasKey('total', static::$response->toArray());
        unset(static::$response['total']);
        $this->assertArrayNotHasKey('total', static::$response);
        static::$response['new'] = true;
        $this->assertArrayHasKey('new', static::$response);
        $this->assertEquals(true, static::$response['new']);
    }


    /**
     * @depends testIsJson
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testToObject()
    {
        $this->assertObjectHasAttribute('total', static::$response->toObject());
    }

}
