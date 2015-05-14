<?php
/**
 * Commit Count
 * @package       /
 * @since         V 1.0.0[Dated - 14/05/2015 ]
 * @author        Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 * 
 */
if(count($argv) == 7){
    require_once 'app/Api.php';
    $apiObj = new Api($argv[2], $argv[4], $argv[5], $argv[6]);
    echo $apiObj->processRequest();    exit;
    
}else{
    echo "Invalid Call!\n";exit;
}

