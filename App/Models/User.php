<?php

namespace App\Models;

use Core\Model;

class User extends Model
{

    public $db;

    public function __construct()
    {
        $this->db = static::getDB();
        $this->dbTable = 'users';
    }

    public function getUserForLogin($username, $password)
    {
        $sql = "SELECT *, COUNT(id) AS count FROM $this->dbTable WHERE ( username = :username OR email = :username) and password = :password";
        $stm = $this->db->prepare($sql);

        $stm->bindParam(":username", $username);
        $stm->bindParam(":password", $password);

        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row['count'] > 0 ? $row : false;
        } else {
            return false;
        }
    }
}
