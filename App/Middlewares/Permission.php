<?php
namespace App\Middlewares;

use Core\Router;
use App\Models\PrivilegedUser;

class Permission
{
    /**
     *
     */
    public function handel()
    {
        if (isset($_SESSION['user'])) {
            $sessionUser = PrivilegedUser::getByUsername($_SESSION['user']['username']);
            $queryString = $_SERVER['QUERY_STRING'];

            $pages = [
                'admin/users'                  => 'list_user',
                'admin/bulk-delete-users'      => 'delete_user',
                'admin/add-user'               => 'add_user',
                'admin/edit-user'              => 'edit_user',
                'admin/flow-flow'              => 'manage_flow_flow',
                'admin/categories'             => 'list_category',
                'admin/bulk-delete-categories' => 'delete_category',
                'admin/add-category'           => 'add_category',
                'admin/edit-category'          => 'edit_category',
                'admin/posts'                  => 'list_post',
                'admin/bulk-delete-post'       => 'delete_post',
                'admin/add-post'               => 'add_post',
                'admin/edit-post'              => 'edit_post',
                'admin/pages'                  => 'list_page',
                'admin/bulk-delete-page'       => 'delete_page',
                'admin/add-page'               => 'add_page',
                'admin/edit-page'              => 'edit_page',
                'admin/menus'                  => 'list_menu',
                'admin/bulk-delete-menu'       => 'delete_menu',
                'admin/add-menu'               => 'add_menu',
                'admin/edit-menu'              => 'edit_menu',
            ];

            foreach ($pages as $menuToCheck => $permission) {
                // If editing own profile then allow to edit, even if edit_user permission is not given.
                if (strpos($queryString, 'admin/edit-user') !== false) {
                    $parts          = explode('/', $queryString);
                    $privilegedUser = new PrivilegedUser();
                    $user           = $privilegedUser->getUserById($parts[2]);
                    if ($user && $user['id'] == $_SESSION['user']['id']) {

                    } else {
                        Router::redirectTo('admin/dashboard', ['You Don\'t have privileges to access this page.'], 'alert-danger');
                    }
                } else if (strpos($queryString, $menuToCheck) !== false && !$sessionUser->hasPrivilege($permission)) {
                    Router::redirectTo('admin/dashboard', ['You Don\'t have privileges to access this page.'], 'alert-danger');
                }
            }
        }
    }
}