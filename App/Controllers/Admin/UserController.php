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

    public function sendResetPasswordLink(){

        if (isset($_POST['submit'])) {
            // Form Validations
            $formValid = $this->validate->validateResetPassword();

            if(!$formValid['success']){
                return View::render('Admin/login.php', ['flash_message' => $formValid['messages'], 'error_class' => 'alert-danger']);
            }
            // Check Email Exist in records or not
            $is_exist = $this->model->getUserByEmail($_POST['email']);
            if(!$is_exist){
                return View::render('Admin/login.php', ['flash_message' => ['Your Email does not exist in our record'], 'error_class' => 'alert-danger']);
            }
            $send_mail = $this->repo->sendResetPasswordLink($_POST['email']);
            if($send_mail['success']){
                return View::render('Admin/login.php', ['flash_message' => ['Password Reset Link sent to your email'], 'error_class' => 'alert-success']);
            }else{
                return View::render('Admin/login.php', ['flash_message' => [$send_mail['message']], 'error_class' => 'alert-danger']);
            }
        }else{
            return View::render('Admin/login.php', ['flash_message' => ['Please enter the data'], 'error_class' => 'alert-danger']);
        }

    }

    public function resetPassword(){
        $url = explode('/',key($_GET));
        $token = end($url);
        $email = $this->model->getEmailByToken($token);
        if(!$email['success']){
            return View::render('Admin/login.php', ['flash_message' => ['Invalid token'], 'error_class' => 'alert-danger']);
        }else{
            return View::render('Admin/reset_password.php',['token' =>$token]);
        }

    }

    public function changePassword(){
        if (isset($_POST['submit'])) {
            $formValid = $this->validate->validatePassword();
        }
        if(!$formValid['success']){
            return View::render('Admin/reset_password.php', ['flash_message' => $formValid['messages'], 'error_class' => 'alert-danger','token'=>$_POST['token']]);
        }
        $email = $this->model->getEmailByToken($_POST['token']);
        if(!$email['success']){
            return View::render('Admin/login.php', ['flash_message' => ['Invalid token used for password reset'], 'error_class' => 'alert-danger']);
        }
        $this->model->changePassword(md5($_POST['password']),$email['email']);
        return View::render('Admin/login.php', ['flash_message' => ['Your Password Changed Successfully'], 'error_class' => 'alert-success']);
    }

    /**
     * @throws \Exception
     */
    public function error()
    {
        View::render('Admin/404.php');
    }

}
