<?php

namespace App\Controllers\Admin;

use \Core\View;


class FlowFlowController extends \Core\Controller
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
