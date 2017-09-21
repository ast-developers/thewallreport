<?php

namespace App\Models;


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
    public function insertPageData($params)
    {
        $slug = Helper::slugify($params['name']);
        $updated_at = date('Y-m-d H:i:s');
        $sql = "INSERT INTO $this->dbTable(name,description,status,slug,created_by,updated_at) VALUES(:name,:description,:status,:slug,:created_by,:updated_at)";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":description", $params['description']);
        $stm->bindParam(":status", $params['status']);
        $stm->bindParam(":slug", $slug);
        $stm->bindParam(":created_by", $_SESSION['user']['id']);
        $stm->bindParam(":updated_at", $updated_at);
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
    public function updatePageData($params)
    {
        $slug = Helper::slugify($params['name']);
        $updated_at = date('Y-m-d H:i:s');
        $sql = "UPDATE  $this->dbTable SET name = :name,description=:description,status=:status,slug=:slug,created_by=:created_by,updated_at=:updated_at WHERE id = :id;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":description", $params['description']);
        $stm->bindParam(":status", $params['status']);
        $stm->bindParam(":id", $params['id']);
        $stm->bindParam(":slug", $slug);
        $stm->bindParam(":created_by", $_SESSION['user']['id']);
        $stm->bindParam(":updated_at", $updated_at);
        try {
            return $stm->execute();
        } catch (PDOException $e) {
            return false;
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
            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

        } else {

            $sql = "SELECT $this->dbTable.name,$this->dbTable.created_at,$this->dbTable.id,$this->dbTable.slug";
            $sql .= " FROM $this->dbTable";
            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . " ";

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
        $data_ids = $ids['data_ids'];
        $sql = "DELETE FROM $this->dbTable WHERE id IN ($data_ids)";
        $stm = $this->db->prepare($sql);
        $stm->execute();
    }

}
