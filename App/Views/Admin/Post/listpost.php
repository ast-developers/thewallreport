<?php
$pagetitle = 'Users';
include(\App\Config::F_ROOT . 'App/Views/Admin/header.php') ?>

    <!-- BEGIN PAGE -->
    <div class="page-content">
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">

            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid header-title">
                <div class="span12">
                    <h3 class="page-title">
                        Posts
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
                            <h4>Posts</h4>

                            <div class="actions">
                                <a href="<?php echo \App\Config::W_ROOT . "admin/addpost" ?>" class="btn blue"><i
                                        class="icon-pencil"></i> Add</a>
                                <a href="#myModal2" role="button" id="delete-btn" class="btn btn-danger red hidden" data-toggle="modal">Delete</a>
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
                            <table id="post-grid" class="display table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width:8px;"><input type="checkbox" id="bulkDelete"/>
                                    </th>
                                    <th>Name</th>
                                    <th>Categories</th>
                                    <th>Tags</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                            </table>
                            <!--</div>-->
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                    <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h3>Delete</h3>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure, want to remove the selected posts?</p>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn red" id="deleteTriger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->

        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->

<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>

<script>
    var userAjaxPaginateUrl = "<?php echo \App\Config::W_ROOT ?>admin/post-ajax-paginate";
    var userBulkDeleteUrl = "<?php echo \App\Config::W_ROOT ?>admin/bulk-delete-post";
</script>
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/js/post.js"></script>
<script>
    $(document).ready(function () {
        Post.initList();
    });
</script>
</body>


