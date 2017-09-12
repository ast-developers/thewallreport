<?php
namespace Core;

/**
 * Class Csrf
 * @package Core
 */
class Csrf
{
    /**
     * Get CSRF Token
     * @return string
     */
    public static function getToken()
    {
        if (empty($_SESSION['token'])) {
            if (function_exists('mcrypt_create_iv')) {
                $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
            } else {
                $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
            }
        }
        $token = $_SESSION['token'];
        return $token;
    }

    /**
     * Verify CSRF Token, posted in Form
     * @return bool
     */
    public static function verifyToken()
    {
        if (!empty($_POST['token'])) {
            if (hash_equals($_SESSION['token'], $_POST['token'])) {
                return true;
            } else {
                return false;
            }
        }
    }
}