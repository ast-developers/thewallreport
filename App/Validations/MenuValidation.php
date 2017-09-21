<?php
namespace App\Validations;

use App\Models\Menu;
use App\Repositories\Admin\PageRepository;
use App\Repositories\Admin\PostRepository;
use Core\Csrf;


class MenuValidation
{
    public $model;
    public $post_repo;
    public $page_repo;

    public function __construct($params = [])
    {
        $this->model = new Menu();
        $this->page_repo = new PageRepository();
        $this->post_repo = new PostRepository();
    }

    /**
     * @return array
     */
    public function validate()
    {
        $success = true;
        $messages = [];

        if (isset($_POST['submit'])) {

            // Verify CSRF Token
            $verify_token = Csrf::verifyToken();
            if (!$verify_token) {
                $success = false;
                $messages[] = 'Invalid Token.';
            }
            // Menu name : Required
            if (empty($_POST['name'])) {
                $success = false;
                $messages[] = 'Please enter menu name.';
            }

            if (empty($_POST['type'])) {
                $success = false;
                $messages[] = 'Please enter menu type.';
            }

            if (!empty($_POST['type'])) {

                if($_POST['type']==1){
                    $post = $this->post_repo->getPostById($_POST['post']);
                    if(count($post)!=1){
                        $success = false;
                        $messages[] = 'You have chosen wrong post.';
                    }
                }elseif($_POST['type']==2){
                    $page = $this->page_repo->getPageById($_POST['page']);
                    if(count($page)!=1){
                        $success = false;
                        $messages[] = 'You have chosen wrong page.';
                    }
                }else{
                    $success = false;
                    $messages[] = 'You have chosen wrong menu type.';
                }

            }

            return ['success' => $success, 'messages' => $messages];
        }
    }

}