# FerBuy PHP bindings

The FerBuy PHP library provides integration access to the FerBuy Gateway.

## Dependencies

PHP version >= 5.2.1 required.

The following PHP extensions are required:

* curl
* json
* hash

## Manual Installation

You need to checkout the source code from GitHub to install the package.
The easiest way to do so it to run:

```
$ git clone https://github.com/FerBuy/ferbuy-php.git
```

To use the bindings, add the following to your PHP script:

```
require_once "/path/to/ferbuy-php/lib/Ferbuy.php";
```

## Quick Start Example

Example API call to refund a transaction for 1 EUR:

```php
require_once "/path/to/ferbuy-php/lib/Ferbuy.php";

Ferbuy::setSiteId(1000);
Ferbuy::setApiSecret('your_api_secret');

$result = Ferbuy_Transaction::refund(array(
    'transaction_id' => '10000',
    'amount' => 100,
    'currency' => 'EUR'
));

if ($result->response->code == 200) {
    echo "Success!";
    echo $result->response->message;
} else {
    echo "Failure...";
    echo $result->response->message;
}
```

Example call for marking order as shipped:

```php
require_once "/path/to/ferbuy-php/lib/Ferbuy.php";

Ferbuy::setSiteId(1000);
Ferbuy::setApiSecret('your_api_secret');

$result = Ferbuy_Order::shipped(array(
    'transaction_id' => '10000',
    'courier' => 'DHL',
    'tracking_number' => '12345'
));
```

## Testing

TO BE ADDED.

## Documentation

TO BE ADDED.

## License

See the LICENSE file.
