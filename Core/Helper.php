<?php
namespace Core;

use App\Repositories\Admin\MenuRepository;

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

    /**
     * @param $text
     * @return mixed|string
     */
    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicated - symbols
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * @return array
     */
    public static function getMenus()
    {
        $menuRepo = new MenuRepository();
        $menus = $menuRepo->getMenus();
        return $menus;
    }

    /**
     * @param $status
     * @return string
     */
    public static function getStatus($status)
    {

        switch ($status) {
            case 'active':
                return '<span class="btn green mini active">Active</span>';
            case 'inactive':
                return '<span class="btn red mini active">Inactive</span>';
        }

    }
}