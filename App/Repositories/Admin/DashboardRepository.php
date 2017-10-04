<?php

namespace App\Repositories\Admin;

use App\Config;
use App\Models\User;
use App\Models\Post;
use App\Models\Page;


/**
 * Class DashboardRepository
 * @package App\Repositories\Admin
 */
class DashboardRepository
{
    /**
     * @var User
     */
    public $userModel;
    /**
     * @var Post
     */
    public $postModel;
    /**
     * @var Page
     */
    public $pageModel;

    /**
     * DashboardRepository constructor.
     */
    public function __construct()
    {
        $this->userModel = new User();
        $this->postModel = new Post();
        $this->pageModel = new Page();
    }

    /**
     * @return array
     */
    public function getDashboardData()
    {
        $users = $this->userModel->getAllUsersCount();
        $posts = $this->postModel->getAllPostsCount();
        $pages = $this->pageModel->getAllPagesCount();
        $data  = ['users_statistics' => $users, 'posts_statistics' => $posts, 'pages_statistics' => $pages];
        return $data;
    }

}
