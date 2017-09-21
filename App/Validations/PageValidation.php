<?php
namespace App\Validations;

use App\Models\Page;
use Core\Csrf;


class PageValidation
{
    public $model;

    public function __construct($params = [])
    {
        $this->model = new Page();
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
            // Page name : Required
            if (empty($_POST['name'])) {
                $success = false;
                $messages[] = 'Please enter page name.';
            }

            return ['success' => $success, 'messages' => $messages];
        }
    }

}