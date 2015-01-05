<?php
/**
 * Simple placeholder for API response
 *
 * @package    Ferbuy
 * @copyright  2015 FerBuy
 */
class Ferbuy_Object extends stdClass
{
    /**
     * Converts array to Ferbuy_Object
     *
     * @param array $array Array which will be converted.
     *
     * @return Ferbuy_Object
     */
    public static function create($array=array())
    {
        $obj = new Ferbuy_Object;
        foreach ($array as $k => $v) {
            if (strlen($k)) {
                if (is_array($v)) {
                    $obj->{$k} = self::create($v);
                } else {
                    $obj->{$k} = $v;
                }
            }
        }
        return $obj;
    }
}
