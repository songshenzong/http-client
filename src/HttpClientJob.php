<?php

namespace Songshenzong\HttpClient;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use function func_get_args;

class HttpClientJob implements ShouldQueue
{
    use Queueable, Dispatchable;


    /**
     * @var array
     */
    public $parameters;


    /**
     * HttpClientJob constructor.
     *
     * @param        $method
     * @param string $uri
     * @param array  $options
     */
    public function __construct($method, $uri = '', array $options = [])
    {
        $this->parameters = func_get_args();
    }


    /**
     * Handle this Job
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function handle(): \GuzzleHttp\Psr7\Response
    {
        return HttpClient::request(...$this->parameters);
    }


}
