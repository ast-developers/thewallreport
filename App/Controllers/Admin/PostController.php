<?php

namespace App\Controllers\Admin;

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

        View::render('Admin/Post/addpost.php');
    }

}
