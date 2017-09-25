<?php

namespace App\Controllers\Admin;

use App\Repositories\Admin\PageRepository;
use App\Validations\PageValidation;
use Core\Router;
use Core\View;
use Core\Controller;

/**
 * Class PageController
 * @package App\Controllers\Admin
 */
class PageController extends Controller
{


    /**
     * @var PageRepository
     */
    protected $repo;

    /**
     * @var PageValidation
     */
    protected $validate;

    /**
     * @var array
     */
    protected $params;

    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->validate = new PageValidation();
        $this->params = $params;
        $this->repo = new PageRepository();
    }

    /**
     * @throws \Exception
     */
    public function storeAction()
    {
        if (isset($_POST['submit']) || isset($_POST['pending_submit']) || isset($_POST['draft_submit']) || isset($_POST['publish_submit'])) {
            $formValid = $this->validate->validate();
            if (!$formValid['success']) {
                if (!empty($_POST['id'])) {
                    return Router::redirectTo('admin/edit-page/' . $_POST['id'], $formValid['messages'], 'alert-danger');
                } else {
                    return Router::redirectTo('admin/add-page', $formValid['messages'], 'alert-danger');
                }
            }
            if (!empty($_FILES['featured_image']['name'])) {
                // DELETE OLD Featured Image
                if (!empty($_POST['id'])) {
                    $this->repo->removeFeaturedImage($_POST['id']);
                }
                // UPLOAD NEW Featured Image
                $imageUpload = $this->repo->uploadFeaturedImage($_FILES['featured_image']);
                if (!$imageUpload['success']) {
                    $message = $imageUpload['messages'];
                    if (!empty($_POST['id'])) {
                        return Router::redirectTo('admin/edit-page/' . $_POST['id'], $message, 'alert-danger');
                    } else {
                        return Router::redirectTo('admin/add-page', $message, 'alert-danger');
                    }
                }
            }
            $uploads = (!empty($_FILES['featured_image']['name'])) ? $imageUpload['filename'] : NULL;
            $filename = (!empty($_POST['id']) && empty($_FILES['featured_image']['name'])) ? NULL : $uploads;

            $message = ['Something went wrong. Please try again later.'];
            $messageClass = 'alert-danger';
            if (!empty($_POST['id'])) {
                $page_id = $_POST['id'];
                $file = $this->repo->getPageById($_POST['id']);
                $featured_image = (is_null($filename)) ? $file[0]['featured_image'] : $filename;
                if ($this->repo->updatePageData($_POST, $featured_image)) {
                    $message = ['Page updated successfully.'];
                    $messageClass = 'alert-success';
                }
            } else {
                if ($page_id = $this->repo->insertPageData($_POST, $filename)) {
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

    /**
     * @throws \Exception
     */
    public function getPages()
    {
        View::render('Admin/Page/listpage.php');
    }

    /**
     *
     */
    public function pagePaginate()
    {
        return $this->repo->getPageAjaxPagination($_REQUEST);
    }

    /**
     *
     */
    public function bulkDeletePage()
    {
        $this->repo->bulkDeletePage($_REQUEST);
    }

}
