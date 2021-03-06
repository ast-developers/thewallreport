<?php

namespace App\Controllers\Admin;

use App\Config;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\PostRepository;
use App\Repositories\Admin\TagRepository;
use App\Validations\CategoryValidation;
use App\Validations\PostValidation;
use Core\Router;
use Core\View;
use Core\Controller;


/**
 * Class PostController
 * @package App\Controllers\Admin
 */
class PostController extends Controller
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
    public function storeAction()
    {
        if (isset($_POST['submit']) || isset($_POST['status_submit'])) {
            $formValid = $this->validate->validate();
            if (!$formValid['success']) {
                if (!empty($_POST['id'])) {
                    return Router::redirectTo('admin/edit-post/' . $_POST['id'], $formValid['messages'], 'alert-danger');
                } else {
                    return Router::redirectTo('admin/add-post', $formValid['messages'], 'alert-danger');
                }
            }
            // Case 1: Editing Page, Image has been deleted
            $removedExistingImage = 0;
            $filename = null;
            if (!empty($_POST['id']) && !empty($_POST['delete_featured_image']) && $_POST['delete_featured_image'] == 1) {
                $this->repo->removeFeaturedImage($_POST['id']);
                $removedExistingImage = 1;
            }
            // Case2: Image has been uploaded
            if (!empty($_FILES['featured_image']['name'])) {
                // DELETE OLD Featured Image
                if (!empty($_POST['id']) && !$removedExistingImage) {
                    $this->repo->removeFeaturedImage($_POST['id']);
                }
                // UPLOAD NEW Featured Image
                $imageUpload = $this->repo->uploadFeaturedImage($_FILES['featured_image']);
                $filename = $imageUpload['filename'];
                if (!$imageUpload['success']) {
                    $message = $imageUpload['messages'];
                    if (!empty($_POST['id'])) {
                        return Router::redirectTo('admin/edit-post/' . $_POST['id'], $message, 'alert-danger');
                    } else {
                        return Router::redirectTo('admin/add-post', $message, 'alert-danger');
                    }
                }
            }
            $message = ['Something went wrong. Please try again later.'];
            $messageClass = 'alert-danger';
            if (!empty($_POST['id'])) {
                $post_id = $_POST['id'];
                $file = $this->repo->getPostById($_POST['id']);
                $featured_image = (!$removedExistingImage && is_null($filename)) ? $file[0]['featured_image'] : $filename;
                if ($this->repo->updatePostData($_POST, $featured_image)) {
                    $message = ['Post updated successfully.'];
                    $messageClass = 'alert-success';
                }
            } else {
                if ($post_id = $this->repo->insertPostData($_POST, $filename)) {
                    $message = ['Post added successfully.'];
                    $messageClass = 'alert-success';
                }
            }

            return Router::redirectTo('admin/edit-post/' . $post_id, $message, $messageClass);
        }
        $parent_cat = $this->category_repo->getParentCategories();
        $tags = $this->tag_repo->getTags();
        $alltagData = [];
        if (!empty($tags)) {
            if (!empty($this->params['id'])) {
                $existing_tags = $this->repo->getPostsTagsById($this->params['id']);
                foreach ($tags as $tag) {
                    if (!in_array($tag['name'], explode(',', $existing_tags))) {
                        $alltagData[] = "'" . $tag['name'] . "'";
                    }
                }
            } else {
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
     * Upload Redactor Image
     */
    public function uploadImage()
    {

        $_FILES['file']['type'] = strtolower($_FILES['file']['type']);

        if ($_FILES['file']['type'] == 'image/png'
            || $_FILES['file']['type'] == 'image/jpg'
            || $_FILES['file']['type'] == 'image/gif'
            || $_FILES['file']['type'] == 'image/jpeg'
            || $_FILES['file']['type'] == 'image/pjpeg'
        ) {
            $fileData = $_FILES['file'];
            $upload   = $this->repo->uploadRedactorImage($fileData);
            if ($upload['success']) {
                $array = array(
                    'url' => (Config::S3_BASE_URL . Config::S3_REDACTOR_IMAGE_DIR . "/" . $upload['filename']),
                    'id'  => 123
                );
                echo stripslashes(json_encode($array));
            }
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
    public function bulkDeletePost()
    {
        $this->repo->bulkDeletePost($_REQUEST);
    }

}
