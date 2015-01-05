<?php
/**
 * Ferbuy PHP API binding
 *
 * PHP version 5
 *
 * @category Payment
 * @package  Ferbuy
 * @author   Pavel Saparov <saparov.p@gmail.com>
 * @license  MIT License
 * @link     http://www.ferbuy.com
 */

// This snippet (and some of the curl code) due to the Facebook SDK.
if (!function_exists('curl_init')) {
    throw new Exception('FerBuy needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('FerBuy needs the JSON PHP extension.');
}
if (!function_exists('mb_detect_encoding')) {
    throw new Exception('FerBuy needs the Multibyte String PHP extension.');
}

// Ferbuy
require_once dirname(__FILE__) . '/Ferbuy/Ferbuy.php';

// Errors
require_once dirname(__FILE__) . '/Ferbuy/Error.php';
require_once dirname(__FILE__) . '/Ferbuy/ApiError.php';
require_once dirname(__FILE__) . '/Ferbuy/ApiConnectionError.php';
require_once dirname(__FILE__) . '/Ferbuy/InvalidRequestError.php';

// Goodies
require_once dirname(__FILE__) . '/Ferbuy/Object.php';
require_once dirname(__FILE__) . '/Ferbuy/ApiRequestor.php';
require_once dirname(__FILE__) . '/Ferbuy/ApiResource.php';

// API Resources
require_once dirname(__FILE__) . '/Ferbuy/Transaction.php';
require_once dirname(__FILE__) . '/Ferbuy/Order.php';
