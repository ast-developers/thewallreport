<?php

namespace App\Controllers\Front;

use App\Repositories\Front\PostRepository;
use Core\Controller;
use Core\View;


class CMSController extends Controller
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
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        $post = $this->repo->checkSlugExistOrNot($this->params['slug']);
        if (!empty($post)) {
            $this->repo->updateViewCount($post['id']);
            $cmsData = $this->repo->checkSlugExistOrNot($this->params['slug']);
            $tags = $this->repo->getPostsTagsById($post['id']);
            $categories = $this->repo->getCategoriesByPostId($post['id']);
            $category = [];
            if (!empty($categories)) {
                foreach ($categories as $value) {
                    $category[] = $value['name'];
                }
            }
            return View::render('Front/CMS/detail.php', ['post' => $cmsData, 'tags' => explode(',', $tags), 'categories' => $category]);
        }
        return View::render('Front/error.php');

    }

}
