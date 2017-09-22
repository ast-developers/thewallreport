<?php

namespace App\Controllers\Admin;

use Core\View;
use Core\Controller;


class FlowFlowController extends Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::render('Admin/FlowFlow/index.php');
    }

}
