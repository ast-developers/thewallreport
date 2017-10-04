<?php

namespace App\Models;


use Core\Helper;
use Core\Model;


/**
 * Class Advertise
 * @package App\Models
 */
class Advertise extends Model
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
        $this->dbTable = 'advertise';
    }


    /**
     * @param $params
     * @param $filename
     * @return bool
     */
    public function insertAdvertiseData($params, $filename)
    {
        $banner = NULL;
        $adsenseCode = NULL;
        if (!empty($filename) && $params['type'] == 'banner') {
            $banner = $filename;
        } elseif (!empty($params['adsense_code']) && $params['type'] == 'adsense') {
            $adsenseCode = $params['adsense_code'];
        }
        $updated_at = date('Y-m-d H:i:s');
        $sql = "INSERT INTO $this->dbTable(name,type,banner_image,adsense_code,updated_at,status) VALUES(:name,:type,:banner_image,:adsense_code,:updated_at,:status)";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":type", $params['type']);
        $stm->bindParam(":banner_image", $banner);
        $stm->bindParam(":adsense_code", $adsenseCode);
        $stm->bindParam(":updated_at", $updated_at);
        $stm->bindParam(":status", $params['status']);
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
     * @param $filename
     * @return bool
     */
    public function updateAdvertiseData($params, $filename)
    {
        $banner = NULL;
        $adsenseCode = NULL;
        if (!empty($filename) && $params['type'] == 'banner') {
            $banner = $filename;
        } elseif (!empty($params['adsense_code']) && $params['type'] == 'adsense') {
            $adsenseCode = $params['adsense_code'];
        }
        $updated_at = date('Y-m-d H:i:s');
        $sql = "UPDATE  $this->dbTable SET name=:name,type=:type,banner_image=:banner_image,adsense_code=:adsense_code,updated_at=:updated_at,status=:status WHERE id = :id;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":type", $params['type']);
        $stm->bindParam(":banner_image", $banner);
        $stm->bindParam(":adsense_code", $adsenseCode);
        $stm->bindParam(":updated_at", $updated_at);
        $stm->bindParam(":status", $params['status']);
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
    public function getAdvertiseById($id)
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
    public function getAdvertiseAjaxPagination($params)
    {

        $columns = array(
            0 => 'name',
            1 => 'name',
            2 => 'type',
            4 => 'created_at',
            3 => 'status',
        );

        $totalData = $this->getAllAdvertiseCount();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        if (!empty($params['search']['value'])) {

            $sql = "SELECT $this->dbTable.name,$this->dbTable.type,$this->dbTable.id,$this->dbTable.created_at,$this->dbTable.status";
            $sql .= " FROM $this->dbTable";
            $sql .= " WHERE $this->dbTable.name LIKE '%" . $params['search']['value'] . "%' ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

            $totalFiltered = $stm->rowCount();
            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . "   LIMIT " . $params['start'] . " ," . $params['length'] . "   ";
            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

        } else {

            $sql = "SELECT $this->dbTable.name,$this->dbTable.type,$this->dbTable.id,$this->dbTable.created_at,$this->dbTable.status";
            $sql .= " FROM $this->dbTable";
            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . "   LIMIT " . $params['start'] . " ," . $params['length'] . "   ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();
        }

        $data = array();
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {

            $nestedData = array();

            $nestedData[] = "<input type='checkbox'  class='deleteRow' value='" . $row['id'] . "'  />";
            $nestedData[] = '<a href="' . \App\Config::W_ROOT . "admin/edit-advertise/" . $row['id'] . '">' . $row["name"] . "</a>";
            $nestedData[] = $row['type'];
            $nestedData[] = date("Y/m/d", strtotime($row["created_at"]));
            $nestedData[] = Helper::getStatus($row['status']);

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
    public function getAllAdvertiseCount()
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
    public function bulkDeleteAdvertise($ids)
    {
        $data_ids = $ids['data_ids'];
        $sql = "DELETE FROM $this->dbTable WHERE id IN ($data_ids)";
        $stm = $this->db->prepare($sql);
        $stm->execute();
    }


    /**
     * @return bool
     */
    public function getAll()
    {
        $status = 'active';
        $sql = "SELECT * FROM $this->dbTable WHERE status=:status ORDER BY sort_order";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":status", $status);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetchAll(\PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }


}
