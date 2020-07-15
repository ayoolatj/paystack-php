# Yet another PHP API wrapper for [Paystack](https://paystack.co/).

[![Packagist][ico-version]][link-packagist]
[![License][ico-license]](LICENSE.md)

This library aims to provide convenient access to the Paystack API using predefined
services grouped following the [Paystack API Docs](https://paystack.com/docs/api/).
These service classes initialize defined Resources dynamically from API responses.

## Requirements

- PHP 7.1+

## Installing

### via Composer

To install the package via [Composer](http://getcomposer.org/), run the following command:

```bash
composer require ayoolatj/paystack-php
```


## Dependencies

- [Guzzle](https://github.com/guzzle/guzzle)

Dependencies should be handled automatically by composer.

## Usage

Using the paystack instance, you can perform multiple actions across several
services as well as retrieve different resources.

```php
$paystack = new \Ayoolatj\Paystack\Paystack(PAYSTACK_SECRET_KEY);
try {
    $charge = $paystack->charge->charge([
        'email' => 'test@example.com',
        'amount' => '1000000',
        'bank' => ['code' => '057', 'account_number' => '0000000000'],
        'birthday' => '1994-07-04',
    ]);
} catch (\Ayoolatj\Paystack\Exceptions\ApiException $e) {
    print_r($e->getResponse());
}
// process Charge resource
```

### Accessing Resource Attributes

You can access the resource attributes via `toArray()`.

```php
$plan = $paystack->plans->create([
    'name' => 'New Plan',
    'amount' => '1000000',
    'interval' => 'biannually'
]);
print_r($plan->toArray());
```

### Accessing response data

You can access the data from the last API response on any resource object via `getLastResponse()`.

```php
$charge = $paystack->charge->charge([
    'email' => 'test@example.com',
    'amount' => '1000000',
    'bank' => ['code' => '057', 'account_number' => '0000000000'],
    'birthday' => '1994-07-04',
]);
echo $charge->getLastResponse()->headers['Date'];
```

### Pagination

All services with a **list** endpoint support pagination and pagination
parameters can be passed along to limit the result set.

```php
$plans = $paystack->plans->all([
    'perPage' => 20,
    'page' => 2,
]);
```

#### Auto-Pagination

List endpoints return an instance of a Paginator class which supports
auto-pagination. This makes it easy to handle fetching multi page lists
without having to manually paginate results and perform subsequent requests.

To use the auto-pagination feature, call `autoPagingIterator()` on the returned
Paginator object to iterate over all objects matching your initial parameters.

```php
$plans = $paystack->plans->all([
    'perPage' => 20,
    'page' => 2,
]);

foreach ($plans->autoPagingIterator() as $plan) {
  // Do something with $plan
}
```

### Webhooks

Paystack uses webhooks to notify your application when transaction events
occur on your integration. It is important to verify that events originate
from Paystack to avoid delivering value based on a counterfeit event.

To verify a paystack event:

```php
$input = @file_get_contents('php://input');
$paystack_signature = $_SERVER['HTTP_X_PAYSTACK_SIGNATURE'];

try {
    \Ayoolatj\Paystack\Webhook::verifyEvent($input, $paystack_signature, PAYSTACK_SECRET_KEY);
} catch (\Ayoolatj\Paystack\Exceptions\SignatureVerificationException $e) {
    $input = $e->getHttpBody();
    $header = $e->getSigHeader();
    
    exit();
}
```

## Testing

``` bash
vendor/bin/phpunit
```

## TODOs

- [ ] Authorization Resource
- [ ] Roundup tests
- [ ] Metadata builder
- [ ] Clean up readme
- [ ] Non composer loader

[ico-version]: https://img.shields.io/packagist/v/ayoolatj/paystack-php.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/ayoolatj/paystack-php
