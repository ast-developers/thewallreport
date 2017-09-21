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
        <li class="has-sub ">
            <a href="javascript:;">
                <i class="icon-user"></i>
                <span class="title">Users</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li ><a href="<?php echo \App\Config::W_ROOT . "admin/users" ?>">All Users</a></li>
                <li ><a href="<?php echo \App\Config::W_ROOT . "admin/add-user" ?>">Add New</a></li>
            </ul>
        </li>
        <li class="">
            <a href="<?php echo \App\Config::W_ROOT . "admin/flow-flow" ?>">
                <i class="icon-sitemap"></i>
                <span class="title">Flow-Flow</span>
            </a>
        </li>
        <li class="has-sub ">
               <a href="javascript:;">
                       <i class="icon-pushpin"></i>
                       <span class="title">Posts</span>
                       <span class="arrow "></span>
                   </a>
               <ul class="sub">
                       <li ><a href="<?php echo \App\Config::W_ROOT . "admin/posts" ?>">All Posts</a></li>
                       <li ><a href="<?php echo \App\Config::W_ROOT . "admin/add-post" ?>">Add New</a></li>
                       <li ><a href="<?php echo \App\Config::W_ROOT . "admin/categories" ?>">Categories</a></li>
                   </ul>
           </li>
        <li class="has-sub ">
            <a href="javascript:;">
                <i class="icon-user"></i>
                <span class="title">Pages</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li ><a href="<?php echo \App\Config::W_ROOT . "admin/pages" ?>">All Pages</a></li>
                <li ><a href="<?php echo \App\Config::W_ROOT . "admin/add-page" ?>">Add New</a></li>
            </ul>
        </li>
    </ul>
    </ul>
    <!-- END SIDEBAR MENU -->
</div>