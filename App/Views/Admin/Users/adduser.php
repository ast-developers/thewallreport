<?php
$pagetitle = (!empty($user)) ? 'Edit' : 'Add' . ' User';
include(\App\Config::F_ROOT . 'App/Views/Admin/header.php');
?>

<!-- BEGIN PAGE -->
<div class="page-content">

    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid header-title">
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
            <div class="span12">
                <div class="tabbable tabbable-custom boxless">
                    <div class="tab-pane">
                        <div class="portlet box grey">
                            <div class="portlet-title">
                                <h4><i class="icon-reorder"></i><?php echo (!empty($user)) ? 'Edit' : 'Add'; ?> User
                                </h4>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <?php $route = (!empty($user)) ? 'admin/update-user' : 'admin/add-user'; ?>
                                <form action="<?php echo \App\Config::W_ROOT . $route ?>" method="post"
                                      enctype="multipart/form-data"
                                      class="form-horizontal user-form">
                                    <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">
                                    <?php if ((!empty($user))) { ?>
                                        <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                                    <?php } ?>
                                    <div class="control-group">
                                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                        <?php $username = (!empty($user['username'])) ? $user['username'] : ($_POST && isset($_POST['username']) ? $_POST['username'] : '') ?>
                                        <label class="control-label" for="name">Username</label>

                                        <div class="controls">
                                            <div class="validation">
                                                <input class="m-wrap placeholder-no-fix" type="text" id="name"
                                                       name="username"
                                                       value="<?php echo $username ?>"/></div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="role_id">Role</label>

                                        <div class="controls">
                                            <select class="chosen_category m-wrap" name="role_id" id="role_id"
                                                    data-placeholder="Choose a Category">
                                                <?php if (!empty($roles)) {
                                                    foreach ($roles as $role) {
                                                        $selected = "";
                                                        if(!empty($user['role_id']) && $user['role_id'] == $role['id']){
                                                            $selected = 'selected="selected"';
                                                        } else if($_POST && isset($_POST['role_id']) && $_POST['role_id'] == $role['id']){
                                                            $selected = 'selected="selected"';
                                                        }
                                                        ?>
                                                        <option
                                                            value="<?php echo $role['id']; ?>" <?php echo $selected; ?>><?php echo $role['name']; ?></option>
                                                    <?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php $first_name = (!empty($user['first_name'])) ? $user['first_name'] : ($_POST && isset($_POST['first_name']) ? $_POST['first_name'] : '') ?>
                                        <label class="control-label" for="first_name">First Name</label>

                                        <div class="controls">
                                            <input type="text" name="first_name" id="first_name"
                                                   class="m-wrap" value="<?php echo $first_name ?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php $last_name = (!empty($user['last_name'])) ? $user['last_name'] : ($_POST && isset($_POST['last_name']) ? $_POST['last_name'] : '') ?>
                                        <label class="control-label" for="last_name">Last Name</label>

                                        <div class="controls">
                                            <input type="text" name="last_name" id="last_name"
                                                   class="m-wrap" value="<?php echo $last_name ?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php $nick_name = (!empty($user['nick_name'])) ? $user['nick_name'] : ($_POST && isset($_POST['nick_name']) ? $_POST['nick_name'] : '') ?>
                                        <label class="control-label" for="nick_name">Nick Name</label>

                                        <div class="controls">
                                            <input type="text" name="nick_name" id="nick_name"
                                                   class="m-wrap" value="<?php echo $nick_name ?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php $email = (!empty($user['email'])) ? $user['email'] : ($_POST && isset($_POST['email']) ? $_POST['email'] : '') ?>
                                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                        <label class="control-label" for="email">Email</label>

                                        <div class="controls">
                                            <div class="validation">
                                                <input class="m-wrap placeholder-no-fix" type="text" id="email"
                                                       name="email"
                                                       value="<?php echo $email ?>"/></div>
                                        </div>
                                    </div>
                                    <?php if (empty($user)) { ?>
                                        <div class="control-group">
                                            <?php $password = (!empty($user['password'])) ? $user['password'] : '' ?>
                                            <label class="control-label" for="password">Password</label>

                                            <div class="controls">
                                                <div class="validation">
                                                    <input class="m-wrap placeholder-no-fix" type="password" id="password"
                                                           id="register_password"
                                                           name="password" value="<?php echo $password ?>"/></div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="rpassword">Re-type Your Password</label>

                                            <div class="controls">
                                                <div class="validation">
                                                    <input class="m-wrap placeholder-no-fix" type="password"
                                                           name="rpassword" id="rpassword"
                                                           value="<?php echo $password ?>"/></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="control-group">
                                        <label class="control-label" for="avatar">Avatar</label>

                                        <div class="controls">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="fileupload-new thumbnail">
                                                    <?php
                                                    $avatar = \Core\Helper::getUserAvatar((!empty($user) ? $user : []), 'medium');
                                                    ?>
                                                    <img src="<?php echo $avatar; ?>"/>
                                                </div>
                                                <div class="fileupload-preview fileupload-exists thumbnail"></div>
                                                <div class="file-upload-button-area">
                                       <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file" class="default" name="avatar" id="avatar"/></span>
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
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->

</div>
<!-- END PAGE -->

<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/js/user.js"></script>
<script>
    $(document).ready(function () {
        User.initManagement();
    });
</script>
</body>