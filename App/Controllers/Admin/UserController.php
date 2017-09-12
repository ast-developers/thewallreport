<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Repositories\Admin\UserRepository;
use App\Models\User;
use Core\View;
use Core\Router;
use App\Validations\Login;

/**
 * Class UserController
 * @package App\Controllers\Admin
 */
class UserController extends Controller
{
    /**
     * @var User
     */
    public $repo;
    public $model;
    public $validate;

    /**
     *
     */
    public function __construct()
    {
        $this->repo = new UserRepository();
        $this->model = new User();
        $this->validate = new Login();
    }

    /**
     * @throws \Exception
     */
    public function loginAction()
    {
        if (isset($_POST['submit'])) {

            // Form Validations
            $formValid = $this->validate->validate();
            if(!$formValid['success']){
                return View::render('Admin/login.php', ['flash_message' => $formValid['messages'], 'error_class' => 'alert-danger']);
            }
            // Authenticate User
            $login = $this->repo->login($_POST['username'], $_POST['password']);
            if(!$login['success']){
                return View::render('Admin/login.php', ['flash_message' => $login['messages'], 'error_class' => 'alert-danger']);
            } else {
                Router::redirectTo('admin/dashboard');
            }
        }
        return View::render('Admin/login.php');
    }

    /**
     *
     */
    public function logoutAction()
    {
        session_destroy();
        Router::redirectTo('admin/login');
    }

    /**
     * @throws \Exception
     */
    public function dashboard()
    {
        View::render('Admin/dashboard.php', ['flash_message' => 'Logged in successfully', 'error_class' => 'alert-success']);
    }

    /**
     * @throws \Exception
     */
    public function error()
    {
        View::render('Admin/404.php');
    }

}
