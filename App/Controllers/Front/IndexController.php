<?php

namespace App\Controllers\Front;

use App\Repositories\Front\IndexRepository;
use Core\View;
use Core\Controller;


/**
 * Class IndexController
 * @package App\Controllers\Front
 */
class IndexController extends Controller
{

    /**
     * @var
     */
    protected $menu_repo;
    /**
     * @var IndexRepository
     */
    protected $repo;

    /**
     *
     */
    public function __construct()
    {
        $this->repo = new IndexRepository();
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        $menus = $this->repo->getMenus();
        View::render('Front/index.php', ['menus' => $menus]);
    }

}
