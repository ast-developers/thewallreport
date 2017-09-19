<?php

namespace App\Models;

use Core\Model;


/**
 * Class Role
 * @package App\Models
 */
class Post extends Model
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
        $this->dbTable = 'posts';
    }

    /**
     * @return bool
     */
    public function getRoles()
    {

        $sql = "SELECT * FROM $this->dbTable";
        $stm = $this->db->prepare($sql);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetchAll(\PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    public function insertPostData($params)
    {
        $sql = "INSERT INTO $this->dbTable(name,description,status) VALUES(:name,:description,:status)";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":description", $params['description']);
        $stm->bindParam(":status", $params['status']);
        try {
            return $stm->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updatePostData($params)
    {
        $sql = "UPDATE  $this->dbTable SET name = :name,description=:description,status=:status WHERE id = :id;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":description", $params['description']);
        $stm->bindParam(":status", $params['status']);
        $stm->bindParam(":id", $params['id']);
        try {
            return $stm->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getPostById($id){
        $sql = "SELECT * FROM $this->dbTable WHERE id=:id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":id", $id);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetchAll(\PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

}
