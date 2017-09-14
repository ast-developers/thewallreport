<?php include(\App\Config::F_ROOT . 'App/Views/Admin/header.php') ?>
<body class="fixed-top">
<!-- BEGIN HEADER -->
<?php include(\App\Config::F_ROOT . 'App/Views/Admin/topbar.php') ?>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
    <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>
    <!-- BEGIN SIDEBAR -->

    <?php include(\App\Config::F_ROOT . 'App/Views/Admin/sidebar.php') ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE -->
    <div class="page-content">
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <h3 class="page-title">
                        Users
                    </h3>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 responsive" data-tablet="span12 fix-offset" data-desktop="span12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box grey">
                        <div class="portlet-title">
                            <h4><i class="icon-user"></i>Table</h4>

                            <div class="actions">
                                <a href="<?php echo \App\Config::W_ROOT . "admin/add-user" ?>" class="btn blue"><i
                                        class="icon-pencil"></i> Add</a>

                                <div class="btn-group">
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
                                        <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
                                        <li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="i"></i> Make admin</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table id="user-grid" class="display table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" id="bulkDelete"/>
                                        <button id="deleteTriger">Delete</button>
                                    </th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                                </thead>
                            </table>
                            <!--</div>-->
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->
</div>
<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>
<script>
    var userAjaxPaginateUrl = "<?php echo \App\Config::W_ROOT ?>admin/users-ajax-paginate";
    var userBulkDeleteUrl = "<?php echo \App\Config::W_ROOT ?>admin/bulk-delete-users";
</script>
</body>


