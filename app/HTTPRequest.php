<?php
require_once 'Constants.php';
/**
 * All Http requests
 *
 * @author Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 */
class HTTPRequest {

    public $requestURL;
    public $requestMethod;
    public $username;
    public $password;
    
    public function setUrl($url){
        $this->requestURL = $url;
    }
    public function setMethod($method){
        $this->requestMethod = $method;
    }
    public function setUsername($username){
        $this->username = $username;
    }
    public function setPassword($password){
        $this->password = $password;
    }

        /**
     * 
     * @param type $options => data : Array of variables to be passed eg. array('key_name' => 'value','key_name2' => 'value2' ...)
     * @return FASLE if error|returns data respose from http request
     */
    public function request($data = array()) {
        if (!empty($data)) {
            $tmpUrl = '';                                           //Temp URL Generation 
            if ($this->requestMethod == 'GET') {
                if (!strpos($this->requestURL, '?')) {
                    $tmpUrl = '?';
                }
                foreach ($data as $key => $d) {
                    if ($tmpUrl == '') {
                        $tmpUrl .= '&';
                    }
                    $tmpUrl .= $key . "=" . rawurlencode($d);
                }
                $this->requestURL .= $tmpUrl;
            }
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->requestURL);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ); 
        curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->username);
        if (!empty($data) && $this->requestMethod == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $output = curl_exec($ch);
        $header_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($output, $header_size);
        if (!$output) {
            pr(curl_error($ch));
            return FALSE;
        }
        curl_close($ch);
        $response['code'] = $header_code;
        $response['body'] = json_decode($body,TRUE);
        return $response;
    }

}
