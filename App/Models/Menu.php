<?php

namespace App\Models;


use Core\Helper;
use Core\Model;


/**
 * Class Menu
 * @package App\Models
 */
class Menu extends Model
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
        $this->dbTable = 'menu';
    }

    /**
     * @param $params
     * @return bool
     */
    public function insertMenuData($params)
    {
        if (!empty($params['page']) && $params['type'] == 2) {
            $link = $params['page'];
        } elseif (!empty($params['post']) && $params['type'] == 1) {
            $link = $params['post'];
        } else {
            $link = $params['external_url'];
        }
        $updated_at = date('Y-m-d H:i:s');
        $sql = "INSERT INTO $this->dbTable(name,type,link,updated_at) VALUES(:name,:type,:link,:updated_at)";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":type", $params['type']);
        $stm->bindParam(":link", $link);
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
    public function updateMenuData($params)
    {
        if (!empty($params['page']) && $params['type'] == 2) {
            $link = $params['page'];
        } elseif (!empty($params['post']) && $params['type'] == 1) {
            $link = $params['post'];
        } else {
            $link = $params['external_url'];
        }
        $updated_at = date('Y-m-d H:i:s');
        $sql = "UPDATE  $this->dbTable SET name=:name,type=:type,link=:link,updated_at=:updated_at WHERE id = :id;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":type", $params['type']);
        $stm->bindParam(":link", $link);
        $stm->bindParam(":updated_at", $updated_at);
        $stm->bindParam(":id", $params['id']);
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
    public function getMenuById($id)
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
    public function getMenuAjaxPagination($params)
    {

        $columns = array(
            0 => 'name',
            1 => 'name',
            2 => 'name',
            3 => 'created_at',
        );

        $totalData = $this->getAllMenusCount();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        if (!empty($params['search']['value'])) {

            $sql = "SELECT $this->dbTable.name,$this->dbTable.type,$this->dbTable.id,$this->dbTable.created_at";
            $sql .= " FROM $this->dbTable";
            $sql .= " WHERE $this->dbTable.name LIKE '%" . $params['search']['value'] . "%' ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

            $totalFiltered = $stm->rowCount();
            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

        } else {

            $sql = "SELECT $this->dbTable.name,$this->dbTable.type,$this->dbTable.id,$this->dbTable.created_at";
            $sql .= " FROM $this->dbTable";
            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . " ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();
        }

        $data = array();
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {

            if ($row["type"] == 2) {
                $type = 'Page';
            } elseif ($row["type"] == 1) {
                $type = 'Post';
            } else {
                $type = 'External Link';
            }
            $nestedData = array();

            $nestedData[] = "<input type='checkbox'  class='deleteRow' value='" . $row['id'] . "'  />";
            $nestedData[] = '<a href="' . \App\Config::W_ROOT . "admin/edit-menu/" . $row['id'] . '">' . $row["name"] . "</a>";
            $nestedData[] = $type;
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
    public function getAllMenusCount()
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
    public function bulkDeleteMenus($ids)
    {
        $data_ids = $ids['data_ids'];
        $sql = "DELETE FROM $this->dbTable WHERE id IN ($data_ids)";
        $stm = $this->db->prepare($sql);
        $stm->execute();
    }


}
