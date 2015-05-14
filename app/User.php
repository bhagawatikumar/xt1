<?php
/**
 * User Class File
 * @package       app
 * @since         V 1.0.0[Dated - 14/05/2015 ]
 * @author        Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 * @
 */

/**
 * User Class For all user related activity
 *
 * @author Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 */
require_once 'Constants.php';
class User {

    public static $usersArray;              //For Storing Static Users Array | array('Username' => 'Password')
    public function setUsers($userArray = array()) {
        if (!empty($userArray) && count($userArray) > 0) {
            self::$usersArray = $userArray;
        } else {
            self::$usersArray = array('admin' => 'admin', 'bhagawati' => 'bhagawati');
        }
        return self::$usersArray;
    }

    public function getUsers() {
        if (!empty(self::$usersArray) && count(self::$usersArray) > 0) {
            return self::$usersArray;
        } else {
            return $this->setUsers();
        }
    }

    public function validate($username, $password) {
        if ($username) {           
            $allUsers = $this->getUsers();
            if (array_key_exists($username, $allUsers) && $allUsers[$username] === $password) {
                    return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }
}
    