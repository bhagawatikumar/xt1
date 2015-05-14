<?php

/**
 * Common Constants For App
 * @package       app
 * @since         V 1.0.0[Dated - 13/05/2015 ]
 * @author        Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 * 
 */
error_reporting(E_ALL);
require_once 'CommonFunctions.php';
$constants = array(
    "__APIURL__" => array(
        'github.com' => "https://api.github.com/repos%s/stats/contributors",         //GITHUB Api Url Called as __APIURL__github.com
//        'bitbucket.org' => "https://bitbucket.org/api/2.0/repositories%s/events?type=&limit=50&start=0",       //BITBUCKET Api Url Called as __APIURL__bitbucket.com
        'bitbucket.org' => "https://bitbucket.org/api/2.0/repositories%s/commits",       //BITBUCKET Api Url Called as __APIURL__bitbucket.com
    ),           
); 
defineConstants($constants);                                                    //DEFINE APIURLS AS CONSTANTS
?>
