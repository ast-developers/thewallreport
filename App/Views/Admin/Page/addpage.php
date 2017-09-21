<?php
$pagetitle = (!empty($user)) ? 'Edit' : 'Add' . ' Page';
include(\App\Config::F_ROOT . 'App/Views/Admin/header.php') ?>

<!-- BEGIN PAGE -->
<div class="page-content">

    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title">
                    Page
                </h3>
            </div>
        </div>
        <!-- END PAGE HEADER-->

        <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>

        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span9">
                <div class="tabbable tabbable-custom boxless">
                    <div class="tab-pane">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <h4><i class="icon-reorder"></i><?php echo (!empty($page)) ? 'Edit' : 'Add'; ?> Page
                                </h4>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="<?php echo \App\Config::W_ROOT . 'admin/add-page' ?>" method="post"
                                      class="form-horizontal form-row-seperated page-form">
                                    <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">
                                    <?php if ((!empty($page))) { ?>
                                        <input type="hidden" name="id" value="<?php echo $page['id'] ?>">
                                    <?php } ?>
                                    <?php $name = (!empty($page['name'])) ? $page['name'] : '' ?>
                                    <div class="control-group">
                                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                        <label class="control-label">Page Name</label>

                                        <div class="controls">
                                            <input class="m-wrap  span6 m-wrap" type="text"
                                                   placeholder="Page name" name="name"
                                                   value='<?php echo $name; ?>'/>
                                        </div>
                                    </div>
                                    <?php $description = (!empty($page['description'])) ? $page['description'] : '' ?>
                                    <div class="control-group">
                                        <label class="control-label">Description</label>

                                        <div class="controls">
                                            <textarea id="content"
                                                      name="description"><?php echo $description; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" name="submit" class="btn blue"><i
                                                class="icon-ok"></i> Save Page
                                        </button>
                                    </div>
                                    <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="tabbable tabbable-custom boxless edit-page">
                    <div class="tab-pane">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <h4><i class="icon-reorder"></i><?php echo (!empty($page)) ? 'Edit' : 'Add'; ?> Page
                                </h4>

                                <div class="tools">
                                    <a href="#" class="btn mini green">Preview</a>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="control-group">
                                    <label class="control-label">Status</label>

                                    <div class="controls">
                                        <select class="chosen_category" name="status"
                                                tabindex="1">
                                            <option
                                                value="draft" <?php echo (!empty($page['status']) && $page['status'] == 'draft') ? 'selected="selected"' : ''; ?>>
                                                Draft
                                            </option>
                                            <option
                                                value="pending" <?php echo (!empty($page['status']) && $page['status'] == 'pending') ? 'selected="selected"' : ''; ?>>
                                                Pending Review
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </form>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<!-- END PAGE CONTAINER-->

</div>
<!-- END PAGE -->

<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/js/page.js"></script>
<script>
    $(document).ready(function () {
        Page.initManagement();
        $(function () {
            $('#content').redactor({
                focus: true,
                imageUpload: '<?php echo \App\Config::W_ROOT.'admin/uploadImage' ?>',
                plugins: ['video', 'inlinestyle', 'source', 'alignment', 'table', 'fullscreen', 'fontsize', 'fontcolor'],

            });
        });
    });
</script>
</body>