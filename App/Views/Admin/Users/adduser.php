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
                <div class="span12">
                    <div class="tabbable tabbable-custom boxless">
                        <div class="tab-pane">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <h4><i class="icon-reorder"></i><?php echo (!empty($user)) ? 'Edit' : 'Add'; ?> User
                                    </h4>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <?php $route = (!empty($user)) ? 'admin/edit-user' : 'admin/add-user'; ?>
                                    <form action="<?php echo \App\Config::W_ROOT . $route ?>" method="post"
                                          enctype="multipart/form-data"
                                          class="form-horizontal form-row-seperated user-form">
                                        <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">
                                        <?php if ((!empty($user))) { ?>
                                            <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                                        <?php } ?>
                                        <div class="control-group">
                                            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                            <?php $username = (!empty($user['username'])) ? $user['username'] : '' ?>
                                            <label class="control-label">Username</label>

                                            <div class="controls">
                                                <div class="input-icon left">
                                                    <i class="icon-user"></i>
                                                    <input class="m-wrap placeholder-no-fix" type="text"
                                                           placeholder="Username" name="username"
                                                           value="<?php echo $username ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Role</label>

                                            <div class="controls">
                                                <select class="chosen_category" name="role_id"
                                                        data-placeholder="Choose a Category" tabindex="1">
                                                    <?php if (!empty($roles)) {
                                                        foreach ($roles as $role) {
                                                            ?>
                                                            <option
                                                                value="<?php echo $role['id']; ?>" <?php echo (!empty($user['role_id']) && $user['role_id'] == $role['id']) ? 'selected="selected"' : ''; ?>><?php echo $role['name']; ?></option>
                                                        <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <?php $first_name = (!empty($user['first_name'])) ? $user['first_name'] : '' ?>
                                            <label class="control-label">First Name</label>

                                            <div class="controls">
                                                <input type="text" name="first_name" placeholder="First Name"
                                                       class="m-wrap" value="<?php echo $first_name ?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <?php $last_name = (!empty($user['last_name'])) ? $user['last_name'] : '' ?>
                                            <label class="control-label">Last Name</label>

                                            <div class="controls">
                                                <input type="text" name="last_name" placeholder="Last Name"
                                                       class="m-wrap" value="<?php echo $last_name ?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <?php $nick_name = (!empty($user['nick_name'])) ? $user['nick_name'] : '' ?>
                                            <label class="control-label">Nick Name</label>

                                            <div class="controls">
                                                <input type="text" name="nick_name" placeholder="Nick name"
                                                       class="m-wrap" value="<?php echo $nick_name ?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <?php $email = (!empty($user['email'])) ? $user['email'] : '' ?>
                                            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                            <label class="control-label">Email</label>

                                            <div class="controls">
                                                <div class="input-icon left">
                                                    <i class="icon-envelope"></i>
                                                    <input class="m-wrap placeholder-no-fix" type="text"
                                                           placeholder="Email" name="email"
                                                           value="<?php echo $email ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (empty($user)) { ?>
                                            <div class="control-group">
                                                <?php $password = (!empty($user['password'])) ? $user['password'] : '' ?>
                                                <label class="control-label">Password</label>

                                                <div class="controls">
                                                    <div class="input-icon left">
                                                        <i class="icon-lock"></i>
                                                        <input class="m-wrap placeholder-no-fix" type="password"
                                                               id="register_password" placeholder="Password"
                                                               name="password" value="<?php echo $password ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Re-type Your Password</label>

                                                <div class="controls">
                                                    <div class="input-icon left">
                                                        <i class="icon-ok"></i>
                                                        <input class="m-wrap placeholder-no-fix" type="password"
                                                               placeholder="Re-type Your Password" name="rpassword"
                                                               value="<?php echo $password ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="control-group">
                                            <label class="control-label">Avatar</label>

                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="fileupload-new thumbnail"
                                                         style="width: 200px; height: 150px;">
                                                        <?php if (!empty($user['profile_image'])) { ?>
                                                            <img
                                                                src="<?php echo \App\Config::W_ROOT . 'uploads/profile_images/' . $user['profile_image']; ?>"
                                                                style="width: 200px; height: 160px;">
                                                        <?php } else { ?>
                                                            <img
                                                                src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                                alt=""/>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                         style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                    <div>
                                       <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file" class="default" name="avatar"/></span>
                                                        <a href="#" class="btn fileupload-exists"
                                                           data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" name="submit" class="btn blue"><i
                                                    class="icon-ok"></i> <?php echo (!empty($user)) ? 'Edit User' : 'Save User'; ?>
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
        </div>

        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->
</div>
<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>
<script>
    jQuery(document).ready(function () {
        // initiate layout and plugins
        App.setPage("table_managed");
        App.init();
    });
</script>
</body>


