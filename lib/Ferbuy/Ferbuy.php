<?php
/**
 * Ferbuy base abstract class
 *
 * @package    Ferbuy
 * @copyright  2015 FerBuy
 */
abstract class Ferbuy
{
    /**
     * Client PHP binding project version.
     */
    const VERSION = '1.0.0';

    /**
     * @var string The FerBuy API secret to be used for requests.
     */
    public static $apiSecret;

    /**
     * @var int The Ferbuy site ID.
     */
    public static $siteId;

    /**
     * @ var string THe base URL for the FerBuy API requests.
     */
    public static $apiBase = 'https://gateway.ferbuy.com/api';

    /**
     * Get API secret
     *
     * @return string The API secret key used for requests.
     */
    public static function getApiSecret()
    {
        return self::$apiSecret;
    }

    /**
     * Sets the API secret key to be used for requests.
     *
     * @param string $apiSecret API secret key
     *
     * @return null
     */
    public static function setApiSecret($apiSecret)
    {
        self::$apiSecret = $apiSecret;
    }

    /**
     * Get site ID
     *
     * @return int The site ID used in requests.
     */
    public static function getSiteId()
    {
        return self::$siteId;
    }

    /**
     * Sets the site ID to be used for requests.
     *
     * @param string $siteId Site ID
     *
     * @return null
     */
    public static function setSiteId($siteId)
    {
        self::$siteId = $siteId;
    }
}
