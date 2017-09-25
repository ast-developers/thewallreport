<?php
namespace App\Validations;

use App\Models\Page;
use Core\Csrf;


/**
 * Class PageValidation
 * @package App\Validations
 */
class PageValidation
{
    /**
     * @var Page
     */
    public $model;

    /**
     * @param array $params
     */
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

        if (isset($_POST['submit']) || isset($_POST['status_submit'])) {

            // Verify CSRF Token
            $verify_token = Csrf::verifyToken();
            if (!$verify_token) {
                $success = false;
                $messages[] = 'Invalid Token.';
            }
            // Page name : Required\
            if (empty($_POST['name'])) {
                $success = false;
                $messages[] = 'Please enter page name.';
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