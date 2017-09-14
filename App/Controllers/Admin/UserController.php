<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Validations\UserValidation;
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
    public $uservalidate;

    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->repo = new UserRepository();
        $this->validate = new Login();
        $this->params = $params;
        $this->uservalidate = new UserValidation();
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

    public function getUsers()
    {
        $users = $this->repo->getUsers();
        View::render('Admin/Users/listuser.php', ['users' => $users]);
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
                return View::render('Admin/Login$this->db/login.php', ['flash_message' => [$send_mail['message']], 'error_class' => 'alert-danger']);
            }
        } else {
            return View::render('Admin/Login/login.php');
        }

    }

    /**
     * @throws \Exception
     */
    public function resetPasswordAction()
    {
        $email = $this->repo->getEmailByToken($this->params['token']);
        if (!$email['success']) {
            return View::render('Admin/Login/resetPassword.php', ['flash_message' => ['Invalid token.'], 'error_class' => 'alert-danger', 'token' => $this->params['token']]);
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

    public function addUser()
    {
        if (isset($_POST['submit'])) {
            $this->uservalidate->addUserValidation();
            $roles = $this->repo->getRoles();
            // Check Email Exist in records or not
            $is_exist = $this->repo->isUserNameExist($_POST['username']);
            if (!$is_exist) {
                return View::render('Admin/Users/adduser.php', ['roles' => $roles, 'flash_message' => ['Username Already Exist.'], 'error_class' => 'alert-danger']);
            }
            if (!empty($_FILES['avatar'])) {
                $avatarUpload = $this->repo->uploadAvatar($_FILES['avatar']);
                if (!$avatarUpload['success']) {
                    return View::render('Admin/Users/adduser.php', ['roles' => $roles, 'flash_message' => $avatarUpload['messages']]);
                }
            }
            $this->repo->inserUserData($_POST, $avatarUpload['filename']);
            $_SESSION["flash_message"] = 'User Added Successfully.';
            $_SESSION["error_class"] = 'alert-success';
            Router::redirectTo('admin/users');
        } else {
            $roles = $this->repo->getRoles();
            View::render('Admin/Users/adduser.php', ['roles' => $roles]);
        }
    }

    public function editUser()
    {
        if (isset($_POST['submit'])) {
            $this->uservalidate->addUserValidation();
            if (!empty($_FILES['avatar']['tmp_name'])) {
                $avatarUpload = $this->repo->uploadAvatar($_FILES['avatar']);
                if (!$avatarUpload['success']) {
                    $roles = $this->repo->getRoles();
                    return View::render('Admin/Users/adduser.php', ['roles' => $roles, 'flash_message' => $avatarUpload['messages']]);
                }
            }
            $filename = (!empty($avatarUpload['filename'])) ? $avatarUpload['filename'] : NULL;
            $this->repo->updateUserData($_POST, $filename);
            $_SESSION["flash_message"] = 'User Edited Successfully.';
            $_SESSION["error_class"] = 'alert-success';
            Router::redirectTo('admin/users');
        } else {
            $user = $this->repo->getUserById($this->params['id']);
            $roles = $this->repo->getRoles();
            View::render('Admin/Users/adduser.php', ['user' => $user, 'roles' => $roles]);
        }
    }

    public function checkuser()
    {
        $is_exist = $this->repo->isUserNameExist($_GET['username']);
        return $is_exist;
    }

    public function userPaginate()
    {
        return $this->repo->getUserAjaxPagination($_REQUEST);
    }

    public function bulkDeleteUsers()
    {
        $this->repo->bulkDeleteUsers($_REQUEST);
    }


    /**
     * @throws \Exception
     */
    public function error()
    {
        View::render('Admin/404.php');
    }

}
