<?php

namespace App\Controllers\Admin;


use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\TagRepository;


class TagController extends \Core\Controller
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
