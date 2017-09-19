<?php

namespace App\Repositories\Admin;

use App\Models\Category;


/**
 * Class UserRepository
 * @package App\Repositories\Admin
 */
class CategoryRepository
{
    /**
     * @var Category
     */
    protected $model;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new Category();
    }

    /**
     * @return bool
     */
    public function getAll()
    {
        return $this->model->getAll();
    }

    /**
     * @param $params
     */
    public function getCategoryAjaxPagination($params)
    {
        return $this->model->getCategoryAjaxPagination($params);
    }

    /**
     * @param $params
     */
    public function bulkDeleteCategories($params)
    {
        return $this->model->bulkDeleteCategories($params);
    }

    /**
     * @return array
     */
    public function getParentCategories()
    {
        $tree = $this->model->getParentCategories();
        foreach ($tree as $row) {
            $nestedData = array();
            $nestedData[] = "<input type='checkbox'  class='deleteRow' value='" . $row['id'] . "'  />";
            $nestedData[] = $row["name"];
            $nestedData[] = $row["description"];
            $nestedData[] = $row["slug"];
            $nestedData[] = $row["id"];

            $data[] = $nestedData;
            $result = [];
            if (!empty($row['children'])) {
                $result = array_merge($data, $this->model->generateChild($row['children'], $level = 1, str_repeat('&nbsp;', 2)));
            }
            if (count($result) > 0) {
                $data = $result;
            }
        }
        if(!empty($data)){
            return $data;
        }else{
            return [];
        }


    }

    /**
     * @param $params
     * @return bool
     */
    public function insertCategoryData($params)
    {
        return $this->model->insertCategoryData($params);
    }

    /**
     * @param $params
     * @return bool
     */
    public function updateCategoryData($params)
    {
        return $this->model->updateCategoryData($params);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getCategoryById($id)
    {
        return $this->model->getCategoryById($id);
    }

}
