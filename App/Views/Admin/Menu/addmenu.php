<?php
$pagetitle = (!empty($user)) ? 'Edit' : 'Add' . ' Menu';
include(\App\Config::F_ROOT . 'App/Views/Admin/header.php') ?>

<!-- BEGIN PAGE -->
<div class="page-content">

    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <h3 class="page-title">
                    Menu
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
                                <h4><i class="icon-reorder"></i><?php echo (!empty($menu)) ? 'Edit' : 'Add'; ?> Menu
                                </h4>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="<?php echo \App\Config::W_ROOT . 'admin/add-menu' ?>" method="post"
                                      class="form-horizontal form-row-seperated menu-form">
                                    <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">
                                    <?php if ((!empty($menu))) { ?>
                                        <input type="hidden" name="id" value="<?php echo $menu['id'] ?>">
                                    <?php } ?>
                                    <?php $name = (!empty($menu['name'])) ? $menu['name'] : '' ?>
                                    <div class="control-group">
                                        <label class="control-label" for="name">Menu Name</label>

                                        <div class="controls">
                                            <div class="validation">
                                                <input class="m-wrap  span6 m-wrap" type="text"
                                                       placeholder="Menu name" name="name" id="name"
                                                       value='<?php echo $name; ?>'/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="type">Menu Type</label>

                                        <div class="controls">
                                            <select class="chosen_category" name="type" id="menu-type" id="type">
                                                <option
                                                    value="1" <?php echo (!empty($menu['type']) && $menu['type'] == '1') ? 'selected="selected"' : ''; ?>>
                                                    Post
                                                </option>
                                                <option
                                                    value="2" <?php echo (!empty($menu['type']) && $menu['type'] == '2') ? 'selected="selected"' : ''; ?>>
                                                    Page
                                                </option>
                                                <option
                                                    value="3" <?php echo (!empty($menu['type']) && $menu['type'] == '3') ? 'selected="selected"' : ''; ?>>
                                                    External URL
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group hidden" id="post-dropdown">
                                        <label class="control-label" for="post">Posts</label>

                                        <div class="controls">
                                            <select class="chosen_category span6" name="post" id="post">
                                                <?php foreach ($posts as $value) { ?>
                                                    <option
                                                        value="<?php echo $value['id'] ?>" <?php echo (!empty($menu['type']) && $menu['type'] == 1 && $value['id'] == $menu['link']) ? 'selected="selected"' : ''; ?>><?php echo $value['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group hidden" id="page-dropdown">
                                        <label class="control-label" for="page">Pages</label>

                                        <div class="controls">
                                            <select class="chosen_category span6" name="page" id="page">
                                                <?php foreach ($pages as $value) { ?>
                                                    <option
                                                        value="<?php echo $value['id'] ?>" <?php echo (!empty($menu['type']) && $menu['type'] == '2' && $value['id'] == $menu['link']) ? 'selected="selected"' : ''; ?>><?php echo $value['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group hidden" id="external-url-textbox">
                                        <label class="control-label" for="external_url">External URL</label>
                                        <?php $url = (!empty($menu['type']) && $menu['type'] == '3') ? $menu['link'] : '' ?>
                                        <div class="controls">

                                            <input class="m-wrap  span6 m-wrap" type="text"
                                                   placeholder="External URL" name="external_url" id="external_url"
                                                   value='<?php echo $url; ?>'/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php $selected = (!empty($menu['new_tab']) && $menu['new_tab'] == '1') ? 'checked=”checked”' : '' ?>
                                        <label class="control-label">Open in new tab</label>
                                        <div class="controls">
                                            <label class="checkbox">
                                                <input type="checkbox" name="new_tab" value="1" <?php echo $selected ?>/>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Status</label>
                                    <div class="controls">
                                        <select class="chosen_category" name="status"
                                                tabindex="1">
                                            <option
                                                value="active" <?php echo (!empty($menu['status']) && $menu['status'] == 'active') ? 'selected="selected"' : ''; ?>>
                                                Active
                                            </option>
                                            <option
                                                value="inactive" <?php echo (!empty($menu['status']) && $menu['status'] == 'inactive') ? 'selected="selected"' : ''; ?>>
                                                Inactive
                                            </option>
                                        </select>
                                    </div></div>

                                    <div class="form-actions">
                                        <button type="submit" name="submit" class="btn blue"><i
                                                class="icon-ok"></i> Save Menu
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
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/js/jquery-1.8.3.min.js"></script>
<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/js/menu.js"></script>
<script>
    $(document).ready(function () {
        Menu.initManagement();
    });

</script>
</body>