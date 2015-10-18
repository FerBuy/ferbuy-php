<?php
/**
 * Ferbuy Order resource
 * PHP Version 5
 *
 * @package    Ferbuy
 * @copyright  2015 FerBuy
 */
class Ferbuy_Order extends Ferbuy_ApiResource
{
    /**
     * Mark order as shipped and return a response object.
     *
     * Mark order as shipped as soon as you have shipped it. Marking an order
     * as shipped, will send an invoice to the consumer and will release
     * the transaction amount for payment to you as merchant.
     *
     * @param array $params Specific resource parameters which will be send to API
     *   Expected parameters:
     *      transaction_id (int|string) Transaction ID with FerBuy.
     *      courier (string) Name of the courier company delivering the order.
     *          Supported couriers are: DHL, EMS, Fedex, POSTCZ, POSTPL, UPS.
     *          It's possible to define your own eg. 'DPD'.
     *      tracking_number (int|string) Tracking number supported by courier
     *          company
     *
     * @return Ferbuy_Object Response object containing API's request and response.
     */
    public static function shipped($params)
    {
        $requestor = Ferbuy_ApiRequestor::getInstance();

        $post_data = array(
            'command' => $params['courier'].':'.$params['tracking_number'],
            'output_type' => self::OUTPUT_TYPE,
            'site_id' => $requestor->_siteId,
            'transaction_id' => $params['transaction_id'],
        );
        $post_data['checksum'] = $requestor->sign($post_data);

        $response = $requestor->request('post', '/MarkOrderShipped', $post_data);
        return $response;
    }

    /**
     * Mark order as being delivered and return a response object.
     *
     * For some merchants the `ConfirmDeliver` function is required. If this
     * function is optional, we do recommend that you use this function anyway.
     *
     * @param array $params Specific resource parameters which will be send to API
     *   Expected parameters:
     *      transaction_id (int|string) Transaction ID with FerBuy.
     *      date (string) Date in `Y-m-d H:i:s` format.
     *
     * @return Ferbuy_Object: Response object containing API's request and response.
     */
    public static function delivered($params)
    {
        $requestor = Ferbuy_ApiRequestor::getInstance();

        $post_data = array(
            'command' => $params['date'],
            'output_type' => self::OUTPUT_TYPE,
            'site_id' => $requestor->_siteId,
            'transaction_id' => $params['transaction_id'],
        );
        $post_data['checksum'] = $requestor->sign($post_data);

        $response = $requestor->request('post', '/ConfirmDelivery', $post_data);
        return $response;
    }
}
