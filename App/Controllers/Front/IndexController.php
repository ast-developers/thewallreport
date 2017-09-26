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
     * @throws \Exception
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
        $banners = $this->repo->getFeaturedBanners();
        View::render('Front/index.php', ['banners' => $banners]);
    }

}
