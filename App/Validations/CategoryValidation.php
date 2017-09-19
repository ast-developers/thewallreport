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

            if (!empty($_POST['slug'])) {
                if (!empty($_POST['id'])) {
                    $category = $this->model->getCategoryById($_POST['id']);
                    $if_slug_not_exist = $this->model->isSlugExist($_POST['slug']);
                    $is_exist = ($_POST['slug'] == $category[0]['slug']) ? true : $if_slug_not_exist;
                } else {
                    $is_exist = $this->model->isSlugExist($_POST['slug']);
                }

                if (!$is_exist) {
                    $success = false;
                    $messages[] = 'Slug already exist, Please try different one.';
                }
            }


        }

        return ['success' => $success, 'messages' => $messages];
    }

}