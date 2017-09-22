<?php

namespace App\Controllers\Front;

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
    public function indexAction()
    {
        View::render('Front/index.php');
    }

}
