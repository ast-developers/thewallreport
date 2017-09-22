<?php
namespace App\Validations;

use App\Models\Category;
use Core\Csrf;

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

            if (empty($_POST['security_check'])) {
                $success = false;
                $messages[] = 'Please enter Security questions answer.';
            }
            if (!empty($_POST['security_check']) && $_POST['security_check'] != 7) {
                $success = false;
                $messages[] = 'You have answered wrong for security question.';
            }

        }

        return ['success' => $success, 'messages' => $messages];
    }

}