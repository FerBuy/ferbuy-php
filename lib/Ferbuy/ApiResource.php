<?php
/**
 * Base class for all Ferbuy Api resources
 * PHP Version 5
 *
 * @package    Ferbuy
 * @copyright  2015 FerBuy
 */
abstract class Ferbuy_ApiResource
{
    /**
     * Only JSON format is supported with the API binding
     */
    const OUTPUT_TYPE = 'json';
}
