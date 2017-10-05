<?php
$pagetitle = (!empty($user)) ? 'Edit' : 'Add' . ' Advertise';
include(\App\Config::F_ROOT . 'App/Views/Admin/header.php') ?>

<!-- BEGIN PAGE -->
<div class="page-content">

    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title">
                    Advertise
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
                        <div class="portlet box grey">
                            <div class="portlet-title">
                                <h4><i class="icon-reorder"></i><?php echo (!empty($advertise)) ? 'Edit' : 'Add'; ?>
                                    Advertise
                                </h4>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="<?php echo \App\Config::W_ROOT . 'admin/add-advertise' ?>" method="post"
                                      enctype="multipart/form-data"
                                      class="form-horizontal advertise-form">
                                    <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">
                                    <input type="hidden" name="delete_banner_image" class="delete_banner_image"
                                           value="0">
                                    <?php if ((!empty($advertise))) { ?>
                                        <input type="hidden" name="id" value="<?php echo $advertise['id'] ?>">
                                    <?php } ?>
                                    <?php $name = (!empty($advertise['name'])) ? $advertise['name'] : '' ?>
                                    <div class="control-group">
                                        <label class="control-label" for="name">Advertise Name</label>

                                        <div class="controls">
                                            <div class="validation">
                                                <input class="m-wrap" type="text"
                                                       name="name" id="name"
                                                       value='<?php echo $name; ?>'/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="type">Advertise Position</label>

                                        <div class="controls">
                                            <select class="chosen_category m-wrap" name="position" id="position">
                                                <option
                                                    value="left" <?php echo (!empty($advertise['position']) && $advertise['position'] == 'left') ? 'selected="selected"' : ''; ?>>
                                                    Left Side
                                                </option>
                                                <option
                                                    value="right" <?php echo (!empty($advertise['position']) && $advertise['position'] == 'right') ? 'selected="selected"' : ''; ?>>
                                                    Right Side
                                                </option>
                                                <option
                                                    value="center" <?php echo (!empty($advertise['position']) && $advertise['position'] == 'center') ? 'selected="selected"' : ''; ?>>
                                                    Center
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="type">Advertise Type</label>

                                        <div class="controls">
                                            <select class="chosen_category m-wrap" name="type" id="advertise-type" id="type">
                                                <option
                                                    value="banner" <?php echo (!empty($advertise['type']) && $advertise['type'] == 'banner') ? 'selected="selected"' : ''; ?>>
                                                    Banner
                                                </option>
                                                <option
                                                    value="adsense" <?php echo (!empty($advertise['type']) && $advertise['type'] == 'adsense') ? 'selected="selected"' : ''; ?>>
                                                    Adsense Code
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group hidden" id="banner-image">
                                        <label class="control-label" for="type">Banner Image</label>

                                        <div class="controls">
                                            <div class="fileupload fileupload-new banner-image-area"
                                                 data-provides="fileupload">
                                                <div class="fileupload-new thumbnail"
                                                     style="width: 200px; height: 150px;">
                                                    <?php if (!empty($advertise['banner_image'])) { ?>
                                                        <img
                                                            src="<?php echo \App\Config::W_BANNER_IMAGE_ROOT . $advertise['banner_image']; ?>"
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
                                                    <?php if (!empty($advertise['banner_image'])) { ?>
                                                        <a href="#removeImage" role="button" id="delete-btn"
                                                           class="btn btn-danger banner-image-delete-btn red"
                                                           data-toggle="modal">Delete Banner Image</a>
                                                    <?php } ?>

                                                    <span class="btn btn-file"><span class="fileupload-new ">Set Banner mage</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file" class="default" name="banner_image"
                                              id="banner_image"/></span>
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
                                            <h3>Remove Banner Image</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure, want to remove this Banner Image?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button data-dismiss="modal" class="btn red" id="deleteImage">Remove
                                            </button>
                                        </div>
                                    </div>
                                    <?php $adsenseCode = (!empty($advertise['adsense_code'])) ? $advertise['adsense_code'] : '' ?>
                                    <div class="control-group hidden" id="adsense-area">
                                        <label class="control-label">Adsense code</label>

                                        <div class="controls">
                                            <textarea id="content"
                                                      name="adsense_code"><?php echo $adsenseCode; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Status</label>

                                        <div class="controls">
                                            <select class="chosen_category m-wrap" name="status"
                                                    tabindex="1">
                                                <option
                                                    value="active" <?php echo (!empty($advertise['status']) && $advertise['status'] == 'active') ? 'selected="selected"' : ''; ?>>
                                                    Active
                                                </option>
                                                <option
                                                    value="inactive" <?php echo (!empty($advertise['status']) && $advertise['status'] == 'inactive') ? 'selected="selected"' : ''; ?>>
                                                    Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" name="submit" class="btn blue"><i
                                                class="icon-ok"></i> Save Advertise
                                        </button>
                                    </div>
                                    <!-- END FORM-->
                                </form>
                            </div>
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
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/js/advertise.js"></script>
<script>
    $(document).ready(function () {
        Advertise.initManagement();
        $(function () {
            $('#content').redactor({
                imageUpload: '<?php echo \App\Config::W_ROOT.'admin/uploadImage' ?>',
                plugins: ['video', 'inlinestyle', 'source', 'alignment', 'table', 'fullscreen', 'fontsize', 'fontcolor'],

            });
        });
    });

</script>
</body>