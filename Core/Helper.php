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
            $avatar = Config::S3_BASE_URL.Config::S3_PROFILE_IMAGE_DIR . "/" . $user['profile_image'];
        }
        return $avatar;
    }

    public static function getFeaturedImage($image = [])
    {
        $imageUrl = (Config::S3_BASE_URL . Config::S3_FEATURE_IMAGE_DIR . "/" . $image['featured_image']);
        return $imageUrl;
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
            $image = self::getFeaturedImage($cms);
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

    /**
     * @param $description
     * @return mixed
     */
    public  function parsePageDesc($description){
        $catParsedDetail = preg_replace_callback(
            "/\[cat([^\]]*)\]/",
            array($this, 'replacePageShortCode'),
            $description);
        return self::removeShortCodeFromDescription($catParsedDetail);
    }

    /**
     * @param $matches
     * @return string
     */
    public function replacePageShortCode($matches)
    {
        if($matches[1]){
            $cat_string = $matches[1];
            preg_match_all('/id="([^"]+)"/', $cat_string, $id_matches);
            preg_match_all('/count="([^"]+)"/', $cat_string, $count_matches);
            $catData[0]['id'] = $id_matches[1][0];
            $catData[0]['count'] = $count_matches[1][0];
            $featuredPost = Helper::getFeaturedPostByCategoryData($catData);
            return $this->renderCatShortCodePost($featuredPost);
        }
        return '';
    }

    /**
     * @param $featuredPost
     * @return string
     */
    public function renderCatShortCodePost($featuredPost){
        $echo = '';
        if (!empty($featuredPost)) {
            $echo .= '<div class="row">';
                foreach ($featuredPost as $post) {
                    $image = self::getCMSFeaturedImage($post, '360x240');
                    $echo .= '<div class="col-sm-4">
                                <a href="'.Config::W_ROOT . $post['slug'].'" class="model-blocks">
                                    <div class="block-details">
                                        <div class="block-name">'.$post['name'].'</div>
                                        <div class="block-date">'.$post['published_at'].'</div>
                                    </div>
                                    <img width="360" height="490" src="'.$image.'" class="attachment-cb-360-490 size-cb-360-490 wp-post-image">
                                </a>
                            </div>';
                }
            $echo .= '</div>';
        }
        return $echo;
    }
    /**
     * @param $description
     * @return array
     */
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

    /**
     * @param $data
     * @return array
     */
    public static function getFeaturedPostByCategoryData($data){
        $featuredPost = [];
        foreach ($data as $key=>$val){
            $post = new Post();
            $posts = $post->getPostsByCategoryId($val['id'],$val['count']);
                foreach ($posts as $key=>$post){
                    $featuredPost[] = $post;
                }
        }
        return $featuredPost;
    }

    /**
     * @param $description
     * @return mixed
     */
    public static function removeShortCodeFromDescription($description){
        $remove_ff = preg_replace('/\[ff([^\]]*)\]/', '', $description);
        return $remove_ff;
    }
}