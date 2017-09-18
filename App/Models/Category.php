<?php

namespace App\Models;

use Core\Model;


/**
 * Class Role
 * @package App\Models
 */
class Category extends Model
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
        $this->dbTable = 'categories';
    }

    /**
     * @param $params
     */
    public function getCategoryAjaxPagination($params)
    {
        $columns = array(
            // datatable column index  => database column name
            0 => 'name',
            1 => 'name',
            2 => 'description',
            3 => 'slug'
        );

        $totalData = $this->getAllCategoriesCount();
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        if (!empty($params['search']['value'])) {
            // if there is a search parameter
            $sql = "SELECT id, parent_id,name,description,slug ";
            $sql .= " FROM $this->dbTable";
            $sql .= " WHERE name LIKE '%" . $params['search']['value'] . "%' ";    // $params['search']['value'] contains search parameter
            $sql .= " OR description LIKE '%" . $params['search']['value'] . "%' ";
            $sql .= " OR slug LIKE '%" . $params['search']['value'] . "%' ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();

            $totalFiltered = $stm->rowCount(); //mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query

            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . " "; // $params['order'][0]['column'] contains colmun index, $params['order'][0]['dir'] contains order such as asc/desc , $params['start'] contains start row number ,$params['length'] contains limit length.

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();
            $rows = $stm->fetchAll(\PDO::FETCH_ASSOC);
            $tree = $this->buildTree($rows);

        } else {

            $sql = "SELECT id, parent_id,name,description,slug ";
            $sql .= " FROM $this->dbTable";
            $sql .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . " ";

            $stm = $this->db->prepare($sql);
            $res = $stm->execute();
            $rows = $stm->fetchAll(\PDO::FETCH_ASSOC);
            $tree = $this->buildTree($rows);
        }

        $data = array();
        foreach ($tree as $row) {
            $nestedData = array();
            $nestedData[] = "<input type='checkbox'  class='deleteRow' value='" . $row['id'] . "'  />";
            $nestedData[] = '<a href="' . \App\Config::W_ROOT . "admin/editCategory/" . $row['id'] . '">' . $row["name"] . '</a>';
            $nestedData[] = $row["description"];
            $nestedData[] = $row["slug"];

            $data[] = $nestedData;
            $result = [];
            if (!empty($row['children'])) {
                $result = array_merge($data, $this->generateChild($row['children']));
            }
            if (count($result) > 0) {
                $data = $result;
            }
        }
        $json_data = array(
            "draw" => intval($params['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData),  // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );
        echo json_encode($json_data);
    }

    /**
     * @return bool
     */
    public function getAllCategoriesCount()
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
     * @param array $elements
     * @param int $parentId
     * @return array
     */
    function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    /**
     * @param $children
     * @param int $level
     * @param string $sign
     * @return array
     */
    public function generateChild($children, $level = 1, $sign = '- ')
    {
        $data = [];
        foreach ($children as $key => $value) {
            $nestedData = [];
            $nestedData[] = "<input type='checkbox'  class='deleteRow' value='" . $value['id'] . "'  />";;
            $s = '';
            for ($i = 1; $i <= $level; $i++) {
                $s .= $sign;
            }
            $nestedData[] = '<a href="' . \App\Config::W_ROOT . "admin/editCategory/" . $value['id'] . '">' . $s . $value["name"] . '</a>';
            $nestedData[] = $value["description"];
            $nestedData[] = $value["slug"];
            $nestedData[] = $value["id"];
            $nestedData[] = $level;
            $data[] = $nestedData;
            $result = [];
            if (!empty($value['children'])) {
                $level = $level + 1;
                $result = array_merge($data, $this->generateChild($value['children'], $level, $sign));
                $level = $level - 1;
            }

            if ($result) {
                $data = $result;
            }

        }
        return $data;
    }

    /**
     * @param $params
     */
    public function bulkDeleteCategories($params)
    {

        $data_ids = $params['data_ids'];
        $sql = "DELETE FROM $this->dbTable WHERE id IN ($data_ids)";
        $stm = $this->db->prepare($sql);
        $stm->execute();

        $sql = "DELETE FROM $this->dbTable WHERE parent_id IN ($data_ids)";
        $stm = $this->db->prepare($sql);
        $stm->execute();

    }

    /**
     * @return array
     */
    public function getParentCategories()
    {
        $rows = $this->getAll();
        return $this->buildTree($rows);
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
     * @param $params
     * @return bool
     */
    public function insertCategoryData($params)
    {
        $slug = $this->slugify($params['slug']);
        $sql = "INSERT INTO $this->dbTable(name, slug, description,parent_id) VALUES(:name,:slug,:description,:parent_id)";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":slug", $slug);
        $stm->bindParam(":description", $params['description']);
        $stm->bindParam(":parent_id", $params['parent_id']);
        try {
            return $stm->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * @param $string
     * @return mixed
     */

    function slugify($text){
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicated - symbols
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * @param $params
     * @return bool
     */
    public function updateCategoryData($params)
    {

        $slug = $this->slugify($params['slug']);
        $sql = "UPDATE  $this->dbTable SET name = :name,slug=:slug,description=:description,parent_id=:parent_id WHERE id = :id;";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":name", $params['name']);
        $stm->bindParam(":slug", $slug);
        $stm->bindParam(":description", $params['description']);
        $stm->bindParam(":parent_id", $params['parent_id']);
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
    public function getCategoryById($id)
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

    public function isSlugExist($slug){
        $slug = $this->slugify($slug);
        $sql = "SELECT COUNT(id) AS count FROM $this->dbTable WHERE slug = :slug";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":slug", $slug);
        $res = $stm->execute();

        if ($res) {
            $row = $stm->fetch(\PDO::FETCH_ASSOC);
            return $row['count'] > 0 ? false : true;
        } else {
            return true;
        }
    }

}
