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

}
