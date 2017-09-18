<?php

namespace App\Repositories\Admin;
use App\Models\Category;


/**
 * Class UserRepository
 * @package App\Repositories\Admin
 */
class CategoryRepository
{
   protected $model;

    public function __construct()
    {
        $this->model = new Category();
    }

    public function getAll(){
        return $this->model->getAll();
    }

    public function getCategoryAjaxPagination($params){
        return $this->model->getCategoryAjaxPagination($params);
    }

    public function bulkDeleteCategories($params){
        return $this->model->bulkDeleteCategories($params);
    }

    public function getParentCategories(){
        $tree = $this->model->getParentCategories();
        foreach($tree as $row){
            $nestedData = array();
            $nestedData[] = "<input type='checkbox'  class='deleteRow' value='" . $row['id'] . "'  />";
            $nestedData[] = $row["name"];
            $nestedData[] = $row["description"];
            $nestedData[] = $row["slug"];
            $nestedData[] = $row["id"];

            $data[] = $nestedData;
            $result=[];
            if(!empty($row['children'])){
                $result = array_merge($data,$this->model->generateChild($row['children'],$level=1,str_repeat('&nbsp;', 2)));
            }
            if(count($result)>0){
                $data=$result;
            }
        }
        return $data;

    }

    public function insertCategoryData($params){
        return $this->model->insertCategoryData($params);
    }
    public function updateCategoryData($params){
        return $this->model->updateCategoryData($params);
    }

    public function getCategoryById($id){
        return $this->model->getCategoryById($id);
    }

}
