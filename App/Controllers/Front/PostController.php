<?php

namespace App\Controllers\Front;

use App\Repositories\Front\PostRepository;
use Core\Controller;
use Core\View;


/**
 * Class PostController
 * @package App\Controllers\Front
 */
class PostController extends Controller
{

    /**
     * @var array
     */
    public $params;

    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->params = $params;
        $this->repo = new PostRepository();
        $this->admin_post_repo = new \App\Repositories\Admin\PostRepository();
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        $post = $this->repo->checkSlugExistOrNot($this->params['slug']);
        if (!empty($post)) {
            $this->repo->updateViewCount($post['id']);
            $tags = $this->admin_post_repo->getPostsTagsById($post['id']);
            $categories = $this->repo->getCategoriesById($post['id']);
            if (!empty($categories)) {
                foreach ($categories as $value) {
                    $category[] = $value['name'];
                }
            }
            return View::render('Front/Post/detail.php', ['post' => $post, 'tags' => explode(',', $tags), 'categories' => $category]);
        } else {
            return View::render('Front/error.php');
        }
    }

}
