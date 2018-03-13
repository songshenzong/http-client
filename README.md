[![Songshenzong](https://cdn.songshenzong.com/images/logo.png)](https://songshenzong.com)

[![Total Downloads](https://poser.pugx.org/songshenzong/http-client/d/total.svg)](https://packagist.org/packages/songshenzong/http-client)
[![Latest Stable Version](https://poser.pugx.org/songshenzong/http-client/v/stable.svg)](https://packagist.org/packages/songshenzong/http-client)
[![License](https://poser.pugx.org/songshenzong/http-client/license.svg)](https://packagist.org/packages/songshenzong/http-client)
[![PHP Version](https://img.shields.io/packagist/php-v/songshenzong/http-client.svg)](https://packagist.org/packages/songshenzong/http-client)



## 安装 Installation

Require this package with composer:

```shell
composer require songshenzong/http-client
```


##  使用 Use

```php
 
        $uri = HttpClient::uri("https://api.github.com/repos/songshenzong/api", ['query' => 'string']);
        // https://api.github.com/repos/songshenzong/http-client?query=string
 
  
        $response = HttpClient::request('GET', $uri);
 
        echo $response->getStatusCode();
        // 200
 
        echo $response->getHeaderLine('content-type');
        // application/json; charset=utf-8
 
        echo $response->getBody();
        // '{"id": 1420053, "name": "http-client", ...}'
 
        print_r($response->toArray());
        // Array
        // (
        // [id] => 87772235
        // [name] => http-client
        // [full_name] => songshenzong/api
        // ...
        // )
 
        echo $response['name'];
        // http-client
 
        echo $response->name;
        // http-client
 
        var_dump($response->isJson());
        // bool(true)
 
        print_r($response->serialize());
        // C:32:"Songshenzong\HttpClient\Response":5253:...
 
        var_dump($response->unserialize());
        // false | object | array
 
        // Send an asynchronous request.
        $promise = HttpClient::sendAsync('GET', $uri)->then(function ($response) {
            $response = new \Songshenzong\HttpClient\Response($response);
            echo $response['id'];
        });
        $promise->wait();
         
```





## 队列 Laravel Queues

```php
CurlJob::dispatch('GET', 'https://api.github.com/repos/songshenzong/http-client');
 
CurlJob::dispatchNow('GET', 'https://api.github.com/repos/songshenzong/http-client');
```





## 消息通知 Laravel Notifications

```php
Notification::send($user, new CurlNotification('GET', 'https://api.github.com/repos/songshenzong/http-client'));
```

#### Example

```php

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
 * @return mixed
 */
public function toHttp($notifiable)
{
    return HttpClient::request('GET', 'https://api.github.com/repos/songshenzong/http-client');;
}

```


## 文档 Documentation

Please refer to our extensive [Wiki documentation](https://github.com/songshenzong/http-client/wiki) for more information.


## 支持 Support

For answers you may not find in the Wiki, avoid posting issues. Feel free to ask for support on Songshenzong.com


## 证书 License

This package is licensed under the [BSD 3-Clause license](http://opensource.org/licenses/BSD-3-Clause).
