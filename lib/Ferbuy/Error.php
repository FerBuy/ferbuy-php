<?php
/**
 * Ferbuy_Error
 *
 * @package    Ferbuy
 * @copyright  2015 FerBuy
 */
class Ferbuy_Error extends Exception
{
    /**
     * Constructor
     *
     * @param mixed $message    Error message
     * @param mixed $httpStatus HTTP status code
     * @param mixed $httpBody   HTTP reponse
     * @param mixed $jsonBody   JSON
     */
    public function __construct($message, $httpStatus=null,
        $httpBody=null, $jsonBody=null
    ) {
        parent::__construct($message);

        $this->message = $message;
        $this->httpStatus = $httpStatus;
        $this->httpBody = $httpBody;
        $this->jsonBody = $jsonBody;
    }

    /**
     * Get HTTP status code
     *
     * @return mixed
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     * Get HTTP response
     *
     * @return mixed
     */
    public function getHttpBody()
    {
        return $this->httpBody;
    }

    /**
     * Get JSON
     *
     * @return mixed
     */
    public function getJsonBody()
    {
        return $this->jsonBody;
    }
}
