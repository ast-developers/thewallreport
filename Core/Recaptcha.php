<?php
namespace Core;

use App\Config;

/**
 * Class Recaptcha
 * @package Core
 */
class Recaptcha
{
    /**
     * @var string
     */
    protected $site_key;
    /**
     * @var string
     */
    protected $secret_key;
    /**
     * @var string
     */
    protected $verification_url;

    # The constructor
    /**
     *
     */
    public function __construct()
    {
        $this->site_key = Config::GOOGLE_RECAPTCHA_SITE_KEY;
        $this->secret_key = Config::GOOGLE_RECAPTCHA_SECRET_KEY;
        $this->verification_url = 'https://www.google.com/recaptcha/api/siteverify';
    }

    # List the properties
    /**
     * @return string
     */
    public function buildRecaptchaHtml()
    {
        return "<div class='g-recaptcha' data-sitekey=" . $this->site_key . "></div>";
    }


    /**
     * @param $response
     * @return mixed
     */
    public function validateRecaptcha($response)
    {
        $url = $this->verification_url;
        $data = array(
            'secret' => $this->secret_key,
            'response' => $response
        );
        $query = http_build_query($data);
        $options = array(
            'http' => array(
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                    "Content-Length: " . strlen($query) . "\r\n",
                'method' => 'POST',
                'content' => $query
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false
            )
        );
        $context = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success = json_decode($verify);
        return $captcha_success->success;
    }
}

?>