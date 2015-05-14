<?php

/**
 * API Class File
 * @package       app
 * @since         V 1.0.0[Dated - 14/05/2015 ]
 * @author        Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 * @
 */
/**
 * API Class For all API processing
 *
 * @author Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 */
require_once 'HTTPRequest.php';

class Api extends HTTPRequest {

    public $username;
    public $password;
    public $repositoryUrl;
    public $contributer;
    public static $finalCount = 0;

    public function __construct($username, $password, $repositoryUrl, $contributor) {
        $this->username = $username;
        $this->password = $password;
        $this->repositoryUrl = $repositoryUrl;
        $this->contributer = $contributor;
    }

    public function getServiceType() {
        return parse_url($this->repositoryUrl, PHP_URL_HOST);
    }

    public function getRepoName() {
        return parse_url($this->repositoryUrl, PHP_URL_PATH);
    }

    public function makeCurlRequest($url, $method) {
        $this->setUrl($url);
        $this->setMethod($method);
        $this->setUsername($this->username);
        $this->setPassword($this->password);
        return $this->request();
    }

    public function getCountForGit($response = array()) {
        if (!empty($response)) {
            foreach ($response as $key => $val) {
                if ($val['author']['login'] === $this->contributer) {
                    self::$finalCount += $val['total'];
                }
            }
            return "Total Number Of Commits by $this->contributer: " . self::$finalCount . " \n";
            ;
        } else {
            return 'Unable To find Count';
        }
    }

    public function getCountForBit($response = array()) {
        if (!empty($response)) {
            foreach ($response['values'] as $commit) {
                if (isset($commit['user']) && !empty($commit['user']) && $commit['user']['username'] === $this->contributer) {
                    ++self::$finalCount;
                } else if (!isset($commit['user'])) {
                    ++self::$finalCount;
                }
            }
            if (isset($response['next']) && $response['next'] != '') {
                $responseRecursive = $this->makeCurlRequest($response['next'], 'get');
                if ($responseRecursive['code'] == 200) {
                    $this->getCountForBit(json_decode($responseRecursive['body'], true));
                }
            } else {
                return "Total Number Of Commits by $this->contributer: " . self::$finalCount . " \n";
            }
        } else {
            if (self::$finalCount > 0) {
                return "Total Number Of Commits by $this->contributer: " . self::$finalCount . " \n";
            }
            return 'Unable To find Count';
        }
    }

    public function processRequest() {
        $serviceType = $this->getServiceType();
        $repoPath = $this->getRepoName();
        $apiUrl = sprintf(constant("__APIURL__" . $serviceType), $repoPath);
        $response = $this->makeCurlRequest($apiUrl, 'get');
        switch ($serviceType) {
            case 'github.com':
                if ($response['code'] == 200) {
                    return $this->getCountForGit($response['body']);
                } else if ($response['code'] == 202) {
                    return strtoupper($serviceType) . " is building the result for request . Try after few seconds.\n";
                } else {
                    return $response['body']['message']."\n";
                }
                break;
            case 'bitbucket.org':
                if ($response['code'] == 200) {
                    return $this->getCountForBit($response['body']);
                } else {
                    return $response['body']['error']['message']."\n";
                }
                break;
        }
    }

}
