<?php

namespace App\Repositories\Admin;

use App\Config;
use App\Models\User;
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
     *
     */
    public function __construct()
    {
        $this->model = new User();
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
    public function random_string($length) {
        $key = '';
        $keys = range('a', 'z');

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    public function sendResetPasswordLink($email){
        $token = $this->random_string(36);
        $this->model->storeResetPasswordToken($email,$token);
        $body = '<a href='.Config::W_ROOT.'admin/reset-password/'.$token.'>Click here</a> to reset your password';
        $subject = 'Password Reset';
        $send_mail = Mail::sendMail('dhaval.prajapati@arsenaltech.com',$subject,$body);
        return $send_mail;
    }


}
