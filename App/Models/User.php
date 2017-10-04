<?php

namespace App\Models;

use Core\Helper;
use Core\Model;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
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
        $this->dbTable = 'users';
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function getUserForLogin($username, $password)
    {
        $sql = "SELECT *, COUNT(id) AS count FROM $this->dbTable WHERE ( username = :username OR email = :username) and password = :password GROUP BY id";
        $stm = $this->db->prepare($sql);

        $stm->bindParam(":username", $username);
        $stm->bindParam(":password", $password);

        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row['count'] > 0 ? $row : false;
        } else {
            return false;
        }
    }

    /**
     * @param $email
     * @return bool
     */
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM $this->dbTable WHERE email = :email";
        $stm = $this->db->prepare($sql);

        $stm->bindParam(":email", $email);

        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return count($row) ? $row : false;
        } else {
            return false;
        }
    }

    /**
     * @param $password
     * @param $email
     */
    public function changePassword($password, $email)
    {
        $sql = "UPDATE  $this->dbTable SET password = :password WHERE email = :email;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":password", $password);
        $stm->bindParam(":email", $email);
        $stm->execute();
    }


    /**
     * @return bool
     */
    public function getUsers()
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
     * @param $username
     * @return bool
     */
    public function isUserNameExist($username)
    {
        $sql = "SELECT *,COUNT(id) AS count FROM $this->dbTable WHERE username = :username";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":username", $username);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row['count'] > 0 ? false : true;
        } else {
            return true;
        }
    }

    /**
     * @param $user
     * @param $filename
     * @return bool
     */
    public function insertUserData($user, $filename)
    {
        $password = md5($user['password']);
        $updated_at = date('Y-m-d H:i:s');
        $sql = "INSERT INTO $this->dbTable(username, first_name, last_name,nick_name,email,password,role_id,profile_image,updated_at) VALUES(:username,:first_name,:last_name,:nick_name,:email,:password,:role_id,:profile_image,:updated_at)";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":username", $user['username']);
        $stm->bindParam(":email", $user['email']);
        $stm->bindParam(":first_name", $user['first_name']);
        $stm->bindParam(":last_name", $user['last_name']);
        $stm->bindParam(":nick_name", $user['nick_name']);
        $stm->bindParam(":password", $password);
        $stm->bindParam(":role_id", $user['role_id']);
        $stm->bindParam(":profile_image", $filename);
        $stm->bindParam(":updated_at",$updated_at);
        try {
            return $stm->execute();
        } catch (PDOException $e) {
            return false;
        }

    }

    /**
     * @param $user
     * @param $filename
     * @return bool
     */
    public function updateUserData($user, $filename)
    {
        $updated_at = date('Y-m-d H:i:s');
        $sql = "UPDATE  $this->dbTable SET username = :username,email=:email,first_name=:first_name,last_name=:last_name,nick_name=:nick_name,role_id=:role_id,profile_image=:profile_image,updated_at=:updated_at WHERE id = :id;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":id", $user['id']);
        $stm->bindParam(":username", $user['username']);
        $stm->bindParam(":email", $user['email']);
        $stm->bindParam(":first_name", $user['first_name']);
        $stm->bindParam(":last_name", $user['last_name']);
        $stm->bindParam(":nick_name", $user['nick_name']);
        $stm->bindParam(":role_id", $user['role_id']);
        $stm->bindParam(":profile_image", $filename);
        $stm->bindParam(":updated_at",$updated_at);
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
    public function getUserById($id)
    {
        $sql = "SELECT * FROM $this->dbTable WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":id", $id);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    /**
     * @param $params
     */
    public function getUserAjaxPagination($params)
    {

        $columns = array(
            // datatable column index  => database column name
            0 => 'username',
            1 => 'username',
            2 => 'name',
            3 => 'email',
            4 => 'role_name'
        );

        $totalData = $this->getAllUsersCount();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        if (!empty($params['search']['value'])) {
            // if there is a search parameter
            $sql = "SELECT $this->dbTable.id, username, CONCAT(first_name,' ',last_name) as name, email, profile_image, roles.name as role_name ";
            $sql .= " FROM $this->dbTable";
            $sql .= " LEFT JOIN roles ON roles.id = $this->dbTable.role_id";
            $sql .= " WHERE username LIKE '%" . $params['search']['value'] . "%' ";    // $params['search']['value'] contains search parameter
            $sql .= " OR first_name LIKE '%" . $params['search']['value'] . "%' ";
            $sql .= " OR last_name LIKE '%" . $params['search']['value'] . "%' ";
            $sql .= " OR email LIKE '%" . $params['search']['value'] . "%' ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

            $totalFiltered = $stm->rowCount(); //mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query

            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . "   LIMIT " . $params['start'] . " ," . $params['length'] . "   "; // $params['order'][0]['column'] contains colmun index, $params['order'][0]['dir'] contains order such as asc/desc , $params['start'] contains start row number ,$params['length'] contains limit length.
            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

        } else {

            $sql = "SELECT $this->dbTable.id, username, CONCAT(first_name,' ',last_name) as name, email, profile_image, roles.name as role_name ";
            $sql .= " FROM $this->dbTable";
            $sql .= " LEFT JOIN roles ON roles.id = $this->dbTable.role_id";
            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . "   LIMIT " . $params['start'] . " ," . $params['length'] . "   ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();
        }

        $data = array();
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $nestedData = array();

            $avatar = Helper::getUserAvatar($row, 'small');
            $nestedData[] = (!empty($_SESSION['user']) && $_SESSION['user']['id'] !== $row["id"]) ? "<input type='checkbox'  class='deleteRow' value='" . $row['id'] . "'  />" : "";
            $nestedData[] = '<img src="'.$avatar.'" height="32" width="32"/> <a href="' . \App\Config::W_ROOT . "admin/edit-user/" . $row['id'] . '">' . $row["username"] . "</a>";
            $nestedData[] = $row["name"];
            $nestedData[] = $row["email"];
            $nestedData[] = $row["role_name"];

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
    public function bulkDeleteUsers($ids)
    {
        $data_ids = $ids['data_ids'];
        $sql = "DELETE FROM $this->dbTable WHERE id IN ($data_ids)";
        $stm = $this->db->prepare($sql);
        $stm->execute();
    }
}
