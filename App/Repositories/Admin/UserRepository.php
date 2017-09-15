<?php

namespace App\Repositories\Admin;

use App\Config;
use App\Models\PasswordReminder;
use App\Models\Role;
use App\Models\User;
use Core\Helper;
use Core\Mail;
use Exception;


/**
 * Class UserRepository
 * @package App\Repositories\Admin
 */
class UserRepository
{
    /**
     * @var User
     */
    public $model;
    /**
     * @var PasswordReminder
     */
    public $passwordReminderModel;
    /**
     * @var Role
     */
    public $rolmodel;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new User();
        $this->passwordReminderModel = new PasswordReminder();
        $this->rolmodel = new Role();
    }

    /**
     * @param bool|false $username
     * @param bool|false $password
     * @return array
     */
    public function login($username = false, $password = false)
    {
        // Check if User already logged in or not.
        $sessionUser = isset($_SESSION['user']) && $_SESSION['user'] ? $_SESSION['user'] : false;
        if ($sessionUser) {
            return ['success' => false, 'messages' => ['User already authenticated.']];
        }

        // If not then authenticate him.
        $user = $this->model->getUserForLogin($username, md5($password));
        if (!$user) {
            return ['success' => false, 'messages' => ['Incorrect Username or Password.']];
        }

        // Set user in session.
        $_SESSION['user'] = $user;
        return ['success' => true, 'messages' => ['Logged in successfully.']];
    }

    /**
     * @param $email
     * @return array
     */
    public function sendResetPasswordLink($email)
    {
        $token = Helper::randomString(36);
        $this->passwordReminderModel->storeResetPasswordToken($email, $token);
        $body = '<p>Hello,</p>';
        $body .= '<p><a href=' . Config::W_ROOT . 'admin/reset-password/' . $token . '>Click here</a> to reset your password</p>';
        $subject = 'Password Reset';
        $send_mail = Mail::sendMail($email, $subject, $body);
        return $send_mail;
    }

    /**
     * @param $token
     * @return array|bool
     */
    public function getEmailByToken($token)
    {
        $email = $this->passwordReminderModel->getEmailByToken($token);
        return $email;
    }

    /**
     * @param $email
     * @return bool
     */
    public function getUserByEmail($email)
    {
        $user = $this->model->getUserByEmail($email);
        return $user;
    }

    /**
     * @param $password
     * @param $email
     */
    public function changePassword($password, $email)
    {
        $this->model->changePassword($password, $email);
    }

    /**
     * @param $email
     */
    public function removeTokenByEmail($email)
    {
        $this->passwordReminderModel->removeTokenByEmail($email);
    }


    /**
     * @return bool
     */
    public function getUsers()
    {
        $users = $this->model->getUsers();
        return $users;
    }

    /**
     * @param $username
     * @return bool
     */
    public function isUserNameExist($username, $id = false)
    {
        $is_exist = $this->model->isUserNameExist($username);
        if ($id) {
            $user = $this->getUserById($id);
            return ($user['username'] == $username) ? true : false;
        }
        return $is_exist;
    }

    /**
     * @param $id
     * @return bool
     */
    public function getUserById($id)
    {
        return $this->model->getUserById($id);
    }

    /**
     * @return bool
     */
    public function getRoles()
    {
        return $this->rolmodel->getRoles();
    }

    /**
     * @param $filedata
     * @return array
     */
    public function uploadAvatar($filedata)
    {
        $target_dir = Config::F_USER_AVATAR_ROOT;
        if(!file_exists($target_dir)){
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($filedata["name"]);
        if (!file_exists($target_file)) {
            if (move_uploaded_file($filedata["tmp_name"], $target_file)) {
                return ['success' => true, 'filename' => $filedata["name"]];
            } else {
                return ['success' => false, 'messages' => ['Failed to upload Avatar.']];
            }
        } else {
            return ['success' => true, 'filename' => $filedata["name"]];
        }

    }

    /**
     * @param int $userId
     */
    public function removeUserAvatar($userId = 0)
    {
        $user = $this->model->getUserById($userId);
        if ($user && $user['profile_image']) {
            $target_dir = Config::F_USER_AVATAR_ROOT;
            $target_file = $target_dir . $user['profile_image'];
            try{
                unlink($target_file);
            } catch (Exception $e){

            }
        }
    }

    /**
     * @param $user
     * @param $filename
     * @return bool
     */
    public function insertUserData($user, $filename)
    {
        return $this->model->insertUserData($user, $filename);
    }

    /**
     * @param $user
     * @param $filename
     * @return bool
     */
    public function updateUserData($user, $filename)
    {
        return $this->model->updateUserData($user, $filename);
    }

    /**
     * @param $params
     */
    public function getUserAjaxPagination($params)
    {
        return $this->model->getUserAjaxPagination($params);
    }

    /**
     * @param $ids
     */
    public function bulkDeleteUsers($ids)
    {
        $this->model->bulkDeleteUsers($ids);
    }

}
