<?php include(\App\Config::F_ROOT . 'App/Views/Admin/header.php') ?>

    <!-- BEGIN PAGE -->
    <div class="page-content">

        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        Dashboard
                        <small>statistics and more</small>
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->

            <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>

            <div id="dashboard">
                <!-- BEGIN DASHBOARD STATS -->
                <div class="row-fluid">
                    <!-- Users Statistics -->
                    <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                        <div class="dashboard-stat blue">
                            <div class="visual">
                                <i class="icon-user"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <?php echo $data['users_statistics']; ?>
                                </div>
                                <div class="desc">
                                    Users
                                </div>
                            </div>
                            <a class="more" href="<?php echo \App\Config::W_ROOT.'admin/users'; ?>">
                                View more <i class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Posts Statistics -->
                    <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                        <div class="dashboard-stat green">
                            <div class="visual">
                                <i class="icon-pushpin"></i>
                            </div>
                            <div class="details">
                                <div class="number"><?php echo $data['posts_statistics']; ?></div>
                                <div class="desc">Posts</div>
                            </div>
                            <a class="more" href="<?php echo \App\Config::W_ROOT.'admin/posts'; ?>">
                                View more <i class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Pages Statistics -->
                    <div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
                        <div class="dashboard-stat purple">
                            <div class="visual">
                                <i class="icon-file"></i>
                            </div>
                            <div class="details">
                                <div class="number"><?php echo $data['pages_statistics']; ?></div>
                                <div class="desc">Pages</div>
                            </div>
                            <a class="more" href="<?php echo \App\Config::W_ROOT.'admin/pages'; ?>">
                                View more <i class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END DASHBOARD STATS -->
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->

<!-- BEGIN FOOTER -->
<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>
<script>
    jQuery(document).ready(function () {
        App.setPage("index");  // set current page
        App.init(); // init the rest of plugins and elements
    });
</script>
<!-- END JAVASCRIPTS -->
</body>


