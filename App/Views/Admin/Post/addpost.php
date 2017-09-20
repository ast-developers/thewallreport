<?php
$pagetitle = (!empty($user)) ? 'Edit' : 'Add' . ' Post';
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
            <div class="span9">
                <div class="tabbable tabbable-custom boxless">
                    <div class="tab-pane">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <h4><i class="icon-reorder"></i><?php echo (!empty($post)) ? 'Edit' : 'Add'; ?> Post
                                </h4>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="<?php echo \App\Config::W_ROOT . 'admin/addpost' ?>" method="post"
                                      class="form-horizontal form-row-seperated post-form">
                                    <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">
                                    <?php if ((!empty($post))) { ?>
                                        <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                                    <?php } ?>
                                    <?php $name = (!empty($post['name'])) ? $post['name'] : '' ?>
                                    <div class="control-group">
                                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                        <label class="control-label">Post Name</label>

                                        <div class="controls">
                                            <div class="input-icon left">
                                                <i class="icon-user"></i>
                                                <input class="m-wrap  span6 m-wrap" type="text"
                                                       placeholder="Post name" name="name"
                                                       value='<?php echo $name; ?>' />
                                            </div>
                                        </div>
                                    </div>
                                    <?php $description = (!empty($post['description'])) ? $post['description'] : '' ?>
                                    <div class="control-group">
                                        <label class="control-label">Description</label>

                                        <div class="controls">
                                            <textarea id="content" name="description"><?php echo $description; ?></textarea>
                                        </div>
                                    </div>

                                    <?php $post_tags = (!empty($post_tags)) ? $post_tags : ''; ?>
                                    <div class="control-group">
                                        <label class="control-label">Tags</label>
                                        <div class="controls">
                                            <input type="text" name="tag" id="tokenfield" value="<?php echo $post_tags ?>" />
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" name="submit" class="btn blue"><i
                                            class="icon-ok"></i> Save Post
                                        </button>
                                    </div>
                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span3">
                <div class="tabbable tabbable-custom boxless">
                    <div class="tab-pane">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <h4><i class="icon-reorder"></i><?php echo (!empty($post)) ? 'Edit' : 'Add'; ?> Post
                                </h4>
                                <a href="#" class="pull-right btn green">Preview</a>
                            </div>
                            <div class="portlet-body form">
                                <div class="control-group">
                                    <label class="control-label">Status</label>

                                    <div class="controls">
                                        <select class="chosen_category" name="status"
                                                tabindex="1">
                                            <option
                                                value="draft" <?php echo (!empty($post['status']) && $post['status'] == 'draft') ? 'selected="selected"' : ''; ?>>
                                                Draft
                                            </option>
                                            <option
                                                value="pending" <?php echo (!empty($post['status']) && $post['status'] == 'pending') ? 'selected="selected"' : ''; ?>>
                                                Pending Review
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Category</label>
                                    <div class="controls">
                                        <select class="span6 m-wrap" multiple="multiple" name="category_id[]" data-placeholder="Choose a Category" tabindex="1">
                                            <?php foreach ($parent_cat as $option) { ?>
                                                <option
                                                    value="<?php echo $option['4'] ?>" <?php echo (!empty($post_cat) && in_array($option['4'],$post_cat)) ? 'selected="selected"' : ''; ?>><?php echo $option['1'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div></div></div>

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
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/js/post.js"></script>
<script>
    $(document).ready(function () {
        Post.initManagement();
        $('#tokenfield').tokenfield({
            autocomplete: {
                source: [<?php echo $tags; ?>],
                delay: 100,
                focus: function (event, ui) {
                    event.preventDefault();
                }
            },
            showAutocompleteOnFocus: true
        })
        $('.autocompleteContainer').on('touchstart', 'li.ui-menu-item', function(){

            var $container = $(this).closest('.autocompleteContainer'),
                $item = $(this);

            //if we haven't closed the result box like we should have, simulate a click on the element they tapped on.
            function fixitifitneedsit() {
                if ($container.is(':visible') && $item.hasClass('ui-state-focus')) {

                    $item.trigger('click');
                    return true; // it needed it
                }
                return false; // it didn't
            }

            setTimeout(function () {
                if (!fixitifitneedsit()) {
                    setTimeout(fixitifitneedsit, 600);
                }
            }, 600);
        });
        $(function()
        {
            $('#content').redactor({
                focus: true,
                imageUpload: '<?php echo \App\Config::W_ROOT.'admin/uploadImage' ?>',
                plugins: ['video','inlinestyle','source','alignment','table','fullscreen','fontsize','fontcolor'],

            });
        });
    });
</script>
</body>