<?php

namespace App;

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
    const DB_NAME = 'thewallreport';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'Ars3nal$0!';

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
    const SMTP_USERNAME = 'developers@arsenaltech.com';

    /**
     * SMTP PASSWORD
     */
    const SMTP_PASSWORD = 'Ar5ena1T3ch#0ev';

    /**
     * Website Root
     */
    const W_ROOT = "http://66.175.214.21/thewallreport/";

    /**
     * File Root
     */
    const F_ROOT =  "/var/www/html/thewallreport/";

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
     * Share on facebook App id
     */
    const SHARE_ON_FACEBOOK_APP_ID = "311382379200231";

    /**
     * Amazon S3 Key
     */
    const S3_ACCESS_KEY = "AKIAJHQJ5SXX7V4U56ZA";

    /**
     * Amazon S3 Secret Key
     */
    const S3_SECRET_KEY = "UD2Mm6U3xg18RIpOsd4YUoy/t2xzvVhSCVUuUkbq";

    /**
     * Amazon S3 Default Bucket
     */
    const S3_BUCKET = "thewallreport";

    /**
     * Amazon S3 Base Url
     */
    const S3_BASE_URL = '//' . Config::S3_BUCKET . '.s3.amazonaws.com/';

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
     * File Assets Root
     */
    const W_ADMIN_ASSETS = self::W_ROOT . "theme/admin/assets";

    /**
     * File View Root
     */
    const F_VIEW = self::F_ROOT . "App/Views/";

    /**
     * Flow Flow Root
     */
    const F_FLOW_FLOW_ROOT = self::F_ROOT . "public/plugins/flow-flow/flow-flow/";

    /**
     * Front Assets Root
     */
    const W_FRONT_ASSETS = self::W_ROOT . "theme/front/assets/";

    /**
     * Redactor Image File Root
     */
    const F_REDACTOR_IMAGE = self::F_ROOT . "public/uploads/redactor_image/";

    /**
     * Redactor Image Web root
     */
    const W_REDACTOR_IMAGE = self::W_ROOT . "uploads/redactor_image/";

    /**
     * Amazon S3 Profile Image (User Avatar) Directory
     */
    const S3_PROFILE_IMAGE_DIR = 'profile_images';

    /**
     * Amazon S3 Featured Image Directory
     */
    const S3_FEATURE_IMAGE_DIR = 'featured_images';

    /**
     * Amazon S3 Advertisement Image Directory
     */
    const S3_ADVERT_IMAGE_DIR = 'advert_images';

}