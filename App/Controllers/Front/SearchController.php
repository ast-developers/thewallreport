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
        $perPage = 2;
        if(!empty($this->params['s'])){
            $key = (!empty($this->params['p'])) ? $this->params['p'] : 0;
            $index = ($key!=0) ? $key-1 : 0;
            $term = $this->params['s'];
            $postData = $this->repo->searchForPostData($term);
            $pageData = $this->repo->searchForPageData($term);
            $data = array_merge($postData,$pageData);
            $results = array_chunk($data,$perPage);
            $totalPages = count($results);
            $resultData = (isset($results[$key-1])) ? $results[$key-1] : [];
            if(!empty($resultData)){
                return View::render('Front/search_list.php', ['data' => $resultData,'search_text'=>$this->params['s'],'total_pages'=>$totalPages]);
            }else{
                return View::render('Front/error.php');
            }

        }
    }

}
