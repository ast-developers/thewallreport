<?php
namespace App\Validations;

use Core\Csrf;
use Core\Recaptcha;

/**
 * Class ContactUsValidation
 * @package App\Validations
 */
class ContactUsValidation
{

    /**
     * @return array
     */
    public function validate()
    {
        $recaptcha = new Recaptcha();
        $success = true;
        $messages = [];

        if (isset($_POST['submit'])) {

            // Verify CSRF Token
            $verify_token = Csrf::verifyToken();
            if (!$verify_token) {
                $success = false;
                $messages[] = 'Invalid Token.';
            }

            if (empty($_POST['name'])) {
                $success = false;
                $messages[] = 'Please enter Name.';
            }

            if (empty($_POST['email'])) {
                $success = false;
                $messages[] = 'Please enter Email.';
            }

            if (empty($_POST['message'])) {
                $success = false;
                $messages[] = 'Please enter message.';
            }

            // Google recaptcha validation
            $verify_captcha = $recaptcha->validateRecaptcha($_POST["g-recaptcha-response"]);
            if (!$verify_captcha) {
                $success = false;
                $messages[] = 'Please validate recaptcha.';
            }

        }

        return ['success' => $success, 'messages' => $messages];
    }

}