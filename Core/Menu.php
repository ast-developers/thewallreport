<?php
namespace Core;
/**
 * Class Menu
 * @package Core
 */
class Menu
{
    /**
     * Provide Active classes to menu items.
     *
     * @param $menuIdentifier
     * @param $class
     * @return string
     */
    public function menuActiveState($menuIdentifier = '', $class = 'active')
    {
        $menu = [
            'admin' => [
                'dashboard' => 'admin/dashboard',
                'user'      => [
                    'list'   => 'admin/users',
                    'manage' => [
                        'admin/add-user',
                        'admin/edit-user',
                    ]
                ],
                'flow-flow' => 'admin/flow-flow',
                'post'      => [
                    'list'     => 'admin/posts',
                    'manage'   => [
                        'admin/add-post',
                        'admin/edit-post',
                    ],
                    'category' => [
                        'list'   => 'admin/categories',
                        'manage' => [
                            'admin/add-category',
                            'admin/edit-category',
                        ]
                    ]
                ],
                'page'      => [
                    'list'   => 'admin/pages',
                    'manage' => [
                        'admin/add-page',
                        'admin/edit-page',
                    ]
                ],
                'menu'      => [
                    'list'   => 'admin/menus',
                    'manage' => [
                        'admin/add-menu',
                        'admin/edit-menu',
                    ]
                ],
                'advertise'      => [
                    'list'   => 'admin/advertise',
                    'manage' => [
                        'admin/add-advertise',
                        'admin/edit-advertise',
                    ]
                ]
            ]
        ];

        $menuToCheck     = [];
        $menuIdentifiers = explode('.', $menuIdentifier);
        if ($menuIdentifiers) {
            foreach ($menuIdentifiers as $indexIdentifier => $identifier) {

                if ($indexIdentifier == 0) {
                    $menuToCheck = $menu[$identifier];
                } else {
                    if (isset($menuToCheck[$identifier])) {
                        $menuToCheck = $menuToCheck[$identifier];
                    }
                }
            }
        }

        return $this->checkMenuRoutes($menuToCheck, $class);
    }

    /**
     * Check if given url exist in given menu array.
     *
     * @param $menuToCheck
     * @param $class
     * @return string
     */
    protected function checkMenuRoutes($menuToCheck = '', $class = 'active')
    {
        $return      = '';
        $queryString = $_SERVER['QUERY_STRING'];
        if (!is_array($menuToCheck)) {
            if (/*$queryString == $menuToCheck*/
                strpos($queryString, $menuToCheck) !== false
            ) {
                $return = $class;
            }
        } else {
            foreach ($menuToCheck as $routeToCheck) {
                if (!is_array($routeToCheck)) {
                    if (/*$queryString == $routeToCheck*/
                        strpos($queryString, $routeToCheck) !== false
                    ) {
                        $return = $class;
                        break;
                    }
                } else {
                    $return = $this->checkMenuRoutes($routeToCheck, $class);
                    if ($return) {
                        break;
                    }
                }
            }
        }

        return $return;
    }
}