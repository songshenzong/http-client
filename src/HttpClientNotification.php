<?php

namespace Songshenzong\HttpClient;

use Illuminate\Notifications\Notification;

class HttpClientNotification extends Notification
{


    /**
     * @var array
     */
    public $parameters;


    /**
     * HttpClientNotification constructor.
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
     * Get the notification's delivery channels.
     *
     * @param   $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return [HttpClientChannel::class];
    }


    /**
     * @param $notifiable
     *
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function toHttp($notifiable): Response
    {
        return HttpClient::request(...$this->parameters);
    }


}
