<?php
require_once './lib/Ferbuy.php';

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
