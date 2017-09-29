<?php

namespace App;

    /**
     * Class Config
     * Application configuration
     * @package App
     */
    /**
     * Class Config
     * @package App
     */
/**
 * Class Config
 * @package App
 */
/**
 * Class Config
 * @package App
 */
/**
 * Class Config
 * @package App
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'wallreport';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'mysql';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * App Page Title
     */
    const PAGE_TITLE_PREFIX = 'The Wall Report';

    /**
     * SMTP HOST
     */
    const SMTP_HOST = 'smtp.gmail.com';
    /**
     * SMTP PORT
     */
    const SMTP_PORT = '587';
    /**
     * SMTP USERNAME
     */
    const SMTP_USERNAME = 'dhaval.prajapati333@gmail.com';
    /**
     * SMTP PASSWORD
     */
    const SMTP_PASSWORD = 'Dhaval333';

    /**
     * Website Root
     */
    const W_ROOT = "http://local.thewall.report/";

    /**
     * File Root
     */
    const F_ROOT = "/home/devendra-bhati/public_html/thewallreport/";

    /**
     * File Assets Root
     */
    const W_ADMIN_ASSETS = self::W_ROOT . "theme/admin/assets";

    /**
     * File View Root
     */
    const F_VIEW = self::F_ROOT . "App/Views/";

    /**
     * User Profile Root
     */
    const W_USER_AVATAR_ROOT = self::W_ROOT . 'uploads/profile_images/';

    /**
     * User Profile Root
     */
    const F_USER_AVATAR_ROOT = self::F_ROOT . 'public/uploads/profile_images/';

    /**
     * Flow Flow Root
     */
    const F_FLOW_FLOW_ROOT = self::F_ROOT . "public/plugins/flow-flow/flow-flow/";

    /**
     * Front Assets Root
     */
    const W_FRONT_ASSETS = self::W_ROOT . "theme/front/assets/";
    /**
     * Redactor Images Path
     */
    const F_REDACTOR_IMAGE = self::F_ROOT . "public/uploads/redactor_image/";
    /**
     * Redactor Images Path
     */
    const W_REDACTOR_IMAGE = self::W_ROOT . "uploads/redactor_image/";
    /**
     * Contact us Email
     */
    const CONTACT_US_TO_EMAIL = "developers@arsenaltech.com";
    /**
     * Google Recaptcha site key
     */
    const GOOGLE_RECAPTCHA_SITE_KEY = "6LfE7zEUAAAAAFWx18Ig3tHozskPh0tzYxqfvJeF";
    /**
     * Google Recaptcha secret key
     */
    const GOOGLE_RECAPTCHA_SECRET_KEY = "6LfE7zEUAAAAAIA1In49BZ7EcUQ-WXtOq5nZDKz9";
    /**
     * Featured Image Path
     */
    const F_FEATURED_IMAGE_ROOT = self::F_ROOT . "public/uploads/featured_image/";
    /**
     * Featured Image Path
     */
    const W_FEATURED_IMAGE_ROOT = self::W_ROOT . "uploads/featured_image/";
    /**
     * Share on facebook App id
     */
    const SHARE_ON_FACEBOOK_APP_ID = "311382379200231";


}
