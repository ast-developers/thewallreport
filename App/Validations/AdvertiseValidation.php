<?php
namespace App\Validations;

use App\Models\Advertise;
use Core\Csrf;


/**
 * Class AdvertiseValidation
 * @package App\Validations
 */
class AdvertiseValidation
{
    /**
     * @var Advertise
     */
    public $model;
    /**
     * @var
     */
    public $post_repo;
    /**
     * @var
     */
    public $page_repo;

    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->model = new Advertise();

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
                $messages[] = 'Please enter advertise name.';
            }

            if (empty($_POST['type'])) {
                $success = false;
                $messages[] = 'Please enter advertise type.';
            }

            if (!empty($_POST['type']) && $_POST['type'] != 'banner' && $_POST['type'] != 'adsense') {
                $success = false;
                $messages[] = 'Please choose valid advertise type.';
            }

            if (!empty($_FILES['banner_image']['name'])) {
                // Check extension
                $imagesizedata = getimagesize($_FILES['banner_image']['tmp_name']);
                if ($imagesizedata === FALSE) {
                    $success = false;
                    $messages[] = 'Please upload Image file only.';
                }

            }


            return ['success' => $success, 'messages' => $messages];
        }
    }

}