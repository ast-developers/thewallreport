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

}
