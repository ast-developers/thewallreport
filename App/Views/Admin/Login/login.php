<?php
$pagetitle = 'Login';
include(\App\Config::F_VIEW . 'Admin/header.php') ?>
<body class="login">
<div class="content">
    <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>
    <!-- BEGIN LOGIN FORM -->
    <?php include(\App\Config::F_VIEW . 'Admin/Login/Partials/loginForm.php') ?>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <?php include(\App\Config::F_VIEW . 'Admin/Login/Partials/forgotPasswordForm.php') ?>
    <!-- END FORGOT PASSWORD FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <!-- END REGISTRATION FORM -->
</div>
<?php include(\App\Config::F_VIEW . 'Admin/footer.php') ?>
<script type="text/javascript">

    jQuery(document).ready(function () {
        App.initLogin();
    });
</script>

</body>
