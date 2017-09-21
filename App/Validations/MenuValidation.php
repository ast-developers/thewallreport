<?php
namespace App\Validations;

use App\Models\Menu;
use Core\Csrf;


class MenuValidation
{
    public $model;

    public function __construct($params = [])
    {
        $this->model = new Menu();
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
            // Menu name : Required
            if (empty($_POST['name'])) {
                $success = false;
                $messages[] = 'Please enter menu name.';
            }

            return ['success' => $success, 'messages' => $messages];
        }
    }

}