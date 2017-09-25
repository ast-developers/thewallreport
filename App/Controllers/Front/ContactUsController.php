<?php

namespace App\Controllers\Front;

use App\Config;
use App\Validations\ContactUsValidation;
use Core\Mail;
use Core\Router;
use Core\View;
use Core\Controller;


/**
 * Class ContactUsController
 * @package App\Controllers\Front
 */
class ContactUsController extends Controller
{
    /**
     * @var ContactUsValidation
     */
    protected $validate;

    /**
     * @throws \Exception
     */
    public function __construct($params = [])
    {
        $this->validate = new ContactUsValidation();
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        if (!empty($_POST['submit'])) {

            $formValid = $this->validate->validate();
            if (!$formValid['success']) {
                return Router::redirectTo('contact-us', $formValid['messages'], 'alert-danger');
            }
            $body = '<p>Name: ' . $_POST['name'] . '</p>';
            $body .= '<p>Email: ' . $_POST['email'] . '</p>';
            $body .= '<p>Message: ' . $_POST['message'] . '</p>';
            $subject = 'Inquiry';
            $send_mail = Mail::sendMail(Config::CONTACT_US_TO_EMAIL, $subject, $body);
            if ($send_mail['success']) {
                $_SESSION["flash_message"] = ['Thanks, we received your request, will get back to you soon.'];
                $_SESSION["error_class"] = 'alert-success';
                return Router::redirectTo('contact-us', $formValid['messages'], 'alert-success');
            } else {
                return Router::redirectTo('contact-us', $formValid['messages'], 'alert-danger');
            }
        } else {
            View::render('Front/contactus.php');
        }

    }

}
