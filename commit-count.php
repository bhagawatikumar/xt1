<?php
/**
 * Commit Count
 * @package       /
 * @since         V 1.0.0[Dated - 14/05/2015 ]
 * @author        Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 * 
 */
require_once 'app/User.php';
$opts = getopt("u:p:");
if(isset($opts['u']) && $opts['u'] != '' && isset($opts['p']) && $opts['p'] != ''){
    $userObj = new User;
    //$userObj->setUsers(array('a' => "a", "b" => "b"));
    if($userObj->validate($opts['u'], $opts['p'])){
        echo "Hi ". $opts['u'] ."\n";        exit;
    }  else {
        echo "Invalid Username Or Passsword!\n";exit;
    }
}else{
    echo "Please Provide -u Username -p Password To Continue!\n";exit;

}

