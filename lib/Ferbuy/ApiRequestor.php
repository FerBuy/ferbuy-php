<?php
/**
 * Ferbuy Api requestor module
 * PHP Version 5
 * Processes and manages calls to API
 *
 * @package    Ferbuy
 * @copyright  2015 FerBuy
 */
class Ferbuy_ApiRequestor
{
    /**
     * @var Ferbuy_ApiRequestor Contains instance of the object
     */
    private static $_instance;

    /**
     * Constructor
     *
     * @param int    $siteId    Site id
     * @param string $apiSecret API secret
     * @param string $apiBase   API's base URL
     *
     * @return null
     */
    public function __construct($siteId=null, $apiSecret=null, $apiBase=null)
    {
        if (!$siteId) {
            $siteId = Ferbuy::$siteId;
        }
        $this->_siteId = $siteId;

        if (!$apiSecret) {
            $apiSecret = Ferbuy::$apiSecret;
        }
        $this->_apiSecret = $apiSecret;

        if (!$apiBase) {
            $apiBase = Ferbuy::$apiBase;
        }
        $this->_apiBase = $apiBase;
    }

    /**
     * Obtain an object instance
     *
     * @return Ferbuy_ApiRequestor
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new Ferbuy_ApiRequestor();
        }
        return self::$_instance;
    }

    /**
     * Calculate verification hash
     *
     * @param array $data Post data to be signed
     *
     * @return string Return sha1 hash digest
     */
    public function sign($data)
    {
        $signature = join("&", array(
            $this->_siteId,
            $data['transaction_id'],
            $data['command'],
            $data['output_type'],
            $this->_apiSecret
        ));

        return sha1($signature);
    }

    /**
     * Submit request to API
     *
     * @param string     $method  HTTP method
     * @param string     $url     URL to call
     * @param array|null $data    POST data
     * @param array|null $headers Additional headers
     *
     * @return Ferbuy_Object An Ferbut_Object instance
     */
    public function request($method, $url, $data=null, $headers=null)
    {
        if (!$data) {
            $data = array();
        }

        if (!$headers) {
            $headers = array();
        }

        list($response, $status_code)
            = $this->_apiCall($method, $url, $data, $headers);

        $result = $this->_processResponse($response, $status_code);
        return $result;
    }

    /**
     * Method calling and processing response from the API.
     *
     * @param string $method  HTTP method
     * @param string $url     URL to call
     * @param array  $data    POST data
     * @param array  $supplied_headers Additional headers
     *
     * @return array An Ferbut_Object instance
     */
    private function _apiCall($method, $url, $data, $supplied_headers)
    {
        $absUrl = $this->_apiBase.$url;
        $method = strtolower($method);

        if ($method == 'get' || $method == 'delete') {
            $post_data = array();
        } else if ($method == 'post' || $method == 'put') {
            $post_data = http_build_query($data);
        } else {
            $msg = "Unrecognized HTTP method $method. This may indicate a bug"
                 . " in the FerBuy PHP library.";
            throw new Ferbuy_ApiConnectionError($msg);
        }

        $addInfo = array(
            'bindings_version' => Ferbuy::VERSION,
            'lang' => 'PHP',
            'lang_version' => phpversion(),
            'platform' => php_uname(),
        );

        $headers = array(
            'X-FerBuy-Client-User-Agent: ' . json_encode($addInfo),
            'User-Agent: FerBuy/v1 PhpBindings/' . Ferbuy::VERSION,
        );

        if ($method == 'post') {
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        }

        if (!empty($supplied_headers)) {
            foreach ($supplied_headers as $value) {
                $headers[] = $value;
            }
        }

        $curl = curl_init();
        $curl_opts = array();

        if ($method == 'get') {
            $curl_opts[CURLOPT_HTTPGET] = 1;
        } else if ($method == 'post') {
            $curl_opts[CURLOPT_POST] = 1;
            $curl_opts[CURLOPT_POSTFIELDS] = $post_data;
        } else if ($method == 'delete') {
            $curl_opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        }

        $curl_opts[CURLOPT_URL] = $absUrl;
        $curl_opts[CURLOPT_RETURNTRANSFER] = true;
        $curl_opts[CURLOPT_CONNECTTIMEOUT] = 30;
        $curl_opts[CURLOPT_TIMEOUT] = 80;
        $curl_opts[CURLOPT_RETURNTRANSFER] = true;
        $curl_opts[CURLOPT_HTTPHEADER] = $headers;

        curl_setopt_array($curl, $curl_opts);
        $response = curl_exec($curl);

        if ($response === false) {
            $errno = curl_errno($curl);
            $message = curl_error($curl);
            curl_close($curl);
            $this->_handleCurlError($errno, $message);
        }

        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return array($response, $status_code);
    }

    /**
     * Handle cURL connection error problem
     *
     * @param number $errno   Error number
     * @param string $message Error message
     *
     * @return null
     * @throws Ferbuy_ApiError
     */
    private function _handleCurlError($errno, $message)
    {
        $apiBase = $this->_apiBase;
        switch ($errno) {
        case CURLE_COULDNT_CONNECT:
        case CURLE_COULDNT_RESOLVE_HOST:
        case CURLE_OPERATION_TIMEOUTED:
            $msg = "Could not connect to FerBuy ($apiBase).  Please check your "
                 . "internet connection and try again.";
            break;
        case CURLE_SSL_CACERT:
        case CURLE_SSL_PEER_CERTIFICATE:
            $msg = "Could not verify FerBuy's SSL certificate.  Please make sure "
                 . "that your network is not intercepting certificates.";
            break;
        default:
            $msg = "Unexpected error communicating with FerBuy.";
        }
        $msg .= " If this problem persists,let us know at support@ferbuy.com.";

        $msg .= "\n\n(Network error [errno $errno]: $message)";
        throw new Ferbuy_ApiError($msg);
    }

    /**
     * Process API response and return Ferbuy_Object
     *
     * @param string $response    Encoded response from the API
     * @param int    $status_code HTTP status code
     *
     * @return Ferbuy_Object Contains data from the API response.
     * @throws Ferbuy_ApiError|Ferbuy_InvalidRequestError
     */
    private function _processResponse($response, $status_code)
    {
        if ($status_code > 300) {
            if ($status_code == 400 || $status_code == 401) {
                $msg = sprintf(
                    "Invalid request error %s %d",
                    $reponse, $status_code
                );
                throw new Ferbuy_InvalidRequestError($msg);
            } else {
                $msg = sprintf(
                    "API request error %s %d",
                    $reponse, $status_code
                );
                throw new Ferbuy_ApiError($msg);
            }
        }

        $resp_array = json_decode($response, true);

        if (array_key_exists('api', $resp_array)) {
            $obj = Ferbuy_Object::create($resp_array['api']);
            return $obj;
        } else if (array_key_exists('error', $resp_array)) {
            $obj = Ferbuy_Object::create($resp_array['error']);
            $msg = $obj->errorSubject . '. ' . $obj->errorDetail;
            throw new Ferbuy_ApiError($msg);
        }

        return $obj;
    }
}
