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


### Example Gateway usage

Example Gateway call and redirect to checkout page:

```php
require_once "/path/to/ferbuy-php/lib/Ferbuy.php";

Ferbuy::setSiteId(1000);
Ferbuy::setSecret('your_secret');
Ferbuy::setEnv('demo');

$data = array(
    'reference' => 'Transaction-'.rand(10000, 99999),
    'currency' => 'EUR',
    'amount' => rand(10000, 99999),
    'return_url_ok' => 'http://www.your-site.com/success/',
    'return_url_cancel' => 'http://www.your-site.com/failed/',
    'first_name' => 'Joe',
    'last_name' => 'Doe',
    'address' => 'Business Center',
    'postal_code' => 'SLM000',
    'city' => 'Landville',
    'country_iso' => 'US',
    'email' => 'demo@email.com',
);

$gateway = new Ferbuy_Gateway($data);
```

In your template render the form fields:

```html
<form method="post" action="<?php echo $gateway->url(); ?>">
    <?php echo $gateway->render(); ?>
    <input type="submit" value="Submit">
</form>
```

To verify the call you can use the following snippet:

```php
require_once "/path/to/ferbuy-php/lib/Ferbuy.php";

Ferbuy::setSiteId(1000);
Ferbuy::setSecret('your_secret');
Ferbuy::setEnv('demo');

if (Ferbuy_Gateway::verifyCallback($_POST)) {
    if ($_POST['status'] == 200) {
        // Transaction successful
    } elseif ($_POST['status'] >= 401) {
        // Transaction failed
    }
} else {
    // Incorrect checksum
}

exit($_POST['transaction_id'] . '.' . $_POST['status']);
```

### Example API usage

Example API call to refund a transaction for 1 EUR:

```php
require_once "/path/to/ferbuy-php/lib/Ferbuy.php";

Ferbuy::setSiteId(1000);
Ferbuy::setSecret('your_secret');

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
Ferbuy::setSecret('your_secret');

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
