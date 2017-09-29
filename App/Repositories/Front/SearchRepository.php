<?php

namespace App\Repositories\Front;

use App\Models\Page;
use App\Models\Post;

class SearchRepository
{

    public function __construct()
    {
        $this->post_model = new Post();
        $this->page_model = new Page();
    }

    public function searchForPostData($term)
    {
        return $this->post_model->searchForPostData($term);
    }

    public function searchForPageData($term){
        return $this->page_model->searchForPageData($term);
    }

    public function getPostTagsByID($id){
        return $this->post_model->getPostsTagsById($id);
    }

    public function getCategoriesById($id){
        return $this->post_model->getCategoriesByPostId($id);
    }
}
