<?php

namespace App\Models;


use App\Config;
use Core\Helper;
use Core\Model;

/**
 * Class Page
 * @package App\Models
 */
class Page extends Model
{

    /**
     * @var mixed
     */
    public $db;

    /**
     * @var
     */
    protected $tag_repo;

    /**
     *
     */
    public function __construct()
    {
        $this->db = static::getDB();
        $this->dbTable = 'pages';
    }

    /**
     * @param $params
     * @return bool
     */
    public function insertPageData($params, $filename)
    {
        if (isset($params['status']) && $params['status'] == 'publish') {
            $publish_at = date('Y-m-d H:i:s');
        } else {
            $publish_at = NULL;
        }
        $slug = Helper::slugify($params['name']);
        $updated_at = date('Y-m-d H:i:s');
        $sql = "INSERT INTO $this->dbTable(name,description,status,slug,created_by,updated_at,published_at,featured_image,views) VALUES(:name,:description,:status,:slug,:created_by,:updated_at,:published_at,:featured_image,:views)";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":description", $params['description']);
        $stm->bindParam(":status", $params['status']);
        $stm->bindParam(":slug", $slug);
        $stm->bindParam(":created_by", $_SESSION['user']['id']);
        $stm->bindParam(":updated_at", $updated_at);
        $stm->bindParam(":published_at", $publish_at);
        $stm->bindParam(":featured_image", $filename);
        $stm->bindParam(":views", $params['views']);
        try {
            $stm->execute();
            $last_insert_id = $this->db->lastInsertId();
            return $last_insert_id;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * @param $params
     * @return bool
     */
    public function updatePageData($params, $featured_image)
    {
        if (isset($params['status']) && $params['status'] == 'publish') {
            $publish_at = date('Y-m-d H:i:s');
        } else {
            $publish_at = NULL;
        }
        $slug = Helper::slugify($params['name']);
        $updated_at = date('Y-m-d H:i:s');
        $sql = "UPDATE  $this->dbTable SET name = :name,description=:description,status=:status,slug=:slug,created_by=:created_by,updated_at=:updated_at,published_at=:published_at,featured_image=:featured_image,views=:views WHERE id = :id;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":description", $params['description']);
        $stm->bindParam(":status", $params['status']);
        $stm->bindParam(":id", $params['id']);
        $stm->bindParam(":slug", $slug);
        $stm->bindParam(":created_by", $_SESSION['user']['id']);
        $stm->bindParam(":updated_at", $updated_at);
        $stm->bindParam(":published_at", $publish_at);
        $stm->bindParam(":featured_image", $featured_image);
        $stm->bindParam(":views", $params['views']);
        try {
            return $stm->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * @param $params
     */
    public function getPageAjaxPagination($params)
    {

        $columns = array(
            0 => 'name',
            1 => 'name',
            2 => 'slug',
            3 => 'created_at',
        );

        $totalData = $this->getAllPagesCount();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        if (!empty($params['search']['value'])) {

            $sql = "SELECT $this->dbTable.name,$this->dbTable.created_at,$this->dbTable.id,$this->dbTable.slug";
            $sql .= " FROM $this->dbTable";
            $sql .= " WHERE $this->dbTable.name LIKE '%" . $params['search']['value'] . "%' ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

            $totalFiltered = $stm->rowCount();
            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . "   LIMIT " . $params['start'] . " ," . $params['length'] . "   ";
            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

        } else {

            $sql = "SELECT $this->dbTable.name,$this->dbTable.created_at,$this->dbTable.id,$this->dbTable.slug";
            $sql .= " FROM $this->dbTable";
            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . "   LIMIT " . $params['start'] . " ," . $params['length'] . "   ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();
        }

        $data = array();
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $nestedData = array();

            $nestedData[] = "<input type='checkbox'  class='deleteRow' value='" . $row['id'] . "'  />";
            $nestedData[] = '<a href="' . \App\Config::W_ROOT . "admin/edit-page/" . $row['id'] . '">' . $row["name"] . "</a>";
            $nestedData[] = $row["slug"];
            $nestedData[] = date("Y/m/d", strtotime($row["created_at"]));

            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    /**
     * @return bool
     */
    public function getAllPagesCount()
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
    public function bulkDeletePages($ids)
    {
        $this->removeImages($ids);
        $data_ids = $ids['data_ids'];
        $sql = "DELETE FROM $this->dbTable WHERE id IN ($data_ids)";
        $stm = $this->db->prepare($sql);
        $stm->execute();
    }

    /**
     * @param $ids
     */
    public function removeImages($ids)
    {
        $page_ids = explode(',', $ids['data_ids']);
        foreach ($page_ids as $id) {
            $page = $this->getPageById($id);
            if (!empty($page[0]['featured_image']) && file_exists(Config::F_FEATURED_IMAGE_ROOT . $page[0]['featured_image'])) {
                unlink(Config::F_FEATURED_IMAGE_ROOT . $page[0]['featured_image']);
            }
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function getPageById($id)
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
     * @return bool
     */
    public function getAll()
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
     * @param $slug
     * @return bool
     */
    public function checkSlugExistOrNot($slug)
    {
        $sql = "SELECT $this->dbTable.id,$this->dbTable.slug,$this->dbTable.views,$this->dbTable.description,$this->dbTable.name,$this->dbTable.created_by,$this->dbTable.published_at,CONCAT(users.first_name, ' ',users.last_name) as creator,users.profile_image FROM $this->dbTable";
        $sql .= " LEFT JOIN users on users.id=$this->dbTable.created_by";
        $sql .= " where slug=:slug";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":slug", $slug);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * @param $term
     * @return bool
     */
    public function searchForPageData($term)
    {
        $sql = "SELECT pages.description,pages.name,pages.published_at,pages.slug,pages.featured_image,pages.id,CONCAT(users.first_name, ' ',users.last_name) as creator  FROM `pages`";
        $sql .= " LEFT JOIN users on users.id=$this->dbTable.created_by";
        $sql .= " WHERE `name` LIKE '%$term%'";
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
