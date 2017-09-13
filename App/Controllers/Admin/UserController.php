<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Repositories\Admin\UserRepository;
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
    /**
     * @var Login
     */
    public $validate;
    /**
     * @var array
     */
    public $params;

    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->repo = new UserRepository();
        $this->validate = new Login();
        $this->params = $params;
    }

    /**
     * @throws \Exception
     */
    public function loginAction()
    {
        if (isset($_POST['submit'])) {

            // Form Validations
            $formValid = $this->validate->validate();
            if (!$formValid['success']) {
                return View::render('Admin/Login/login.php', ['flash_message' => $formValid['messages'], 'error_class' => 'alert-danger']);
            }
            // Authenticate User
            $login = $this->repo->login($_POST['username'], $_POST['password']);
            if (!$login['success']) {
                return View::render('Admin/Login/login.php', ['flash_message' => $login['messages'], 'error_class' => 'alert-danger']);
            } else {
                Router::redirectTo('admin/dashboard');
            }
        }
        return View::render('Admin/Login/login.php');
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
    public function dashboardAction()
    {
        View::render('Admin/dashboard.php', ['flash_message' => 'Logged in successfully.', 'error_class' => 'alert-success']);
    }

    /**
     * @throws \Exception
     */
    public function sendResetPasswordLinkAction()
    {

        if (isset($_POST['submit'])) {
            // Form Validations
            $formValid = $this->validate->validateResetPassword();

            if (!$formValid['success']) {
                return View::render('Admin/Login/login.php', ['flash_message' => $formValid['messages'], 'error_class' => 'alert-danger']);
            }
            // Check Email Exist in records or not
            $is_exist = $this->repo->getUserByEmail($_POST['email']);
            if (!$is_exist) {
                return View::render('Admin/Login/login.php', ['flash_message' => ['User Email does not exist in system.'], 'error_class' => 'alert-danger']);
            }
            $send_mail = $this->repo->sendResetPasswordLink($_POST['email']);
            if ($send_mail['success']) {
                $_SESSION["flash_message"] = 'Password Reset Link sent to your email.';
                $_SESSION["error_class"] = 'alert-success';
                Router::redirectTo('admin/login');
            } else {
                return View::render('Admin/Login/login.php', ['flash_message' => [$send_mail['message']], 'error_class' => 'alert-danger']);
            }
        } else {
            return View::render('Admin/Login/login.php', ['flash_message' => ['Please enter the data.'], 'error_class' => 'alert-danger']);
        }

    }

    /**
     * @throws \Exception
     */
    public function resetPasswordAction()
    {
        $email = $this->repo->getEmailByToken($this->params['token']);
        if (!$email['success']) {
            return View::render('Admin/Login/resetPassword.php', ['flash_message' => ['Invalid token.'], 'error_class' => 'alert-danger','token' => $this->params['token']]);
        } else {
            return View::render('Admin/Login/resetPassword.php', ['token' => $this->params['token']]);
        }

    }

    /**
     * @throws \Exception
     */
    public function changePassword()
    {
        if (isset($_POST['submit'])) {
            $formValid = $this->validate->validatePassword();
            if (!$formValid['success']) {
                return View::render('Admin/Login/resetPassword.php', ['flash_message' => $formValid['messages'], 'error_class' => 'alert-danger', 'token' => $_POST['password_token']]);
            }
            $email = $this->repo->getEmailByToken($_POST['password_token']);
            if (!$email['success']) {
                return View::render('Admin/Login/login.php', ['flash_message' => ['Invalid token used for password reset.'], 'error_class' => 'alert-danger']);
            }
            $this->repo->changePassword(md5($_POST['password']), $email['email']);
            $this->repo->removeTokenByEmail($email['email']);
            $_SESSION["flash_message"] = 'Your Password Changed Successfully.';
            $_SESSION["error_class"] = 'alert-success';
        }
        Router::redirectTo('admin/login');
    }

    /**
     * @throws \Exception
     */
    public function error()
    {
        View::render('Admin/404.php');
    }

}
