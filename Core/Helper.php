<?php
namespace Core;

use App\Config;
use App\Models\Post;
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

    public static function parseCategoryShortCode($description){

        /*
         * This function should return you array consisting id and count of each Cat short code in description.
         * Remember we can have multiple short codes for category in single description. so we need multi dimensional array.
         * e.g. [cat id="13" count="3"] test [cat id="14" count="5"] should return you below output
         */
        $category_array = [];
        preg_match_all("/\[cat([^\]]*)\]/", $description, $cat_matches);
        if($cat_matches[1]){
            foreach($cat_matches[1] as $key=>$cat_string){
                preg_match_all('/id="([^"]+)"/', $cat_string, $id_matches);
                preg_match_all('/count="([^"]+)"/', $cat_string, $count_matches);
                $category_array[$key]['id'] = $id_matches[1][0];
                $category_array[$key]['count'] = $count_matches[1][0];
            }
        }
        return $category_array;
    }

    public static function parseFlowStreamShortCode($description){

        /*
         * This function should return you array consisting ids of each FF short code in description.
         * Remember we can have multiple short codes for FF in single description. so we need multi dimensional array.
         */
        preg_match_all("/\[ff([^\]]*)\]/", $description, $ff_matches);
        $feed_array = [];
        if($ff_matches[1]){
            foreach($ff_matches[1] as $key=>$ff_string){
                preg_match_all('/id="([^"]+)"/', $ff_string, $id_matches);
                $feed_array[$key]['id'] = $id_matches[1][0];
            }
        }
        return $feed_array;

    }

    public static function getFeaturedPostByCategoryData($data){
        $featuredPost = [];
        foreach ($data as $key=>$val){
            $post = new Post();
            $posts = $post->getPostsByCategoryId($val['id'],$val['count']);
                foreach ($posts as $key=>$post){
                    $featuredPost[$post['post_id']]['name'] = $post['name'];
                    $featuredPost[$post['post_id']]['id'] = $post['post_id'];
                    $featuredPost[$post['post_id']]['slug'] = $post['slug'];
                    $featuredPost[$post['post_id']]['published_at'] = $post['published_at'];
                    $featuredPost[$post['post_id']]['featured_image'] = $post['featured_image'];
                }
        }
        return $featuredPost;
    }
    public static function removeShortCodeFromDescription($description){
        $remove_ff = preg_replace('/\[ff([^\]]*)\]/', '', $description);
        $remove_count = preg_replace('/count="([^"]+)"/', '', $remove_ff);
        $remove_cat = preg_replace('/\[cat([^\]]*)\]/', '', $remove_count);
        return $remove_cat;
    }
}