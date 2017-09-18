<?php
$pagetitle = (!empty($user)) ? 'Edit' : 'Add'.' Post';
include(\App\Config::F_ROOT . 'App/Views/Admin/header.php') ?>

    <!-- BEGIN PAGE -->
    <div class="page-content">

        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <h3 class="page-title">
                        Post
                    </h3>
                </div>
            </div>
            <!-- END PAGE HEADER-->

            <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>

            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                    <div class="tabbable tabbable-custom boxless">
                        <div class="tab-pane">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <h4><i class="icon-reorder"></i><?php echo (!empty($user)) ? 'Edit' : 'Add'; ?> Post
                                    </h4>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="<?php echo \App\Config::W_ROOT . 'admin/addpost' ?>" method="post"
                                          class="form-horizontal form-row-seperated user-form">
                                        <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">
                                        <div class="control-group">
                                            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                            <label class="control-label">Post Name</label>

                                            <div class="controls">
                                                <div class="input-icon left">
                                                    <i class="icon-user"></i>
                                                    <input class="m-wrap placeholder-no-fix span6 m-wrap" type="text"
                                                           placeholder="Post name" name="name"
                                                           value=""/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                            <label class="control-label">Description</label>

                                            <textarea id="content" name="content"></textarea>

                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" name="submit" class="btn blue"><i
                                                    class="icon-ok"></i> Save User
                                            </button>
                                        </div>
                                    </form>
                                    <!-- END FORM-->
                                </div>
                            </div>
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
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/js/post.js"></script>
<script>
    $(function()
    {
        $('#content').redactor();
    });
    $(document).ready(function () {
        Post.initManagement();
    });
</script>
</body>