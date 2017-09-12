<?php
namespace App\Middlewares;

use Core\Router;

class Guest
{
    public function handel(){
        $sessionUser = isset($_SESSION['user']) && $_SESSION['user'] ? $_SESSION['user'] : false;
        if($sessionUser){
            Router::redirectTo('admin/dashboard');
        }

    }
}