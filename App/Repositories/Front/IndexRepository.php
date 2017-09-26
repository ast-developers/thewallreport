<?php

namespace App\Repositories\Front;

use App\Models\Post;

class IndexRepository
{

    public function __construct()
    {
        $this->post_model = new Post();
    }

    public function getFeaturedBanners()
    {
        return $this->post_model->getFeaturedBanners();
    }
}
