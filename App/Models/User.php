<?php

namespace App\Models;

use Core\Model;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
{

    /**
     * @var mixed
     */
    public $db;

    /**
     *
     */
    public function __construct()
    {
        $this->db = static::getDB();
        $this->dbTable = 'users';
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
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

    /**
     * @param $email
     * @return bool
     */
    public function getUserByEmail($email)
    {
        $sql = "SELECT COUNT(id) AS count FROM $this->dbTable WHERE email = :email";
        $stm = $this->db->prepare($sql);

        $stm->bindParam(":email", $email);

        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row['count'] > 0 ? true : false;
        } else {
            return false;
        }
    }

    /**
     * @param $password
     * @param $email
     */
    public function changePassword($password, $email)
    {
        $sql = "UPDATE  $this->dbTable SET password = :password WHERE email = :email;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":password", $password);
        $stm->bindParam(":email", $email);
        $stm->execute();
    }


}
