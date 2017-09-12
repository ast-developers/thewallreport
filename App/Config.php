<?php

namespace App;

/**
 * Class Config
 * Application configuration
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
     * Website Root
     */
    const W_ROOT="http://local.thewall.report/";

    /**
     * File Root
     */
    const F_ROOT="/home/devendra-bhati/public_html/thewallreport/";

    /**
     * File Views Root
     */
    const F_VIEW =  self::F_ROOT."App/Views/";

}
