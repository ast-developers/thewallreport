<?php
namespace App\Validations;

use App\Models\Category;
use Core\Csrf;

/**
 * Class UserValidation
 * @package App\Validations
 */
class CategoryValidation
{
    public $model;

    public function __construct($params = [])
    {
        $this->model = new Category();
    }

    /**
     * @return array
     */
    public function addCategoryValidation()
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
                $messages[] = 'Please enter Category Name.';
            }

            if (empty($_POST['slug'])) {
                $success = false;
                $messages[] = 'Please enter Slug.';
            }


        }

        return ['success' => $success, 'messages' => $messages];
    }

}