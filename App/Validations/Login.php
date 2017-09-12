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
}