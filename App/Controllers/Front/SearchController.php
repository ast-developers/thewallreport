<?php

namespace App\Controllers\Front;
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
        if(!empty($_GET['term'])){
            $term = $_GET['term'];
            $postData = $this->repo->searchForPostData($term);
            $data=[];
            echo json_encode($postData);
        }
    }

}
