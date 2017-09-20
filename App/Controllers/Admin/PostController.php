<?php

namespace App\Controllers\Admin;

use App\Config;
use App\Models\Category;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\PostRepository;
use App\Repositories\Admin\TagRepository;
use App\Validations\CategoryValidation;
use App\Validations\PostValidation;
use Core\Router;
use \Core\View;


/**
 * Class PostController
 * @package App\Controllers\Admin
 */
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
     * @var CategoryRepository
     */
    protected $category_repo;
    /**
     * @var TagRepository
     */
    protected $tag_repo;

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
        $this->category_repo = new CategoryRepository();
        $this->tag_repo = new TagRepository();
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        if (isset($_POST['submit'])) {
            $formValid = $this->validate->validate();
            if (!$formValid['success']) {
                return Router::redirectTo('admin/categories', $formValid['messages'], 'alert-danger');
            }
            $message = ['Something went wrong. Please try again later.'];
            $messageClass = 'alert-danger';
            if (!empty($_POST['id'])) {
                $post_id = $_POST['id'];
                if ($this->repo->updatePostData($_POST)) {
                    $message = ['Post updated successfully.'];
                    $messageClass = 'alert-success';
                }
            } else {
                if ($post_id = $this->repo->insertPostData($_POST)) {
                    $message = ['Post added successfully.'];
                    $messageClass = 'alert-success';
                }
            }

            return Router::redirectTo('admin/editpost/'.$post_id, $message, $messageClass);
        }
        $parent_cat = $this->category_repo->getParentCategories();
        $tags = $this->tag_repo->getTags();
        $alltagData = [];
        if (!empty($tags)) {
            if (!empty($this->params['id'])) {
                $existing_tags = $this->repo->getPostsTagsById($this->params['id']);
                    foreach ($tags as $tag) {
                        if(!in_array($tag['name'],explode(',',$existing_tags))){
                            $alltagData[] = "'" . $tag['name'] . "'";
                        }
                    }
            }else{
                foreach ($tags as $tag) {
                    $alltagData[] = "'" . $tag['name'] . "'";
                }
            }
        }
        if (!empty($this->params['id'])) {
            $post = $this->repo->getPostById($this->params['id']);
            $post_cat = $this->repo->getPostsCategoriesById($this->params['id']);
            $post_tags = $this->repo->getPostsTagsById($this->params['id']);
            return View::render('Admin/Post/addpost.php', ['post' => $post[0], 'parent_cat' => $parent_cat, 'post_cat' => $post_cat, 'tags' => implode(',', $alltagData), 'post_tags' => $post_tags]);
        }
        View::render('Admin/Post/addpost.php', ['parent_cat' => $parent_cat, 'tags' => implode(',', $alltagData)]);
    }

    /**
     *
     */
    public function uploadImage()
    {

        $dir = Config::F_UPLOAD_IMAGE;

        $_FILES['file']['type'] = strtolower($_FILES['file']['type']);

        if ($_FILES['file']['type'] == 'image/png'
            || $_FILES['file']['type'] == 'image/jpg'
            || $_FILES['file']['type'] == 'image/gif'
            || $_FILES['file']['type'] == 'image/jpeg'
            || $_FILES['file']['type'] == 'image/pjpeg'
        ) {
            // setting file's mysterious name
            $filename = md5(date('YmdHis')) . '.jpg';
            $file = $dir . $filename;

            // copying
            move_uploaded_file($_FILES['file']['tmp_name'], $file);

            // displaying file
            $array = array(
                'url' => Config::W_UPLOAD_IMAGE . $filename,
                'id' => 123
            );

            echo stripslashes(json_encode($array));

        }
    }

    /**
     * @throws \Exception
     */
    public function getPosts()
    {

        View::render('Admin/Post/listpost.php');
    }

    /**
     *
     */
    public function postPaginate()
    {
        return $this->repo->getPostAjaxPagination($_REQUEST);
    }

    /**
     *
     */
    public function bulkDeletepost()
    {
        $this->repo->bulkDeletePost($_REQUEST);
    }

}
