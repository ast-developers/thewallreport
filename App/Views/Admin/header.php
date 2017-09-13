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
    <link rel="shortcut icon" href="favicon.ico" />
</head>