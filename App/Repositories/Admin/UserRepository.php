<?php

namespace App\Repositories\Admin;

use App\Config;
use App\Models\PasswordReminder;
use App\Models\User;
use Core\Helper;
use Core\Mail;


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
     *
     */
    public function __construct()
    {
        $this->model = new User();
        $this->passwordReminderModel = new PasswordReminder();
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


}
