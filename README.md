[![Build Status](https://travis-ci.org/songshenzong/http-client.svg?branch=master)](https://travis-ci.org/songshenzong/http-client)
[![Total Downloads](https://poser.pugx.org/songshenzong/http-client/d/total.svg)](https://packagist.org/packages/songshenzong/http-client)
[![Latest Stable Version](https://poser.pugx.org/songshenzong/http-client/v/stable.svg)](https://packagist.org/packages/songshenzong/http-client)
[![License](https://poser.pugx.org/songshenzong/http-client/license.svg)](https://packagist.org/packages/songshenzong/http-client)
[![PHP Version](https://img.shields.io/packagist/php-v/songshenzong/http-client.svg)](https://packagist.org/packages/songshenzong/http-client)


HttpClient is a extension PHP HTTP client for Guzzle, you can use all of Guzzle's methods and advantages are:

- Use all of Guzzle's methods statically.
- Access the `Response` as an array or object.
- IDE tips are more friendly.
- Other methods, such as `uri` .
- Support Laravel, such as `Queues`, `Notifications` .
- Always sync with Guzzle.


```php
 
$uri = HttpClient::uri('https://packagist.org/search.json', ['q' => 'songshenzong']);
// https://packagist.org/search.json?q=songshenzong
 
$response = HttpClient::request('GET', $uri);
// $response = HttpClient::get($uri);
// $response = HttpClient::post($uri);
// $response = HttpClient::put($uri);
// $response = HttpClient::delete($uri);
 
print_r($response->toArray());
// Array
// (
// [results] => Array
// )
 
echo $response['total'];
// 12
 
echo $response->total;
// 12
 
var_dump($response->isJson());
// bool(true)
 
var_dump($response->isXml());
// bool(false)

var_dump($response->isSerialized());
// bool(false)

print_r($response->serialize());
// s:2732:"{"results":[{"name":"songshenzong...
 
var_dump($response->unserialize());
// false | object | array
 
echo $response->getStatusCode();
// 200
 
echo $response->getHeaderLine('content-type');
// application/json
 
echo $response->getBody();
// {"results":[{"name":"songshenzong...}
 
// Send an asynchronous request.
$promise = HttpClient::requestAsync('GET', $uri)->then(function ($response) {
    $response = new \Songshenzong\HttpClient\Response($response);
    echo $response['total'];
});
 
$promise->wait();
  
```



## Installation

Installing the latest stable version:

```bash
composer require songshenzong/http-client
```

You can update using composer:

 ```bash
composer update
 ```


## Laravel Queues

```php
 
CurlJob::dispatch('GET', 'https://packagist.org/search.json?q=songshenzong');
 
CurlJob::dispatchNow('GET', 'https://packagist.org/search.json?q=songshenzong');
 
```





## Laravel Notifications

```php
Notification::send($user, new CurlNotification('GET', 'https://packagist.org/search.json?q=songshenzong'));
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
    return HttpClient::request('GET', 'https://packagist.org/search.json?q=songshenzong');
}

```


## Documentation

HttpClient is a extension PHP HTTP client for Guzzle, you can use all of Guzzle's methods.

- [Guzzle Documentation](http://guzzlephp.org/)
- [Guzzle Stack Overflow](http://stackoverflow.com/questions/tagged/guzzle)
- [Guzzle Gitter](https://gitter.im/guzzle/guzzle)

## Support

For answers you may not find in the Wiki, avoid posting issues. Feel free to ask for support on Songshenzong.com


## License

This package is licensed under the [BSD 3-Clause license](http://opensource.org/licenses/BSD-3-Clause).
