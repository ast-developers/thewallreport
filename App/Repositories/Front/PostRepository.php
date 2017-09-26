<?php

namespace App\Repositories\Front;

use App\Models\Post;

class PostRepository
{

    public $model;

    public function __construct()
    {
        $this->model = new Post();
    }

    public function checkSlugExistOrNot($slug){

        return $this->model->checkSlugExistOrNot($slug);
    }

    public function updateViewCount($post_id){
        return $this->model->updateViewCount($post_id);
    }

}
