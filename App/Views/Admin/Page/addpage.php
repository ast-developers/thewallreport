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
            <form action="<?php echo \App\Config::W_ROOT . 'admin/add-page' ?>" method="post"
                  enctype="multipart/form-data"
                  class="page-form">
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
                                    <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">
                                    <?php if ((!empty($page))) { ?>
                                        <input type="hidden" name="id" value="<?php echo $page['id'] ?>">
                                    <?php } ?>
                                    <input type="hidden" name="delete_featured_image" class="delete_featured_image"
                                           value="0">
                                    <?php $name = (!empty($page['name'])) ? $page['name'] : '' ?>
                                    <div class="control-group">
                                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                        <label class="control-label" for="name">Page Name</label>

                                        <div class="controls">
                                            <div class="validation">
                                                <input class="m-wrap  span12 m-wrap" type="text" name="name" id="name"
                                                       value='<?php echo $name; ?>'/></div>
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
                                    <div class="form-actions pl-20">
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

                                    <?php if(!empty($page)){ ?>
                                        <div class="tools">
                                            <a href="<?php echo \App\Config::W_ROOT.$page['slug'] ?>" class="btn mini green">Preview</a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="portlet-body form">
                                    <div class="control-group">
                                        <label class="control-label" for="status">Status</label>

                                        <div class="controls">
                                            <select class="chosen_category span12 m-wrap" name="status" id="status-type"
                                                    tabindex="1">
                                                <option
                                                    value="draft" <?php echo (!empty($page['status']) && $page['status'] == 'draft') ? 'selected="selected"' : ''; ?>>
                                                    Draft
                                                </option>
                                                <option
                                                    value="pending" <?php echo (!empty($page['status']) && $page['status'] == 'pending') ? 'selected="selected"' : ''; ?>>
                                                    Pending Review
                                                </option>
                                                <option
                                                    value="publish" <?php echo (!empty($page['status']) && $page['status'] == 'publish') ? 'selected="selected"' : ''; ?>>
                                                    Publish
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php $views = (isset($page['views'])) ? $page['views'] : 0 ?>
                                    <div class="control-group">
                                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                        <label class="control-label" for="name">Views</label>

                                        <div class="controls">
                                            <div class="validation">
                                                <input class="span12 m-wrap" type="text"
                                                       name="views"
                                                       value='<?php echo $views ?>' id="views"/></div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" name="status_submit" id="status_submit" class="btn blue">
                                            <i
                                                class="icon-ok"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabbable tabbable-custom boxless edit-post">
                        <div class="tab-pane">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <h4><i class="icon-reorder"></i>Featured Image</h4>
                                </div>
                                <div class="portlet-body form">
                                    <div class="control-group">

                                        <div class="controls">
                                            <div class="fileupload fileupload-new featured-image-area"
                                                 data-provides="fileupload">
                                                <div class="fileupload-new thumbnail"
                                                     style="width: 200px; height: 150px;">
                                                    <?php if (!empty($page['featured_image'])) { ?>
                                                        <img
                                                            src="<?php echo \App\Config::W_FEATURED_IMAGE_ROOT . $page['featured_image']; ?>"
                                                            style="width: 200px; height: 160px;">
                                                    <?php } else { ?>
                                                        <img
                                                            src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                            alt=""/>
                                                    <?php } ?>
                                                </div>
                                                <div class="fileupload-preview fileupload-exists thumbnail"
                                                     style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                <div class="file-upload-button-area">
                                                    <?php if (!empty($page['featured_image'])) { ?>
                                                        <a href="#removeImage" role="button" id="delete-btn"
                                                           class="btn btn-danger featured-image-delete-btn red"
                                                           data-toggle="modal">Delete Featured Image</a>
                                                    <?php } ?>

                                                    <span class="btn btn-file"><span class="fileupload-new ">Set featured image</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file" class="default" name="featured_image"
                                              id="featured_image"/></span>
                                                    <a href="#" class="btn fileupload-exists"
                                                       data-dismiss="fileupload">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="removeImage" class="modal fade" tabindex="-1" role="dialog"
                                         aria-labelledby="myModalLabel2" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            <h3>Remove Fetured Image</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure, want to remove this Featured Image?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button data-dismiss="modal" class="btn red" id="deleteImage">Remove
                                            </button>
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
                imageUpload: '<?php echo \App\Config::W_ROOT.'admin/uploadImage' ?>',
                plugins: ['video', 'inlinestyle', 'source', 'alignment', 'table', 'fullscreen', 'fontsize', 'fontcolor'],

            });
        });
    });
</script>
</body>