<?php

namespace App\Repositories\Admin;

use App\Models\Page;


/**
 * Class PageRepository
 * @package App\Repositories\Admin
 */
class PageRepository
{
    /**
     * @var Page
     */
    public $model;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new Page();
    }


    /**
     * @param $params
     * @return bool
     */
    public function insertPageData($params)
    {
        return $this->model->insertPageData($params);
    }

    /**
     * @param $params
     * @return bool
     */
    public function updatePageData($params)
    {
        return $this->model->updatePageData($params);
    }


    /**
     * @param $id
     * @return bool
     */
    public function getPageById($id)
    {
        return $this->model->getPageById($id);
    }


    /**
     * @param $params
     */
    public function getPageAjaxPagination($params)
    {
        return $this->model->getPageAjaxPagination($params);
    }

    /**
     * @param $params
     */
    public function bulkDeletePage($params)
    {
        return $this->model->bulkDeletePages($params);
    }

}
