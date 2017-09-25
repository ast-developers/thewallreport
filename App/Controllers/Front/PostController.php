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
    }
    public function indexAction()
    {
        $post = $this->repo->checkSlugExistOrNot($this->params['slug']);
        if(!empty($post)){
            return View::render('Front/Post/detail.php', ['post' => $post]);
        }
    }

}
