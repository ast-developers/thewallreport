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
     * @param $filedata
     * @return array
     */
    public function uploadFeaturedImage($filedata)
    {
        $target_dir = Config::F_FEATURED_IMAGE_ROOT;
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($filedata["name"]);
        if (!file_exists($target_file)) {
            if (move_uploaded_file($filedata["tmp_name"], $target_file)) {
                return ['success' => true, 'filename' => $filedata["name"]];
            } else {
                return ['success' => false, 'messages' => ['Failed to upload Featured Image.']];
            }
        } else {
            return ['success' => true, 'filename' => $filedata["name"]];
        }

    }

    /**
     * @param int $userId
     */
    public function removeFeaturedImage($postid = 0)
    {
        $post = $this->model->getPostById($postid);
        if ($post && $post[0]['featured_image']) {
            $target_dir = Config::F_FEATURED_IMAGE_ROOT;
            $target_file = $target_dir . $post[0]['featured_image'];
            try {
                if (file_exists($target_file)) {
                    unlink($target_file);
                }
            } catch (Exception $e) {

            }
        }
    }


}
