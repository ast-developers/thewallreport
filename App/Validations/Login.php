<?php
namespace App\Validations;

use Core\Csrf;

class Login
{
    public function validate()
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

            // Verify Password : Required
            if (empty($_POST['password'])) {
                $success = false;
                $messages[] = 'Please enter Password.';
            }
        }

        return ['success' => $success, 'messages' => $messages];
    }
    public function validateResetPassword()
    {
        $success = true;
        $messages = [];

        if (isset($_POST['submit'])) {

            // Email : Required
            if (empty($_POST['email'])) {
                $success = false;
                $messages[] = 'Please enter Email.';
            }
        }

        return ['success' => $success, 'messages' => $messages];
    }

    public function validatePassword(){
        $success = true;
        $messages = [];

        if (isset($_POST['submit'])) {

            // Email : Required
            if (empty($_POST['password'])) {
                $success = false;
                $messages[] = 'Please enter Email.';
            }
            // Password and confirm password should match
            if (!empty($_POST['password']) && !empty($_POST['rpassword']) && $_POST['rpassword']!=$_POST['password']) {
                $success = false;
                $messages[] = 'Password and confirmation password does not match';
            }
            return ['success' => $success, 'messages' => $messages];
        }
    }
}