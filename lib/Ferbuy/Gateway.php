<?php
/**
 * Ferbuy Gateway class
 *
 * @package    Ferbuy
 * @copyright  2015 FerBuy
 */
class Ferbuy_Gateway
{
    /**
     * Constructor
     *
     * @param array  $postData    Data which will be posted to gateway.
     * @param int    $siteId      Site ID
     * @param string $secret      Shared secret
     * @param string $gatewayBase Gateway's base URL
     *
     * @return null
     */
    public function __construct($postData=array(), $siteId=null,
        $secret=null, $gatewayBase=null
    ) {
        $this->_env = Ferbuy::$env;

        if (!$siteId) {
            $siteId = Ferbuy::$siteId;
        }
        $this->_siteId = $siteId;

        if (!$secret) {
            $secret = Ferbuy::$secret;
        }
        $this->_secret = $secret;

        if (!$gatewayBase) {
            $gatewayBase = Ferbuy::$gatewayBase;
        }
        $this->_gatewayBase = $gatewayBase;

        if (!array_key_exists('site_id', $postData)) {
            $postData['site_id'] = $this->_siteId;
        }
        if (!array_key_exists('checksum', $postData)) {
            $postData['checksum'] = $this->checksum($postData);
        }
        $this->_postData = $postData;
    }

    /**
     * Calculate verification hash
     *
     * @param array $data Post data to be signed
     *
     * @return string Return sha1 hash digest
     */
    public function checksum($data)
    {
        $signature = join("&", array(
            $this->_env,
            $this->_siteId,
            $data['reference'],
            $data['currency'],
            $data['amount'],
            $data['first_name'],
            $data['last_name'],
            $this->_secret
        ));

        return sha1($signature);
    }

    /**
     * Return gateway URL for POST request
     *
     * @return string
     */
    public function url()
    {
        return $this->_gatewayBase . $this->_env . '/';
    }

    /**
     * Render method
     *
     * Method will return POST fields which should be submitted to
     * FerBuy Gateway for processing.
     *
     * @return string
     */
    public function render()
    {
        $fields = '';
        foreach ($this->_postData as $key => $value) {
            $fields .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';
        }

        return $fields;
    }

    /**
     * Verify POST callback from FerBuy's Gateway
     *
     * @param array $data POST data received from gateway.
     *
     * @return boolean
     */
    public static function verifyCallback($data)
    {
        $checksum = join("&", array(
            Ferbuy::$env,
            $data['reference'],
            $data['transaction_id'],
            $data['status'],
            $data['currency'],
            $data['amount'],
            Ferbuy::$secret
        ));

        return $data['checksum'] == sha1($checksum);
    }
}
?>
