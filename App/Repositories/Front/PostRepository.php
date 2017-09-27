<?php

namespace App\Repositories\Front;

use App\Models\Post;

/**
 * Class PostRepository
 * @package App\Repositories\Front
 */
class PostRepository
{

    /**
     * @var Post
     */
    public $model;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new Post();
    }

    /**
     * @param $slug
     * @return bool
     */
    public function checkSlugExistOrNot($slug)
    {

        return $this->model->checkSlugExistOrNot($slug);
    }

    /**
     * @param $post_id
     */
    public function updateViewCount($post_id)
    {
        return $this->model->updateViewCount($post_id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getCategoriesByID($id)
    {
        return $this->model->getCategoriesByID($id);
    }

}
