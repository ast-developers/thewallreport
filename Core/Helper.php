<?php
namespace Core;

use App\Config;
use App\Repositories\Admin\MenuRepository;
use App\Repositories\Front\IndexRepository;

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

    /**
     * @return bool
     */
    public static function getFeaturedBanners()
    {
        $repo = new IndexRepository();
        return $repo->getFeaturedBanners();
    }

    /**
     * Get User Avatar
     * @param array $user
     * @param string $size
     * @return string
     */
    public static function getUserAvatar($user = [], $size = 'small')
    {
        switch ($size) {
            case 'small':
                $avatar = Config::W_ADMIN_ASSETS . '/img/avatar.png';
                break;
            case 'medium':
                $avatar = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
                break;
            case 'actual':
                $avatar = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
                break;
            default:
                $avatar = Config::W_ADMIN_ASSETS . '/img/avatar.png';
                break;
        }
        if (!empty($user['profile_image'])) {
            $avatar = \App\Config::W_USER_AVATAR_ROOT . $user['profile_image'];
        }
        return $avatar;
    }

    /**
     * @param array $cms
     * @param string $size
     * @return string
     */
    public static function getCMSFeaturedImage($cms = [], $size = '100x65')
    {
        $image = Config::W_FRONT_ASSETS . "images/placeholders/placeholder-$size.png";
        if (!empty($cms['featured_image'])) {
            $image = Config::W_FEATURED_IMAGE_ROOT . $cms['featured_image'];
        }
        return $image;
    }

    /**
     * @param $string
     * @param int $limit
     * @return string
     */
    public static function getShortDescription($string, $limit = 100)
    {
        return (!empty($string)) ? substr(strip_tags($string), 0, $limit) . '...' : '...';
    }
}