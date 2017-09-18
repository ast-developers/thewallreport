<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use App\Repositories\Admin\CategoryRepository;
use App\Validations\CategoryValidation;
use Core\Router;
use \Core\View;


/**
 * Class CategoryController
 * @package App\Controllers\Admin
 */
class CategoryController extends \Core\Controller
{

    /**
     * @var CategoryRepository
     */
    protected $repo;
    /**
     * @var CategoryValidation
     */
    protected $validate;
    /**
     * @var array
     */
    protected $params;

    /**
     * Show the index page
     *
     * @return void
     */
    public function __construct($params = [])
    {
        $this->repo = new CategoryRepository();
        $this->validate = new CategoryValidation();
        $this->params = $params;
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        $parent_cat = $this->repo->getParentCategories();
        if (!empty($this->params['id'])) {
            $category = $this->repo->getCategoryById($this->params['id']);
            return View::render('Admin/Category/index.php', ['parent_cat' => $parent_cat, 'category' => $category[0]]);
        }

        View::render('Admin/Category/index.php', ['parent_cat' => $parent_cat]);
    }

    /**
     *
     */
    public function categoryPaginate()
    {
        return $this->repo->getCategoryAjaxPagination($_REQUEST);
    }

    /**
     *
     */
    public function bulkDeleteCategories()
    {
        $this->repo->bulkDeleteCategories($_REQUEST);
    }

    /**
     *
     */
    public function addCategory()
    {
        if (isset($_POST['submit'])) {
            $formValid = $this->validate->addCategoryValidation();
            if (!$formValid['success']) {
                return Router::redirectTo('admin/categories', $formValid['messages'], 'alert-danger');
            }
            $message = ['Something went wrong. Please try again later.'];
            $messageClass = 'alert-danger';
            if ($_POST['id']) {
                if ($this->repo->updateCategoryData($_POST)) {
                    $message = ['Category updated successfully.'];
                    $messageClass = 'alert-success';
                }
            } else {
                if ($this->repo->insertCategoryData($_POST)) {
                    $message = ['Category added successfully.'];
                    $messageClass = 'alert-success';
                }
            }

            Router::redirectTo('admin/categories', $message, $messageClass);

        } else {
            return Router::redirectTo('admin/categories', ['Oops, something went wrong'], 'alert-danger');
        }

    }

}
