<?php

namespace App\Repositories\Admin;

use App\Config;
use App\Models\PasswordReminder;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Core\Helper;
use Core\Mail;
use Exception;
use Core\S3;


/**
 * Class UserRepository
 * @package App\Repositories\Admin
 */
class PostRepository
{
    /**
     * @var User
     */
    public $model;
    /**
     * @var PasswordReminder
     */
    public $passwordReminderModel;
    /**
     * @var Role
     */
    public $rolmodel;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new Post();
    }

    /**
     * @param $params
     * @return bool
     */
    public function insertPostData($params, $filename)
    {
        return $this->model->insertPostData($params, $filename);
    }

    /**
     * @param $params
     * @return bool
     */
    public function updatePostData($params, $featured_image)
    {
        return $this->model->updatePostData($params, $featured_image);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getPostById($id)
    {
        return $this->model->getPostById($id);
    }

    /**
     * @param $params
     */
    public function getPostAjaxPagination($params)
    {
        return $this->model->getPostAjaxPagination($params);
    }

    /**
     * @param $params
     */
    public function bulkDeletePost($params)
    {
        $page_ids = explode(',', $params['data_ids']);
        foreach ($page_ids as $id) {
            $this->removeFeaturedImage($id);
        }
        return $this->model->bulkDeletePosts($params);
    }

    /**
     * @param $id
     * @return array
     */
    public function getPostsCategoriesById($id)
    {
        $data = $this->model->getPostsCategoriesById($id);
        $categories = [];
        if (!empty($data)) {
            foreach ($data as $value) {
                $categories[] = $value['category_id'];
            }
        }
        return $categories;
    }


    /**
     * @param $id
     * @return string
     */
    public function getPostsTagsById($id)
    {
        $data = $this->model->getPostsTagsById($id);
        $tags = [];
        if (!empty($data)) {
            foreach ($data as $value) {
                $tags[] = $value['name'];
            }
        }
        return implode(',', $tags);
    }

    /**
     * @return bool
     */
    public function getAll()
    {

        return $this->model->getAll();

    }

    /**
     * @param $fileData
     * @return array
     */
    public function uploadFeaturedImage($fileData)
    {
        $filePath = $fileData['tmp_name'];
        $name     = time() . "_" . basename($fileData["name"]);
        $fileName = Config::S3_FEATURE_IMAGE_DIR . "/" . $name;
        $s3       = new S3();
        $upload   = $s3->uploadObject($filePath, $fileName);
        if ($upload['success']) {
            return ['success' => true, 'filename' => $name];
        } else {
            return ['success' => false, 'messages' => ['Failed to upload Featured Image.']];
        }
    }

    /**
     * @param int $postid
     * @return array
     */
    public function removeFeaturedImage($postid = 0)
    {
        $post = $this->model->getPostById($postid);
        if ($post && $post[0]['featured_image']) {
            $fileName = Config::S3_FEATURE_IMAGE_DIR . "/" . $post[0]['featured_image'];
            $s3       = new S3();
            $delete   = $s3->deleteObject($fileName);
            if ($delete['success']) {
                return ['success' => true];
            } else {
                return ['success' => false, 'messages' => ['Failed to delete Featured Image.']];
            }
        }
    }


}
