<?php
$pagetitle = 'Users';
include(\App\Config::F_ROOT . 'App/Views/Admin/header.php') ?>

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
            <!-- END PAGE HEADER-->

            <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>

            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12 responsive" data-tablet="span12 fix-offset" data-desktop="span12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box grey">
                        <div class="portlet-title">
                            <h4><i class="icon-user"></i>Table</h4>

                            <div class="actions">
                                <a href="<?php echo \App\Config::W_ROOT . "admin/add-user" ?>" class="btn blue"><i
                                        class="icon-pencil"></i> Add</a>
                                <button class="btn red" id="deleteTriger">Delete</button>
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
                                    <th style="width:8px;"><input type="checkbox" id="bulkDelete"/>
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

<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>

<script>
    var userAjaxPaginateUrl = "<?php echo \App\Config::W_ROOT ?>admin/users-ajax-paginate";
    var userBulkDeleteUrl = "<?php echo \App\Config::W_ROOT ?>admin/bulk-delete-users";
</script>
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/public/theme/front/assets/js/user.js"></script>
<script>
    $(document).ready(function () {
        User.initList();
    });
</script>
</body>


