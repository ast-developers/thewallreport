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

    /**
     * @var mixed
     */
    public $db;

    /**
     * FFPost constructor.
     */
    public function __construct()
    {
        $this->db = static::getDB();
        $this->dbTable = 'ff_posts';
    }

    /**
     * @param $post_id
     * @param $feed_id
     * @return bool
     */
    public function getFeedByPostIdAndFeedId($post_id, $feed_id)
    {
        $sql = "SELECT * FROM $this->dbTable";
        $sql .= " where post_id=:post_id AND feed_id=:feed_id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":post_id", $post_id);
        $stm->bindParam(":feed_id", $feed_id);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * @param $feed_id
     */
    public function updateFeedViewCount($feed_id)
    {
        $sql = "UPDATE $this->dbTable SET views=views+1 WHERE post_id='$feed_id'";
        $stm = $this->db->prepare($sql);
        $res = $stm->execute();
    }


}
