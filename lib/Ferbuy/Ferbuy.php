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
    const VERSION = '1.0.1';

    /**
     * @var string The FerBuy Gateway environment.
     */
    public static $env;

    /**
     * @var string The FerBuy shared secret used in checksum verification.
     */
    public static $secret;

    /**
     * @var int The Ferbuy site ID.
     */
    public static $siteId;

    /**
     * @ var string The base URL for the FerBuy Gateway requests.
     */
    public static $gatewayBase = 'https://gateway.ferbuy.com/';

    /**
     * @ var string The base URL for the FerBuy API requests.
     */
    public static $apiBase = 'https://gateway.ferbuy.com/api';

    /**
     * Get Gateway environmen
     *
     * @return string Demo or live environment
     */
    public static function getEnv()
    {
        return self::$env;
    }

    /**
     * Set Gateway environment
     *
     * @param string $env Demo or live env
     *
     * @return null
     */
    public static function setEnv($env)
    {
        self::$env = $env;
    }

    /**
     * Get shared secret
     *
     * @return string The FerBuy's shared secret key used for requests.
     */
    public static function getSecret()
    {
        return self::$secret;
    }

    /**
     * Set the FerBuy's shared secret used in checksum verification.
     *
     * @param string $secret Shared secret
     *
     * @return null
     */
    public static function setSecret($secret)
    {
        self::$secret = $secret;
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
