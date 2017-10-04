<?php

namespace App\Controllers\Admin;

use App\Repositories\Admin\AdvertiseRepository;
use App\Validations\AdvertiseValidation;
use Core\Router;
use Core\View;
use Core\Controller;


/**
 * Class AdvertiseController
 * @package App\Controllers\Admin
 */
class AdvertiseController extends Controller
{

    /**
     * @var AdvertiseRepository
     */
    protected $repo;


    /**
     * @var AdvertiseValidation
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
        $this->validate = new AdvertiseValidation();
        $this->params = $params;
        $this->repo = new AdvertiseRepository();
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
                    return Router::redirectTo('admin/edit-advertise/' . $_POST['id'], $formValid['messages'], 'alert-danger');
                } else {
                    return Router::redirectTo('admin/add-advertise', $formValid['messages'], 'alert-danger');
                }
            }
            // Case 1: Editing Page, Image has been deleted
            $removedExistingImage = 0;
            $filename = null;
            if (!empty($_POST['id']) && !empty($_POST['delete_banner_image']) && $_POST['delete_banner_image'] == 1) {
                $this->repo->removeBannerImage($_POST['id']);
                $removedExistingImage = 1;
            }
            // Case2: Image has been uploaded
            if (!empty($_FILES['banner_image']['name'])) {
                // DELETE OLD Banner Image
                if (!empty($_POST['id']) && !$removedExistingImage) {
                    $this->repo->removeBannerImage($_POST['id']);
                }
                // UPLOAD NEW Banner Image
                $imageUpload = $this->repo->uploadBannerImage($_FILES['banner_image']);
                $filename = $imageUpload['filename'];
                if (!$imageUpload['success']) {
                    $message = $imageUpload['messages'];
                    if (!empty($_POST['id'])) {
                        return Router::redirectTo('admin/edit-advertise/' . $_POST['id'], $message, 'alert-danger');
                    } else {
                        return Router::redirectTo('admin/add-advertise', $message, 'alert-danger');
                    }
                }
            }
            $message = ['Something went wrong. Please try again later.'];
            $messageClass = 'alert-danger';
            if (!empty($_POST['id'])) {
                $post_id = $_POST['id'];
                $file = $this->repo->getAdvertiseById($_POST['id']);
                $banner_image = (!$removedExistingImage && is_null($filename)) ? $file[0]['banner_image'] : $filename;
                if ($this->repo->updateAdvertiseData($_POST, $banner_image)) {
                    $message = ['Advertise updated successfully.'];
                    $messageClass = 'alert-success';
                }
            } else {
                if ($post_id = $this->repo->insertAdvertiseData($_POST, $filename)) {
                    $message = ['Advertise added successfully.'];
                    $messageClass = 'alert-success';
                }
            }

            return Router::redirectTo('admin/edit-advertise/' . $post_id, $message, $messageClass);
        } else {

            if (!empty($this->params['id'])) {
                $advertise = $this->repo->getAdvertiseById($this->params['id']);
                return View::render('Admin/Advertise/addadvertise.php', ['advertise' => $advertise[0]]);
            }
            View::render('Admin/Advertise/addadvertise.php');
        }

    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        View::render('Admin/Advertise/listadvertise.php');
    }

    /**
     *
     */
    public function advertisePaginate()
    {
        return $this->repo->getAdvertiseAjaxPagination($_REQUEST);
    }

    /**
     *
     */
    public function bulkDeleteAdvertise()
    {
        $this->repo->bulkDeleteAdvertise($_REQUEST);
    }


}
