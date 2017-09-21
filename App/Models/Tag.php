<?php

namespace App\Models;

use Core\Model;


/**
 * Class Tag
 * @package App\Models
 */
class Tag extends Model
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
        $this->dbTable = 'tag';
    }

    /**
     * @return bool
     */
    public function getTagsByKeyword($params)
    {

        $sql = "SELECT name FROM $this->dbTable where name LIKE '" . strtoupper($params['term']) . "%'";
        $stm = $this->db->prepare($sql);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetchAll(\PDO::FETCH_ASSOC);
            echo json_encode($row);
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function getTags()
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
