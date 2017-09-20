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
    public function insertPostData($params)
    {
        return $this->model->insertPostData($params);
    }

    /**
     * @param $params
     * @return bool
     */
    public function updatePostData($params)
    {
        return $this->model->updatePostData($params);
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


}
