<?php
namespace App\Validations;

use App\Models\Post;
use Core\Csrf;


/**
 * Class PostValidation
 * @package App\Validations
 */
class PostValidation
{
    /**
     * @var Post
     */
    public $model;

    /**
     * @param array $params
     */
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

        if (isset($_POST['submit']) || isset($_POST['status_submit'])) {

            // Verify CSRF Token
            $verify_token = Csrf::verifyToken();
            if (!$verify_token) {
                $success = false;
                $messages[] = 'Invalid Token.';
            }
            // Post name : Required
            if (empty($_POST['name'])) {
                $success = false;
                $messages[] = 'Please enter post name.';
            }
            if (!empty($_POST['views']) && !is_numeric($_POST['views'])) {
                $success = false;
                $messages[] = 'Please enter valid number for views.';
            }
            if (!empty($_FILES['featured_image']['name'])) {
                // Check extension
                $imagesizedata = getimagesize($_FILES['featured_image']['tmp_name']);
                if ($imagesizedata === FALSE) {
                    $success = false;
                    $messages[] = 'Please upload Image file only.';
                }

            }

            return ['success' => $success, 'messages' => $messages];
        }
    }

}