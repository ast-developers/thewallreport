<?php

namespace App\Controllers\Admin;

use App\Repositories\Admin\MenuRepository;
use App\Repositories\Admin\PageRepository;
use App\Repositories\Admin\PostRepository;
use App\Validations\MenuValidation;
use Core\Router;
use \Core\View;


/**
 * Class MenuController
 * @package App\Controllers\Admin
 */
class MenuController extends \Core\Controller
{


    /**
     * @var MenuRepository
     */
    protected $repo;

    /**
     * @var MenuValidation
     */
    protected $validate;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var PostRepository
     */
    protected $post_repo;

    /**
     * @var PageRepository
     */
    protected $page_repo;


    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->validate = new MenuValidation();
        $this->params = $params;
        $this->repo = new MenuRepository();
        $this->post_repo = new PostRepository();
        $this->page_repo = new PageRepository();
    }

    /**
     * @throws \Exception
     */
    public function storeAction()
    {
        if (isset($_POST['submit'])) {
            $formValid = $this->validate->validate();
            if (!$formValid['success']) {
                if (!empty($_POST['id'])) {
                    return Router::redirectTo('admin/edit-menu/' . $_POST['id'], $formValid['messages'], 'alert-danger');
                } else {
                    return Router::redirectTo('admin/add-menu', $formValid['messages'], 'alert-danger');
                }
            }
            $message = ['Something went wrong. Please try again later.'];
            $messageClass = 'alert-danger';
            if (!empty($_POST['id'])) {
                $menu_id = $_POST['id'];
                if ($this->repo->updateMenuData($_POST)) {
                    $message = ['Menu updated successfully.'];
                    $messageClass = 'alert-success';
                }
            } else {
                if ($menu_id = $this->repo->insertMenuData($_POST)) {
                    $message = ['Menu added successfully.'];
                    $messageClass = 'alert-success';
                }
            }

            return Router::redirectTo('admin/edit-menu/' . $menu_id, $message, $messageClass);
        }
        $allPosts = $this->post_repo->getAll();
        $allPages = $this->page_repo->getAll();

        if (!empty($this->params['id'])) {
            $menu = $this->repo->getMenuById($this->params['id']);
            return View::render('Admin/Menu/addmenu.php', ['menu' => $menu[0], 'posts' => $allPosts, 'pages' => $allPages]);
        }
        View::render('Admin/Menu/addmenu.php', ['posts' => $allPosts, 'pages' => $allPages]);
    }

    /**
     * @throws \Exception
     */
    public function getMenus()
    {

        View::render('Admin/Menu/listmenu.php');
    }

    /**
     *
     */
    public function menuPaginate()
    {
        return $this->repo->getMenuAjaxPagination($_REQUEST);
    }

    /**
     *
     */
    public function bulkDeleteMenu()
    {
        $this->repo->bulkDeleteMenus($_REQUEST);
    }

}
