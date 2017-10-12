<?php

namespace App\Repositories\Front;

use App\Models\FFPost;
use App\Models\Page;
use App\Models\Post;


/**
 * Class CMSRepository
 * @package App\Repositories\Front
 */
class CMSRepository
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
        $this->page_model = new Page();
        $this->feed_model = new FFPost();
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

    public function updateFeedViewCount($feed_id)
    {
        return $this->feed_model->updateFeedViewCount($feed_id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getCategoriesByPostId($id)
    {
        return $this->model->getCategoriesByPostId($id);
    }

    /**
     * @param $id
     * @return string
     */
    public function getPostsTagsById($id)
    {
        $data = $this->model->getPostsTagsById($id);
        $tags = [];
        if (!empty($data)) {
            foreach ($data as $value) {
                $tags[] = $value['name'];
            }
        }
        return implode(',', $tags);
    }

    /**
     * @param $slug
     * @return bool
     */
    public function checkPageSlugExistOrNot($slug)
    {
        return $this->page_model->checkSlugExistOrNot($slug);
    }

    public function checkFeedExistOrNot($slug)
    {
        return $this->feed_model->checkSlugExistOrNot($slug);
    }

}
