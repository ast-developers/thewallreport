<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

    public $db;

    public function __construct(){
        $this->db= static::getDB();
    }
    public function checkLogin($username,$password){
        $password = md5($password);
        $count = $this->db->query("SELECT COUNT(id)  FROM users WHERE ( username='$username' OR email = '$username') and password='$password'");
        return $count->fetchColumn();
    }
}
