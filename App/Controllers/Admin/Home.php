<?php

namespace App\Controllers\Admin;

use \Core\View;


/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        View::renderTemplate('Admin/login.php.twig');
    }

}
