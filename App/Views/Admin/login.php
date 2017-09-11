

<?php include(\App\Config::F_ROOT.'App/Views/Admin/header.php') ?>
<body class="login">
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php
    if(!empty($flash_message)){ ?>
        <div class="alert <?php $error_class ?>">
            <strong><?php $flash_message ?></strong>
        </div>
        <?php
    }
    ?>
    <form class="form-vertical login-form" method="post" action="login">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <h3 class="form-title">Login to your account</h3>
        <div class="alert alert-error hide">
            <button class="close" data-dismiss="alert"></button>
            <span>Enter any username and passowrd.</span>
        </div>
        <div class="control-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <div class="controls">
                <div class="input-icon left">
                    <i class="icon-user"></i>
                    <input class="m-wrap placeholder-no-fix" type="text" placeholder="Username" name="username"/>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="controls">
                <div class="input-icon left">
                    <i class="icon-lock"></i>
                    <input class="m-wrap placeholder-no-fix" type="password" placeholder="Password" name="password"/>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <label class="checkbox">
                <input type="checkbox" name="remember" value="1"/> Remember me
            </label>
            <button type="submit" name="submit" class="btn green pull-right">
                Login <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
        <div class="forget-password">
            <h4>Forgot your password ?</h4>
            <p>
                no worries, click <a href="javascript:;" class="" id="forget-password">here</a>
                to reset your password.
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    {#<form class="form-vertical forget-form" action="index.html">
        <h3 class="">Forget Password ?</h3>
        <p>Enter your e-mail address below to reset your password.</p>
        <div class="control-group">
            <div class="controls">
                <div class="input-icon left">
                    <i class="icon-envelope"></i>
                    <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" />
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn">
                <i class="m-icon-swapleft"></i> Back
            </button>
            <button type="submit" class="btn green pull-right">
                Submit <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>#}
    <!-- END FORGOT PASSWORD FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <!-- END REGISTRATION FORM -->
</div>
<?php include(\App\Config::F_ROOT.'App/Views/Admin/footer.php') ?>
<script type="text/javascript">

    jQuery(document).ready(function() {
        App.initLogin();
    });
</script>

</body>
