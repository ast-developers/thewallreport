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

    public function getPostById($id)
    {
        return $this->model->getPostById($id);
    }

}
