<?php

namespace App\Controllers\Admin;

use App\Config;
use App\Models\Category;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\PostRepository;
use App\Validations\CategoryValidation;
use App\Validations\PostValidation;
use Core\Router;
use \Core\View;



class PostController extends \Core\Controller
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
        $this->validate = new PostValidation();
        $this->params = $params;
        $this->repo = new PostRepository();
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        if(isset($_POST['submit'])){
            $formValid = $this->validate->validate();
            if (!$formValid['success']) {
                return Router::redirectTo('admin/categories', $formValid['messages'], 'alert-danger');
            }
            $message = ['Something went wrong. Please try again later.'];
            $messageClass = 'alert-danger';
            if (!empty($_POST['id'])) {
                if ($this->repo->updatePostData($_POST)) {
                    $message = ['Post updated successfully.'];
                    $messageClass = 'alert-success';
                }
            } else {
                if ($this->repo->insertPostData($_POST)) {
                    $message = ['Post added successfully.'];
                    $messageClass = 'alert-success';
                }
            }

            return Router::redirectTo('admin/addpost', $message, $messageClass);
        }
        if (!empty($this->params['id'])) {
            $post = $this->repo->getPostById($this->params['id']);
            return View::render('Admin/Post/addpost.php', ['post' => $post[0]]);
        }
        View::render('Admin/Post/addpost.php');
    }

    public function uploadImage(){

        $dir = Config::F_UPLOAD_IMAGE;

        $_FILES['file']['type'] = strtolower($_FILES['file']['type']);

        if ($_FILES['file']['type'] == 'image/png'
            || $_FILES['file']['type'] == 'image/jpg'
            || $_FILES['file']['type'] == 'image/gif'
            || $_FILES['file']['type'] == 'image/jpeg'
            || $_FILES['file']['type'] == 'image/pjpeg')
        {
            // setting file's mysterious name
            $filename = md5(date('YmdHis')).'.jpg';
            $file = $dir.$filename;

            // copying
            move_uploaded_file($_FILES['file']['tmp_name'], $file);

            // displaying file
            $array = array(
                'url' => Config::W_UPLOAD_IMAGE.$filename,
                'id' => 123
            );

            echo stripslashes(json_encode($array));

        }
    }

}
