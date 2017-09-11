<?php

namespace App\Controllers\Admin;

use App\Config;
use App\Models\User;
use Core\Csrf;
use \Core\View;
use \Core\Controller;



/**
 * Home controller
 *
 * PHP version 7.0
 */
class UserController extends Controller
{
    public $model;
    public $csrf;
    public function __construct(){
        $this->model = new User();
        $this->csrf = new Csrf();
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function loginAction()
    {

        if(isset($_POST['submit'])){
            $verify_token = $this->csrf->verifyToken();
            if(!$verify_token){
                return View::render('Admin/login.php',['token'=>$this->csrf->getToken(),'flash_message'=>'Username/email or Password is incorrect','error_class'=>'alert-danger']);
            }
                $is_login = $this->model->checkLogin($_POST['username'],$_POST['password']);
                if($is_login){
                    $_SESSION["logged_in"] = "1";
                    header('Location: '.Config::W_ROOT.'admin/dashboard');
                }else{
                    return View::render('Admin/login.php',['flash_message'=>'Username/email or Password is incorrect','error_class'=>'alert-danger']);
                }

        }
        return View::render('Admin/login.php',['token'=>$this->csrf->getToken()]);
    }

    public function dashboard(){

        View::render('Admin/dashboard.php',['flash_message'=>'Logged in successfully','error_class'=>'alert-success']);

    }
    public function logoutAction(){
        session_destroy();
        header('Location: '.Config::W_ROOT.'admin/login');
    }

    public function error(){
        View::render('Admin/404.php');
    }

}
