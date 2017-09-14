<?php
namespace App\Validations;

use Core\Csrf;

/**
 * Class UserValidation
 * @package App\Validations
 */
class UserValidation
{
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

            if (empty($_POST['password'])) {
                $success = false;
                $messages[] = 'Please enter Email.';
            }

            // Password and confirm password should match
            if (!empty($_POST['password']) && !empty($_POST['rpassword']) && $_POST['rpassword'] != $_POST['password']) {
                $success = false;
                $messages[] = 'Password and confirmation password does not match';
            }
        }
        if (isset($_FILES['avatar'])) {

            // Check extension
            $imageFileType = pathinfo($_FILES['avatar']['type'] . '/' . $_FILES['avatar']["name"], PATHINFO_EXTENSION);
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $success = false;
                $messages[] = 'Please use jpg, png or jpeg file for avatar.';
            }

        }

        return ['success' => $success, 'messages' => $messages];
    }

}