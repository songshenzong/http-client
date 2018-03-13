<?php

namespace Songshenzong\HttpClient;

use Illuminate\Notifications\Notification;

class HttpClientChannel
{
    /**
     * @param              $notifiable
     * @param Notification $notification
     *
     * @return mixed
     */
    public function send($notifiable, Notification $notification)
    {

        /**
         * @var \GuzzleHttp\Psr7\Response $response
         */
        $response = $notification->toHttp($notifiable);

        return $response;
    }
}
