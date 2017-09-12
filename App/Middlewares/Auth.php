<?php
namespace App\Middlewares;

use Core\Router;

/**
 * Class Auth
 * @package App\Middlewares
 */
class Auth
{
    /**
     *
     */
    public function handel()
    {
        $sessionUser = isset($_SESSION['user']) && $_SESSION['user'] ? $_SESSION['user'] : false;
        if (!$sessionUser) {
            Router::redirectTo('admin/login');
        }
    }
}