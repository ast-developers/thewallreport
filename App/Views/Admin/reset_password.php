<?php include(\App\Config::F_VIEW.'Admin/header.php') ?>
<body class="login">
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php include(\App\Config::F_VIEW.'Admin/notifications.php') ?>

    <form class="form-vertical register-form" method="post" action="<?php echo \App\Config::W_ROOT."admin/password-reset" ?>">
        <h3 class="">Reset your Password</h3>
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <div class="control-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="controls">
                <div class="input-icon left">
                    <i class="icon-lock"></i>
                    <input class="m-wrap placeholder-no-fix" type="password" id="register_password" placeholder="Password" name="password"/>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
            <div class="controls">
                <div class="input-icon left">
                    <i class="icon-ok"></i>
                    <input class="m-wrap placeholder-no-fix" type="password" placeholder="Re-type Your Password" name="rpassword"/>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" name="submit" id="register-submit-btn" class="btn green pull-right">
                Reset Password <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>

</div>
<?php include(\App\Config::F_VIEW.'Admin/footer.php') ?>
<script type="text/javascript">

    jQuery(document).ready(function() {
        App.initLogin();
    });
</script>

</body>
