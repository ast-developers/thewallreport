<?php

namespace App\Controllers\Front;
use App\Config;
use App\Repositories\Front\SearchRepository;
use Core\Controller;
use Core\View;

class SearchController extends Controller
{
    public $params;

    public function __construct($params = [])
    {
        $this->params = $params;
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
                    $searchResult['data'][$data['id']]['featured_image'] = $image;
                    $searchResult['data'][$data['id']]['slug'] = Config::W_ROOT.$data['slug'];
                    $searchResult['data'][$data['id']]['name'] = $data['name'];
                    $searchResult['data'][$data['id']]['id'] = $data['id'];
                }
            }
            echo json_encode($searchResult);
         }
    }

    public function searchAction(){

        if(!empty($this->params['s'])){
            $term = $this->params['s'];
            $postData = $this->repo->searchForPostData($term);
            $post_data = [];
            if(!empty($postData)){
                foreach($postData as $post){
                    $tags = $this->repo->getPostTagsByID($post['id']);
                    $categories = $this->repo->getCategoriesById($post['id']);
                    $post_data[$post['id']] = $post;
                    $post_data[$post['id']]['tags'] = $tags;
                    $post_data[$post['id']]['categories'] = $categories;
                }
            } print_r($postData);die;
            $pageData = $this->repo->searchForPageData($term);
            $data = array_merge($post_data,$pageData);
            return View::render('Front/search_list.php', ['data' => $data,'search_text'=>$this->params['s']]);
        }
    }

}
