<div class="header navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="navbar-inner">
        <div class="container-fluid">
            <!-- BEGIN LOGO -->
            <a class="brand" href="index.html">
                <!--<img src="<?php /*echo \App\Config::W_ADMIN_ASSETS */?>/img/logo.png" alt="logo"/>-->
                The Wall Report
            </a>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                <!--<img src="assets/img/menu-toggler.png" alt=""/>-->
                The Wall Report
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <ul class="nav pull-right">
                <li class="dropdown user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!--<img alt="" src="<?php /*\App\Config::W_ROOT.'uploads/profile_images/'.$_SESSION['user']['profile_image'] */ ?>" />-->
                        <span
                            class="username"><?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'] ?></span>
                        <i class="icon-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo \App\Config::W_ROOT . "admin/logout" ?>"><i class="icon-key"></i> Log
                                Out</a></li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>