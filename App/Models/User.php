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

    public function getUserByEmail($email){
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

    public function storeResetPasswordToken($email,$token){

        $sql = "INSERT INTO password_reminders (
                        email,
                        token
                    ) VALUES (
                        :email,
                        :token
                    )";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":email", $email);
        $stm->bindParam(":token", $token);

        $stm->execute();
    }

    public function getEmailByToken($token){
        $sql = "SELECT *,COUNT(email) AS count FROM password_reminders WHERE token = :token";
        $stm = $this->db->prepare($sql);

        $stm->bindParam(":token", $token);

        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row['count'] > 0 ? ['success'=>true,'email'=>$row['email']] : ['success'=>false];
        } else {
            return false;
        }
    }

    public function changePassword($password,$email){
        $sql = "UPDATE  $this->dbTable SET `password` = :password WHERE email = :email;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":password", $password);
        $stm->bindParam(":email", $email);
        $stm->execute();
    }
}
