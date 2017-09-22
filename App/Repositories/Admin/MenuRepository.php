<?php

namespace App\Repositories\Admin;

use App\Models\Menu;


/**
 * Class MenuRepository
 * @package App\Repositories\Admin
 */
class MenuRepository
{

    /**
     * @var Menu
     */
    public $model;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new Menu();
        $this->page_repo = new PageRepository();
        $this->post_repo = new PostRepository();
    }

    /**
     * @param $params
     * @return bool
     */
    public function insertMenuData($params)
    {
        return $this->model->insertMenuData($params);
    }

    /**
     * @param $params
     * @return bool
     */
    public function updateMenuData($params)
    {
        return $this->model->updateMenuData($params);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getMenuById($id)
    {
        return $this->model->getMenuById($id);
    }

    /**
     * @param $params
     */
    public function getMenuAjaxPagination($params)
    {
        return $this->model->getMenuAjaxPagination($params);
    }

    /**
     * @param $params
     */
    public function bulkDeleteMenus($params)
    {
        return $this->model->bulkDeleteMenus($params);
    }

    /**
     * @return bool
     */
    public function getAll()
    {
        return $this->model->getAll();
    }

    /**
     * @param $sort_order
     */
    public function updateMenuSortOrder($sort_order)
    {
        return $this->model->updateMenuSortOrder($sort_order);
    }

    public function getMenus()
    {
        $allMenu =$this->getAll();
        $menuData = [];
        foreach ($allMenu as $value) {

            $menuData[$value['id']]['name'] = $value['name'];
            if ($value['type'] == 1) {
                $data = $this->post_repo->getPostById($value['link']);
                $menuData[$value['id']]['slug'] = $data['0']['slug'];
            } elseif ($value['type'] == 2) {
                $data = $this->page_repo->getPageById($value['link']);
                $menuData[$value['id']]['slug'] = $data['0']['slug'];
            } elseif ($value['type'] == 3) {
                $menuData[$value['id']]['slug'] = $value['link'];
            }
        }
        return $menuData;

    }

}
