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
            if (empty($_POST['name'])) {
                $success = false;
                $messages[] = 'Please enter post name.';
            }

            return ['success' => $success, 'messages' => $messages];
        }
    }

}