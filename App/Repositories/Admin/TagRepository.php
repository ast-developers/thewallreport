<?php

namespace App\Repositories\Admin;


use App\Models\Tag;


/**
 * Class TagRepository
 * @package App\Repositories\Admin
 */
class TagRepository
{

    /**
     * @var Tag
     */
    protected $model;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new Tag();
    }


    /**
     * @param $params
     */
    public function getTagsByKeyword($params)
    {
        $this->model->getTagsByKeyword($params);
    }

    /**
     * @return bool
     */
    public function getTags()
    {
        return $this->model->getTags();
    }

}
