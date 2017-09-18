<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title><?php echo \App\Config::PAGE_TITLE_PREFIX.(isset($pagetitle)?(' | '.$pagetitle):''); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/metro.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/style.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/style_responsive.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/css/style_default.css" rel="stylesheet" id="style_color" />
    <link rel="stylesheet" type="text/css" href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/uniform/css/uniform.default.css" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap-daterangepicker/daterangepicker.css" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/chosen-bootstrap/chosen/chosen.css" />
    <!--<link rel="stylesheet" href="<?php /*echo \App\Config::W_ADMIN_ASSETS */?>/data-tables/DT_bootstrap.css" />-->
    <!--<link rel="stylesheet" href="<?php /*echo \App\Config::W_ADMIN_ASSETS */?>/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />-->
    <link rel="stylesheet" type="text/css" href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/clockface/css/clockface.css" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/jquery-tags-input/jquery.tagsinput.css" />
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/data-tables/jquery.dataTables.css" rel="stylesheet" />
    <link rel="shortcut icon" href="favicon.ico" />

    <?php
    if(isset($flowFlowInjector)){
        echo $flowFlowInjector->head(true, true, false);
    }
     ?>
</head>

<?php
/* For Logged in User only, also check footer.php if any changes made here. */
if(isset($_SESSION['user'])){ ?>
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
