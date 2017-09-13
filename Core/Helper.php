<?php
namespace Core;


/**
 * Class Helper
 * @package Core
 */
class Helper
{

    /**
     * @param $length
     * @return string
     */
    public static function randomString($length)
    {
        $key = '';
        $keys = range('a', 'z');

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }
}