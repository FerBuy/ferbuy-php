<?php
/**
 * Ferbuy Transaction resource
 * PHP Version 5
 *
 * @package    Ferbuy
 * @copyright  2015 FerBuy
 */
class Ferbuy_Transaction extends Ferbuy_ApiResource
{
    /**
     * Refund a transaction and return a response object.
     *
     * Sometimes orders are being returned. In case that happens,
     * you can do a refund. This can be a full refund or a partial refund.
     *
     * @param array $params Specific resource parameters which will be send to API
     *   Expected parameters:
     *      transaction_id (int|string) Transaction ID with FerBuy.
     *      amount (int) Refunded amount without decimal point.
     *          For example to refund 20.98 EUR the amount needs to be `2098`.
     *      currency (string) Currency code following ISO 4217 format.
     *          Supported currencies are: USD, EUR, CZK, PLN, SGD.
     *
     * @return Ferbuy_Object Response object containing API's request and response.
     */
    public static function refund($params)
    {
        $requestor = Ferbuy_ApiRequestor::getInstance();

        $post_data = array(
            'command' => $params['currency'].$params['amount'],
            'output_type' => self::OUTPUT_TYPE,
            'site_id' => $requestor->_siteId,
            'transaction_id' => $params['transaction_id'],
        );
        $post_data['checksum'] = $requestor->sign($post_data);

        $response = $requestor->request('post', '/RefundTransaction', $post_data);
        return $response;
    }
}
