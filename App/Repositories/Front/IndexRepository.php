<?php

namespace App\Repositories\Front;


use App\Models\Menu;
use App\Repositories\Admin\MenuRepository;
use App\Repositories\Admin\PageRepository;
use App\Repositories\Admin\PostRepository;

/**
 * Class IndexRepository
 * @package App\Repositories\Front
 */
class IndexRepository
{

    /**
     * @var Menu
     */
    public $model;
    /**
     * @var MenuRepository
     */
    protected $menu_repo;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new Menu();
        $this->menu_repo = new MenuRepository();
        $this->page_repo = new PageRepository();
        $this->post_repo = new PostRepository();
    }

    /**
     * @return array
     */
    public function getMenus()
    {
        $allMenu = $this->menu_repo->getAll();
        $menuData = [];
        foreach ($allMenu as $value) {

            $menuData[$value['id']]['name'] = $value['name'];
            if ($value['type'] == 1) {
                $data = $this->post_repo->getPostById($value['link']);
                $menuData[$value['id']]['slug'] = $data['0']['slug'];
            } elseif ($value['type'] == 2) {
                $data = $this->page_repo->getPageById($value['link']);
                $menuData[$value['id']]['slug'] = $data['0']['slug'];
            } elseif ($value['type'] == 3) {
                $menuData[$value['id']]['slug'] = $value['link'];
            }
        }
        return $menuData;

    }


}
