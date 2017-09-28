<?php

namespace App\Controllers\Front;
use App\Config;
use App\Repositories\Front\SearchRepository;
use Core\Controller;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->repo = new SearchRepository();
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        if(!empty($_POST['term'])){
            $searchResult = [];
            $term = $_POST['term'];
            $postData = $this->repo->searchForPostData($term);
            $pageData = $this->repo->searchForPageData($term);
            $data = array_merge($postData,$pageData);
            $searchData = array_chunk($data,3);
            if(!empty($searchData[0])){
                $searchResult['count'] = count($data);
                foreach($searchData[0] as $data){
                    $image = (!empty($data['featured_image'])) ? Config::W_FEATURED_IMAGE_ROOT.$data['featured_image'] : 'http://thewall.report/wp-content/themes/15zine/library/images/placeholders/placeholder-260x170.png';
                    $searchResult[$data['id']]['featured_image'] = $image;
                    $searchResult[$data['id']]['slug'] = Config::W_ROOT.$data['slug'];
                    $searchResult[$data['id']]['name'] = $data['name'];
                    $searchResult[$data['id']]['id'] = $data['id'];
                }
            }
            echo json_encode($searchResult);
        }
    }

}
