<?php

namespace App\Controllers\Front;

use App\Repositories\Front\PostRepository;
use Core\Controller;
use Core\View;


class PostController extends Controller
{

    public $params;
    public function __construct($params = [])
    {
        $this->params = $params;
        $this->repo = new PostRepository();
        $this->admin_post_repo = new \App\Repositories\Admin\PostRepository();
    }
    public function indexAction()
    {
        $post = $this->repo->checkSlugExistOrNot($this->params['slug']);
        if(!empty($post)){
            $this->repo->updateViewCount($post['id']);
            $tags = $this->admin_post_repo->getPostsTagsById($post['id']);
            $categories = $this->admin_post_repo->getPostsCategoriesById($post['id']);
            return View::render('Front/Post/detail.php', ['post' => $post,'tags'=>explode(',',$tags)]);
        }else{
            return View::render('Front/error.php');
        }
    }

}
