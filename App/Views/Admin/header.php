<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title><?php echo (isset($pageTitle)?($pageTitle.' - '.\App\Config::PAGE_TITLE_PREFIX):\App\Config::PAGE_TITLE_PREFIX); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/metro.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/style.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/style_responsive.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/style_default.css" rel="stylesheet" id="style_color" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/jquery-tags-input/jquery.tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/data-tables/jquery.dataTables.css" rel="stylesheet" />
    <link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet">
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/redactor/css/redactor.css" rel="stylesheet" />
    <!-- Tokenfield CSS -->
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/tokenfield-typeahead.css" type="text/css" rel="stylesheet">
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/bootstrap-tokenfield.css" type="text/css" rel="stylesheet">
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/custom.css" rel="stylesheet" />
    <link rel="shortcut icon" href="favicon.ico" />

    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript" ></script>
    <script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/redactor/js/redactor.js"></script>
    <script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/redactor/js/video.js"></script>
    <script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/redactor/js/inlinestyle.js"></script>
    <script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/redactor/js/source.js"></script>
    <script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/redactor/js/alignment.js"></script>
    <script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/redactor/js/table.js"></script>
    <script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/redactor/js/fullscreen.js"></script>
    <script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/redactor/js/fontsize.js"></script>
    <script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/redactor/js/fontcolor.js"></script>
    <?php
    if(isset($flowFlowInjector)){
        echo $flowFlowInjector->head(true, true, false);
    }
     ?>
</head>

<?php
/* For Logged in User only, also check footer.php if any changes made here. */
if(isset($_SESSION['user'])){
    $sessionUser = \App\Models\PrivilegedUser::getByUsername($_SESSION['user']['username']);
    ?>
    <body class="fixed-top">

    <!-- BEGIN HEADER -->
    <?php include(\App\Config::F_ROOT . 'App/Views/Admin/topbar.php'); ?>
    <!-- END HEADER -->

    <!-- BEGIN CONTAINER -->
    <div class="page-container row-fluid">

        <!-- BEGIN SIDEBAR -->
        <?php include(\App\Config::F_ROOT . 'App/Views/Admin/sidebar.php') ?>
        <!-- END SIDEBAR -->
<?php } ?>
