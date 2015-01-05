<?php
/**
 * Ferbuy_ApiConnectionError
 *
 * @package    Ferbuy
 * @copyright  2015 FerBuy
 */
class Ferbuy_InvalidRequestError extends Ferbuy_Error
{
    /**
     * Constructor
     *
     * @param mixed $message    Error message
     * @param mixed $param      Parameters
     * @param mixed $httpStatus HTTP status code
     * @param mixed $httpBody   HTTP reponse
     * @param mixed $jsonBody   JSON
     */
    public function __construct($message, $param, $httpStatus=null,
        $httpBody=null, $jsonBody=null
    ) {
        parent::__construct($message, $httpStatus, $httpBody, $jsonBody);
        $this->param = $param;
    }
}
