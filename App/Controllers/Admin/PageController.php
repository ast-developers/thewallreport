<?php

namespace App\Controllers\Admin;

use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\PageRepository;
use App\Repositories\Admin\TagRepository;
use App\Validations\CategoryValidation;
use App\Validations\PageValidation;
use Core\Router;
use \Core\View;


class PageController extends \Core\Controller
{


    protected $repo;

    protected $validate;

    protected $params;

    protected $category_repo;

    protected $tag_repo;

    public function __construct($params = [])
    {
        $this->validate = new PageValidation();
        $this->params = $params;
        $this->repo = new PageRepository();
    }

    public function storeAction()
    {
        if (isset($_POST['submit'])) {
            $formValid = $this->validate->validate();
            if (!$formValid['success']) {
                if (!empty($_POST['id'])) {
                    return Router::redirectTo('admin/edit-page/'.$_POST['id'], $formValid['messages'], 'alert-danger');
                }else{
                    return Router::redirectTo('admin/add-page', $formValid['messages'], 'alert-danger');
                }
            }
            $message = ['Something went wrong. Please try again later.'];
            $messageClass = 'alert-danger';
            if (!empty($_POST['id'])) {
                $page_id = $_POST['id'];
                if ($this->repo->updatePageData($_POST)) {
                    $message = ['Page updated successfully.'];
                    $messageClass = 'alert-success';
                }
            } else {
                if ($page_id = $this->repo->insertPageData($_POST)) {
                    $message = ['Page added successfully.'];
                    $messageClass = 'alert-success';
                }
            }

            return Router::redirectTo('admin/edit-page/' . $page_id, $message, $messageClass);
        }
        if (!empty($this->params['id'])) {
            $page = $this->repo->getPageById($this->params['id']);
            return View::render('Admin/Page/addpage.php', ['page' => $page[0]]);
        }
        View::render('Admin/Page/addpage.php');
    }

    public function getPages()
    {

        View::render('Admin/Page/listpage.php');
    }

    public function pagePaginate()
    {
        return $this->repo->getPageAjaxPagination($_REQUEST);
    }

    public function bulkDeletePage()
    {
        $this->repo->bulkDeletePage($_REQUEST);
    }

}
