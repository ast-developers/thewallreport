<?php
namespace App\Validations;

use App\Models\Post;
use Core\Csrf;


class PostValidation
{
    public $model;

    public function __construct($params = [])
    {
        $this->model = new Post();
    }

    /**
     * @return array
     */
    public function addPostValidation()
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

            return ['success' => $success, 'messages' => $messages];
        }
    }

}