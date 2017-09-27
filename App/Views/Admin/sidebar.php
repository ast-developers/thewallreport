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
        <li>

        </li>
        <li class="has-sub <?php echo $menuHelper->menuActiveState('admin.user');?>">
            <a href="javascript:;">
                <i class="icon-user"></i>
                <span class="title">Users</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li class="<?php echo $menuHelper->menuActiveState('admin.user.list');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/users" ?>">All Users</a></li>
                <li class="<?php echo $menuHelper->menuActiveState('admin.user.manage');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/add-user" ?>">Add New</a></li>
            </ul>
        </li>
        <li class="<?php echo $menuHelper->menuActiveState('admin.flow-flow');?>">
            <a href="<?php echo \App\Config::W_ROOT . "admin/flow-flow" ?>">
                <i class="icon-sitemap"></i>
                <span class="title">Flow-Flow</span>
            </a>
        </li>
        <li class="has-sub <?php echo $menuHelper->menuActiveState('admin.post');?>">
               <a href="javascript:;">
                       <i class="icon-pushpin"></i>
                       <span class="title">Posts</span>
                       <span class="arrow "></span>
                   </a>
               <ul class="sub">
                       <li class="<?php echo $menuHelper->menuActiveState('admin.post.list');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/posts" ?>">All Posts</a></li>
                       <li class="<?php echo $menuHelper->menuActiveState('admin.post.manage');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/add-post" ?>">Add New</a></li>
                       <li class="<?php echo $menuHelper->menuActiveState('admin.post.category');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/categories" ?>">Categories</a></li>
                   </ul>
           </li>
        <li class="has-sub <?php echo $menuHelper->menuActiveState('admin.page');?>">
            <a href="javascript:;">
                <i class="icon-file"></i>
                <span class="title">Pages</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li class="<?php echo $menuHelper->menuActiveState('admin.page.list');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/pages" ?>">All Pages</a></li>
                <li class="<?php echo $menuHelper->menuActiveState('admin.page.manage');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/add-page" ?>">Add New</a></li>
            </ul>
        </li>
        <li class="has-sub <?php echo $menuHelper->menuActiveState('admin.menu');?>">
            <a href="javascript:;">
                <i class=""></i>
                <span class="title">Menus</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li class="<?php echo $menuHelper->menuActiveState('admin.menu.list');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/menus" ?>">All Menus</a></li>
                <li class="<?php echo $menuHelper->menuActiveState('admin.menu.manage');?>"><a href="<?php echo \App\Config::W_ROOT . "admin/add-menu" ?>">Add New</a></li>
            </ul>
        </li>
    </ul>
    </ul>
    <!-- END SIDEBAR MENU -->
</div>