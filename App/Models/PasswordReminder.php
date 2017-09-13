<?php

namespace App\Models;

use Core\Model;

/**
 * Class PasswordReminder
 * @package App\Models
 */
class PasswordReminder extends Model
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
        $this->dbTable = 'password_reminders';
    }


    /**
     * @param $email
     * @param $token
     */
    public function storeResetPasswordToken($email, $token)
    {

        $sql = "INSERT INTO $this->dbTable (
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

    /**
     * @param $token
     * @return array|bool
     */
    public function getEmailByToken($token)
    {
        $sql = "SELECT *,COUNT(email) AS count FROM $this->dbTable WHERE token = :token";
        $stm = $this->db->prepare($sql);

        $stm->bindParam(":token", $token);

        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row['count'] > 0 ? ['success' => true, 'email' => $row['email']] : ['success' => false];
        } else {
            return false;
        }
    }

    /**
     * @param $email
     */
    public function removeTokenByEmail($email)
    {
        $sql = "DELETE FROM $this->dbTable WHERE email = :email;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":email", $email);
        $stm->execute();
    }
}
