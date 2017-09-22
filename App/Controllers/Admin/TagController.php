<?php

namespace App\Controllers\Admin;


use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\TagRepository;
use Core\Controller;


class TagController extends Controller
{

    /**
     * @var CategoryRepository
     */
    protected $repo;
    protected $params;



    public function __construct($params = [])
    {
        $this->params = $params;
        $this->repo = new TagRepository();
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        $this->repo->getTagsByKeyword($_GET);

    }

}
