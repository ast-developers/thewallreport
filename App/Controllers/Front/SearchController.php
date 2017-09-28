<?php

namespace App\Controllers\Front;

use App\Config;
use App\Repositories\Front\SearchRepository;
use Core\Controller;
use Core\View;

/**
 * Class SearchController
 * @package App\Controllers\Front
 */
class SearchController extends Controller
{
    /**
     * @var array
     */
    public $params;

    /**
     * @param array $params
     */
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
        if (!empty($_POST['term'])) {
            $searchResult = [];
            $term = $_POST['term'];
            $postData = $this->repo->searchForPostData($term);
            $pageData = $this->repo->searchForPageData($term);
            $data = array_merge($postData, $pageData);
            $searchData = array_chunk($data, 3);
            if (!empty($searchData[0])) {
                $searchResult['count'] = count($data);
                foreach ($searchData[0] as $data) {
                    $image = (!empty($data['featured_image'])) ? Config::W_FEATURED_IMAGE_ROOT . $data['featured_image'] : 'http://thewall.report/wp-content/themes/15zine/library/images/placeholders/placeholder-260x170.png';
                    $searchResult['data'][$data['id']]['featured_image'] = $image;
                    $searchResult['data'][$data['id']]['slug'] = Config::W_ROOT . $data['slug'];
                    $searchResult['data'][$data['id']]['name'] = $data['name'];
                    $searchResult['data'][$data['id']]['id'] = $data['id'];
                    $searchResult['data'][$data['id']]['published_at'] = (!empty($data['published_at'])) ? date("F j, Y", strtotime($data['published_at'])) : '';
                }
            }
            echo json_encode($searchResult);
        }
    }

    /**
     * @throws \Exception
     */
    public function searchAction()
    {
        $perPage = 10;
        if (!empty($this->params['s'])) {
            $term = $this->params['s'];

            $postData = $this->repo->searchForPostData($term);
            $pageData = $this->repo->searchForPageData($term);
            $data = array_merge($postData, $pageData);
            $results = array_chunk($data, $perPage);
            $totalPages = count($results);
            if (!empty($this->params['p'])) {
                $key = (!empty($this->params['p'])) ? $this->params['p'] : 0;
                $resultData = (isset($results[$key - 1])) ? $results[$key - 1] : [];
                $prev = (!empty($this->params['p'])) ? $this->params['p'] - 1 : '';
                $next = (!empty($this->params['p'])) ? $this->params['p'] + 1 : '';
                if (!empty($resultData)) {
                    return View::render('Front/search_list.php', ['data' => $resultData, 'current' => $key, 'search_text' => $this->params['s'], 'prev' => $prev, 'next' => $next, 'total_pages' => $totalPages]);
                } else {
                    return View::render('Front/error.php');
                }
            } else {
                $prev = ($totalPages > 1) ? 1 : '';
                $next = ($totalPages > 1) ? 2 : '';
                $key = 0;
                $resultData = (isset($results[$key])) ? $results[$key] : [];
                if (!empty($resultData)) {
                    return View::render('Front/search_list.php', ['data' => $resultData, 'search_text' => $this->params['s'], 'prev' => $prev, 'next' => $next, 'total_pages' => $totalPages, 'current' => $key + 1]);
                } else {
                    return View::render('Front/error.php');
                }
            }


        }
    }

}
