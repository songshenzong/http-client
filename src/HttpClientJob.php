<?php

namespace Songshenzong\HttpClient;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
     * @param string $method
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
     * @return Response
     */
    public function handle()
    {
        return HttpClient::request(...$this->parameters);
    }

}
