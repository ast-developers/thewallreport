<?php

namespace App\Models;

use App\Repositories\Admin\TagRepository;
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
     * @var TagRepository
     */
    protected $tag_repo;

    /**
     *
     */
    public function __construct()
    {
        $this->db = static::getDB();
        $this->dbTable = 'posts';
        $this->tag_repo = new TagRepository();
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

    /**
     * @param $params
     * @return bool
     */
    public function insertPostData($params)
    {
        $sql = "INSERT INTO $this->dbTable(name,description,status) VALUES(:name,:description,:status)";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":description", $params['description']);
        $stm->bindParam(":status", $params['status']);
        try {
            $stm->execute();
            $last_insert_id = $this->db->lastInsertId();
            $this->addPostsCategories($params, $last_insert_id);
            $this->addPostTags($params, $last_insert_id);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * @param $params
     * @param $post_id
     */
    public function addPostsCategories($params, $post_id)
    {

        if (!empty($params['category_id'])) {
            foreach ($params['category_id'] as $value) {
                $sql = "INSERT INTO post_category(post_id,category_id) VALUES(:post_id,:category_id)";
                $stm = $this->db->prepare($sql);
                $stm->bindParam(":post_id", $post_id);
                $stm->bindParam(":category_id", $value);
                $stm->execute();
            }
        }
        return;

    }

    /**
     * @param $params
     * @param $post_id
     */
    public function addPostTags($params, $post_id)
    {
        $tagData = [];
        if (!empty($params['tag'])) {
            $tags = $this->tag_repo->getTags();
            foreach ($tags as $tag) {
                $tagData[] = str_replace("'", '', $tag['name']);
            };
            foreach (explode(',', $params['tag']) as $value) {
                if (!in_array($value, $tagData)) {
                    $sql = "INSERT INTO tag(name) VALUES(:name)";
                    $stm = $this->db->prepare($sql);
                    $stm->bindParam(":name", $value);
                    $stm->execute();
                    $last_insert_id = $this->db->lastInsertId();

                    $sql = "INSERT INTO post_tag(post_id,tag_id) VALUES(:post_id,:tag_id)";
                    $stm = $this->db->prepare($sql);
                    $stm->bindParam(":post_id", $post_id);
                    $stm->bindParam(":tag_id", $last_insert_id);
                    $stm->execute();
                } else {
                    $sql = "SELECT id FROM tag WHERE name=:tag_name";
                    $stm = $this->db->prepare($sql);
                    $stm->bindParam(":tag_name", $value);
                    $stm->execute();
                    $row = $stm->fetch(\PDO::FETCH_ASSOC);

                    $sql = "INSERT INTO post_tag(post_id,tag_id) VALUES(:post_id,:tag_id)";
                    $stm = $this->db->prepare($sql);
                    $stm->bindParam(":post_id", $post_id);
                    $stm->bindParam(":tag_id", $row['id']);
                    $stm->execute();
                }
            }
        }
        return;
    }

    /**
     * @param $params
     * @return bool
     */
    public function updatePostData($params)
    {
        $this->deletePostCategory($params);
        $this->addPostsCategories($params, $params['id']);
        $this->deletePostTags($params);
        $this->addPostTags($params, $params['id']);
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

    /**
     * @param $params
     */
    public function deletePostCategory($params)
    {

        $sql = "DELETE FROM post_category WHERE post_id = :post_id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":post_id", $params['id']);
        $stm->execute();
    }

    /**
     * @param $params
     */
    public function deletePostTags($params)
    {
        $sql = "DELETE FROM post_tag WHERE post_id = :post_id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":post_id", $params['id']);
        $stm->execute();
    }

    /**
     * @param $id
     * @return bool
     */
    public function getPostById($id)
    {
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

    /**
     * @param $id
     * @return bool
     */
    public function getPostsCategoriesById($id)
    {
        $sql = "SELECT category_id FROM post_category WHERE post_id=:post_id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":post_id", $id);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetchAll(\PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function getPostsTagsById($id)
    {
        $sql = "SELECT tag.name,tag.id,post_tag.post_id FROM `post_tag` INNER JOIN tag on tag.id=post_tag.tag_id WHERE post_tag.post_id=:post_id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":post_id", $id);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetchAll(\PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * @param $params
     */
    public function getPostAjaxPagination($params)
    {

        $columns = array(
            // datatable column index  => database column name
            0 => 'name',
            1 => 'name',
            2 => 'category_name',
            3 => 'tag_name',
            4 => 'created_at',
        );

        $totalData = $this->getAllUsersCount();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        if (!empty($params['search']['value'])) {

            $sql = "SELECT posts.name,posts.created_at,GROUP_CONCAT(DISTINCT (tag.name) SEPARATOR ', ') as tag_name,posts.id,GROUP_CONCAT(DISTINCT (categories.name)  SEPARATOR ', ') as category_name ";
            $sql .= " FROM $this->dbTable";
            $sql .= " LEFT JOIN post_category on post_category.post_id = posts.id";
            $sql .= " LEFT JOIN categories on categories.id = post_category.category_id";
            $sql .= " LEFT JOIN post_tag ON post_tag.post_id = posts.id";
            $sql .= " LEFT JOIN tag on tag.id = post_tag.tag_id";
            $sql .= " WHERE $this->dbTable.name LIKE '%" . $params['search']['value'] . "%' ";    // $params['search']['value'] contains search parameter
            $sql .= " GROUP BY posts.id";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

            $totalFiltered = $stm->rowCount(); //mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query
            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

        } else {

            //"SELECT posts.name,GROUP_CONCAT(tag.name) as tag_name,posts.id,GROUP_CONCAT(categories.name) as cat_name FROM `wallreport`.`posts` LEFT JOIN post_category on post_category.post_id=posts.id LEFT JOIN categories on categories.id=post_category.category_id LEFT JOIN post_tag ON post_tag.post_id=posts.id LEFT JOIN tag on tag.id=post_tag.tag_id GROUP BY posts.id"
            $sql = "SELECT posts.name,posts.created_at,GROUP_CONCAT(DISTINCT (tag.name) SEPARATOR ', ') as tag_name,posts.id,GROUP_CONCAT(DISTINCT (categories.name)  SEPARATOR ', ') as category_name ";
            $sql .= " FROM $this->dbTable";
            $sql .= " LEFT JOIN post_category on post_category.post_id = posts.id";
            $sql .= " LEFT JOIN categories on categories.id = post_category.category_id";
            $sql .= " LEFT JOIN post_tag ON post_tag.post_id = posts.id";
            $sql .= " LEFT JOIN tag on tag.id = post_tag.tag_id";
            $sql .=" GROUP BY posts.id";
            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . " ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();
        }

        $data = array();
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $nestedData = array();

            $nestedData[] = "<input type='checkbox'  class='deleteRow' value='" . $row['id'] . "'  />";
            $nestedData[] = '<a href="' . \App\Config::W_ROOT . "admin/editpost/" . $row['id'] . '">' . $row["name"] . "</a>";
            $nestedData[] = $row["category_name"];
            $nestedData[] = $row["tag_name"];
            $nestedData[] = $row["created_at"];

            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($params['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );

        echo json_encode($json_data);  // send data as json format
    }

    /**
     * @return bool
     */
    public function getAllUsersCount()
    {
        $sql = "SELECT COUNT(id) AS count FROM $this->dbTable";
        $stm = $this->db->prepare($sql);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row['count'];
        } else {
            return false;
        }
    }

    /**
     * @param $ids
     */
    public function bulkDeletePosts($ids)
    {
        $data_ids = $ids['data_ids'];
        $sql = "DELETE FROM post_tag WHERE post_id IN ($data_ids)";
        $stm = $this->db->prepare($sql);
        $stm->execute();

        $sql = "DELETE FROM post_category WHERE post_id IN ($data_ids)";
        $stm = $this->db->prepare($sql);
        $stm->execute();

        $sql = "DELETE FROM $this->dbTable WHERE id IN ($data_ids)";
        $stm = $this->db->prepare($sql);
        $stm->execute();

    }

}
