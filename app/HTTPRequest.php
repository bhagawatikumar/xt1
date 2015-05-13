<?php

/**
 * All Http requests
 *
 * @author BK
 */

class HTTPRequest {

    public $defaultRequestURL = "http://localhost/api/test.php";
    public $defaultRequestMethod = "GET";
    public function __construct() {

    }

    /**
     * 
     * @param type $options => url : URL to hit
     *                         method : Request Method like POST|GET| 
     *                         data : Array of variables to be passed
     * @return FASLE if error|returns data respose from http request
     */
    public function httpRequest($options = array()) {
        if (!empty($options)) {
            extract($options);
            if (!isset($url)) {
                $url = $this->defaultRequestURL;
            }
            if (!isset($method)) {
                $method = $this->defaultRequestMethod;
            }

            if ($method == 'POST') {
                if (!isset($data) || !is_array($data) || empty($data)) {
                    return false;
                }
            } else if ($method == 'GET') {
                if (!isset($data) || !is_array($data) || empty($data)) {
                    return false;
                }

                if (strpos($url, '?')) {
                    $tmp = '&';
                } else {
                    $tmp = '?';
                }
                $i = 0;
                foreach ($data as $key => $d) {
                    if ($i === 0) {
                        $tmp .= $key . "=" . rawurlencode($d);
                    } else {
                        $tmp .= '&' . $key . "=" . rawurlencode($d);
                    }
                    $i++;
                }
                $url .= $tmp;
            }
            $ch = curl_init();
            if ($url == '') {
                $url = $this->defaultRequestURL;
            }
//            pr($url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if (is_array($data) && !empty($data) && $method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
            $logOpt['method'] = $method;
            $logOpt['url'] = $url;
            $logOpt['data'] = implode('|', $data);
            $output = curl_exec($ch);
            if (!$output) {
                $err = curl_error($ch);
                $logOpt['error'] = $err;
                $output = 'err';
//                echo $err;
//                exit;
            }
//            pr($logOpt);
//           $this->ObjLog->log($logOpt);
            curl_close($ch);
            return $output;
        } else {
            return false;
        }
    }

}
