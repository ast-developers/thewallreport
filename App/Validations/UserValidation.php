<?php
namespace App\Validations;

use App\Models\User;
use Core\Csrf;

/**
 * Class UserValidation
 * @package App\Validations
 */
class UserValidation
{
    public $model;

    public function __construct($params = [])
    {
        $this->model = new User();
    }

    /**
     * @return array
     */
    public function addUserValidation()
    {
        $success = true;
        $messages = [];

        if (isset($_POST['submit'])) {

            // Verify CSRF Token
            $verify_token = Csrf::verifyToken();
            if (!$verify_token) {
                $success = false;
                $messages[] = 'Invalid Token.';
            }
            // Username/Email : Required
            if (empty($_POST['username'])) {
                $success = false;
                $messages[] = 'Please enter Username/Email.';
            }

            if (isset($_POST['password']) && empty($_POST['password'])) {
                $success = false;
                $messages[] = 'Please enter Email.';
            }
            // Check Email Exist or Not
            if (!empty($_POST['username'])) {

                if (!empty($_POST['id'])) {
                    $user = $this->model->getUserById($_POST['id']);
                    $if_user_not_exist = $this->model->isUserNameExist($_POST['username']);
                    $is_exist = ($_POST['username'] == $user['username']) ? true : $if_user_not_exist;
                } else {
                    $is_exist = $this->model->isUserNameExist($_POST['username']);
                }

                if (!$is_exist) {
                    $success = false;
                    $messages[] = 'Username Already Exist.';
                }
            }
            // Check Username Exist or Not
            if (!empty($_POST['email'])) {
                if (!empty($_POST['id'])) {
                    $user = $this->model->getUserById($_POST['id']);
                    $if_user_not_exist = $this->model->isEmailExist($_POST['email']);
                    $is_exist = ($_POST['email'] == $user['email']) ? true : $if_user_not_exist;
                } else {
                    $is_exist = $this->model->isEmailExist($_POST['email']);
                }
                if (!$is_exist) {
                    $success = false;
                    $messages[] = 'Email Already Exist.';
                }
            }

            // Password and confirm password should match
            if (!empty($_POST['password']) && !empty($_POST['rpassword']) && $_POST['rpassword'] != $_POST['password']) {
                $success = false;
                $messages[] = 'Password and confirmation password does not match';
            }
        }
        if (!empty($_FILES['avatar']['name'])) {
            // Check extension
            $imagesizedata = getimagesize($_FILES['avatar']['tmp_name']);
            if ($imagesizedata === FALSE) {
                $success = false;
                $messages[] = 'Please upload Image file only.';
            }

        }
        return ['success' => $success, 'messages' => $messages];
    }

}