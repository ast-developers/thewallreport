<?php

namespace App\Controllers\Front;

use \Core\View;


class IndexController extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::render('Front/index.php');
    }

}
