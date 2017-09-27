<?php

namespace App\Controllers\Front;

use App\Repositories\Admin\PageRepository;
use App\Repositories\Front\CMSRepository;
use App\Repositories\Front\PostRepository;
use Core\Controller;
use Core\View;


/**
 * Class CMSController
 * @package App\Controllers\Front
 */
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
        $this->repo = new CMSRepository();
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
            return View::render('Front/CMS/post_detail.php', ['post' => $cmsData, 'tags' => explode(',', $tags), 'categories' => $category]);
        }
        $page = $this->repo->checkPageSlugExistOrNot($this->params['slug']);
        if (!empty($page)) {
            $cmsData = $this->repo->checkPageSlugExistOrNot($this->params['slug']);
            return View::render('Front/CMS/page_detail.php', ['page' => $cmsData]);
        }
        return View::render('Front/error.php');

    }

}
