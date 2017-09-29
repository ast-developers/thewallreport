<?php

namespace App\Controllers\Front;

use App\Config;
use App\Repositories\Front\SearchRepository;
use Core\Controller;
use Core\Helper;
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
            $searchResult = ['count' => 0, 'data' => []];
            $term = $_POST['term'];
            $postData = $this->repo->searchForPostData($term);
            $pageData = $this->repo->searchForPageData($term);
            $data = array_merge($postData, $pageData);
            $searchData = array_chunk($data, 3);
            if (!empty($searchData[0])) {
                $searchResult['count'] = count($data);
                foreach ($searchData[0] as $data) {
                    $image = Helper::getCMSFeaturedImage($data, '360x240');
                    $searchResult['data'][$data['id']]['featured_image'] = $image;
                    $searchResult['data'][$data['id']]['slug'] = Config::W_ROOT . $data['slug'];
                    $searchResult['data'][$data['id']]['name'] = $data['name'];
                    $searchResult['data'][$data['id']]['id'] = $data['id'];
                    $searchResult['data'][$data['id']]['published_at'] = (!empty($data['published_at'])) ? date("F j, Y", strtotime($data['published_at'])) : '';
                }
            }
            ?>
            <div class="pt-3 p-md-4 mt-2 d-block text-center">
                <h4 class="found-result">
                    <?php if($searchResult['count']) { ?>
                    FOUND <?php echo $searchResult['count'];?> RESULTS FOR: <span class='search-text'> <?php echo $term;?> </span>
                    <?php } else { ?>
                    NO RESULTS FOUND FOR:<span class='search-text'><?php echo $term;?></span>
                    <?php } ?>
                </h4>
            </div>

            <?php if($searchResult['count']) { ?>
            <div class="row">
                <?php foreach($searchResult['data'] as $id => $row){ ?>
                    <div class='col-lg-4 text-center pb-2'>
                        <a href='<?php echo $row['slug'];?>'>
                            <div class='search-img hidden-md-down'>
                                <img src="<?php echo $row['featured_image'];?>">
                            </div>
                            <h2 class='title'><?php echo $row['name'];?></h2>
                        </a>
                        <span class='search-date d-block'><?php echo $row['published_at'];?></span>
                    </div>
                <?php }?>
            </div>
            <div class="button-area pt-md-5 text-center"><a class='see-all-btn' href='<?php echo \App\Config::W_ROOT.'search/' . $term ?>'>SEE ALL RESULTS</a></div>
            <?php }
        }
    }

    /**
     * @throws \Exception
     */
    public function searchAction()
    {
        $perPage = 1;
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
