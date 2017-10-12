<?php

namespace App\Models;


use Core\Helper;
use Core\Model;


/**
 * Class Menu
 * @package App\Models
 */
class FFPost extends Model
{

    public $db;

    public function __construct()
    {
        $this->db = static::getDB();
        $this->dbTable = 'ff_posts';
    }

    public function checkSlugExistOrNot($slug)
    {
        $sql = "SELECT * FROM $this->dbTable";
        $sql .= " where post_id=:post_id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":post_id", $slug);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    public function updateFeedViewCount($feed_id){
        $sql = "UPDATE $this->dbTable SET views=views+1 WHERE post_id='$feed_id'";
        $stm = $this->db->prepare($sql);
        $res = $stm->execute();
    }



}
