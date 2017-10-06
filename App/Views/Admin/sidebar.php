<?php
$menuHelper = new \Core\Menu();
?>
<div class="page-sidebar nav-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <ul>
        <li>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler hidden-phone"></div>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        </li>
        <li>&nbsp;</li>
        <li class="start <?php echo $menuHelper->menuActiveState('admin.dashboard');?>">
            <a href="<?php echo \App\Config::W_ROOT . "admin/dashboard" ?>">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <?php if($sessionUser->hasPrivilege("list_user") || $sessionUser->hasPrivilege("add_user")) { ?>
        <li class="has-sub <?php echo $menuHelper->menuActiveState('admin.user');?>">
            <a href="javascript:;">
                <i class="icon-user"></i>
                <span class="title">Users</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <?php if($sessionUser->hasPrivilege("list_user")) { ?>
                <li class="<?php echo $menuHelper->menuActiveState('admin.user.list');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/users" ?>">All Users</a></li>
                <?php } ?>

                <?php if($sessionUser->hasPrivilege("add_user") || $sessionUser->hasPrivilege("edit_user")) { ?>
                <li class="<?php echo $menuHelper->menuActiveState('admin.user.manage');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/add-user" ?>">Add New</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php }?>

        <?php if($sessionUser->hasPrivilege("manage_flow_flow")) { ?>
        <li class="<?php echo $menuHelper->menuActiveState('admin.flow-flow');?>">
            <a href="<?php echo \App\Config::W_ROOT . "admin/flow-flow" ?>">
                <i class="icon-sitemap"></i>
                <span class="title">Flow-Flow</span>
            </a>
        </li>
        <?php }?>

        <?php if ($sessionUser->hasPrivilege("list_post") || $sessionUser->hasPrivilege("add_post") || $sessionUser->hasPrivilege("list_category") || $sessionUser->hasPrivilege("add_category")) { ?>
            <li class="has-sub <?php echo $menuHelper->menuActiveState('admin.post'); ?>">
                <a href="javascript:;">
                    <i class="icon-pushpin"></i>
                    <span class="title">Posts</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub">
                    <?php if ($sessionUser->hasPrivilege("list_post")) { ?>
                        <li class="<?php echo $menuHelper->menuActiveState('admin.post.list'); ?>"><a href="<?php echo \App\Config::W_ROOT . "admin/posts" ?>">All Posts</a></li>
                    <?php } ?>
                    <?php if ($sessionUser->hasPrivilege("add_post")) { ?>
                        <li class="<?php echo $menuHelper->menuActiveState('admin.post.manage'); ?>"><a href="<?php echo \App\Config::W_ROOT . "admin/add-post" ?>">Add New</a></li>
                    <?php } ?>
                    <?php if ($sessionUser->hasPrivilege("list_category") || $sessionUser->hasPrivilege("add_category")) { ?>
                        <li class="<?php echo $menuHelper->menuActiveState('admin.post.category'); ?>"><a href="<?php echo \App\Config::W_ROOT . "admin/categories" ?>">Categories</a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if($sessionUser->hasPrivilege("list_page") || $sessionUser->hasPrivilege("add_page")) { ?>
        <li class="has-sub <?php echo $menuHelper->menuActiveState('admin.page');?>">
            <a href="javascript:;">
                <i class="icon-file"></i>
                <span class="title">Pages</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <?php if ($sessionUser->hasPrivilege("list_page")) { ?>
                <li class="<?php echo $menuHelper->menuActiveState('admin.page.list');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/pages" ?>">All Pages</a></li>
                <?php } ?>

                <?php if ($sessionUser->hasPrivilege("add_page")) { ?>
                <li class="<?php echo $menuHelper->menuActiveState('admin.page.manage');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/add-page" ?>">Add New</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <?php if($sessionUser->hasPrivilege("list_menu") || $sessionUser->hasPrivilege("add_menu")) { ?>
        <li class="has-sub <?php echo $menuHelper->menuActiveState('admin.menu');?>">
            <a href="javascript:;">
                <i class="icon-th-list"></i>
                <span class="title">Menus</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <?php if ($sessionUser->hasPrivilege("list_menu")) { ?>
                <li class="<?php echo $menuHelper->menuActiveState('admin.menu.list');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/menus" ?>">All Menus</a></li>
                <?php } ?>

                <?php if ($sessionUser->hasPrivilege("add_menu")) { ?>
                <li class="<?php echo $menuHelper->menuActiveState('admin.menu.manage');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/add-menu" ?>">Add New</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <?php if($sessionUser->hasPrivilege("list_advertise") || $sessionUser->hasPrivilege("add_advertise")) { ?>
        <li class="has-sub <?php echo $menuHelper->menuActiveState('admin.advertise');?>">
            <a href="javascript:;">
                <i class="icon-th-list"></i>
                <span class="title">Advertise</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <?php if ($sessionUser->hasPrivilege("list_advertise")) { ?>
                <li class="<?php echo $menuHelper->menuActiveState('admin.advertise.list');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/advertise" ?>">All Advertises</a></li>
                <?php } ?>

                <?php if ($sessionUser->hasPrivilege("add_advertise")) { ?>
                <li class="<?php echo $menuHelper->menuActiveState('admin.advertise.manage');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/add-advertise" ?>">Add New</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
    </ul>
    </ul>
    <!-- END SIDEBAR MENU -->
</div>