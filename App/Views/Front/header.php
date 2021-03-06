<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en-US"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php if(!empty($feed['post_header'])){
        echo '<meta property="og:title" content="'.str_replace("'","",strip_tags($feed['post_header'])).'" />';
    }
    ?>
    <?php if(!empty($feed['post_text'])){
        echo "<meta property='og:description' content='".str_replace("'","",strip_tags($feed['post_text']))."'/>";
    }
    ?>
    <?php if(!empty($feed['image_url'])){
        echo '<meta property="og:image" content="'.str_replace("'","",strip_tags($feed['image_url'])).'" />';
    }
    ?>
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo (isset($pageTitle)?($pageTitle.' - '.\App\Config::PAGE_TITLE_PREFIX):\App\Config::PAGE_TITLE_PREFIX); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo \App\Config::W_FRONT_ASSETS ?>css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Open+Sans:400,400i,600,600i,700,700i,800,800i"
          rel="stylesheet">
    <link href="<?php echo \App\Config::W_FRONT_ASSETS ?>css/owl.carousel.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo \App\Config::W_FRONT_ASSETS ?>css/style.css" rel="stylesheet">
    <link href="<?php echo \App\Config::W_FRONT_ASSETS ?>css/responsive.css" rel="stylesheet">
    <link href="<?php echo \App\Config::W_ROOT ?>plugins/flow-flow/flow-flow/css/public.css" rel="stylesheet">
    <link href="<?php echo \App\Config::W_FRONT_ASSETS ?>css/owl.carousel.min.css" rel="stylesheet">
    <script src='//www.google.com/recaptcha/api.js'></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="//www.googletagmanager.com/gtag/js?id=UA-100764425-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-100764425-1');
    </script>
    <script
        type="text/javascript"
        async defer
        src="//assets.pinterest.com/js/pinit.js"
        ></script>
    <script src="//apis.google.com/js/platform.js" async defer></script>
    <?php
    if(isset($flowFlowInjector)){
        echo $flowFlowInjector->head(true);
    }
    $menus = Core\Helper::getMenus();
    ?>
</head>

<body>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="container">
    <header id="header">
        <div class="row">
            <div class="col-lg-12 top-bar">
                <span class="hidden-md-up nav-bars open-nav"><i class="fa fa-bars"></i></span>
                <a href="#" data-toggle="modal" data-target="#searchModal" title="Search" class="search-bar text-white text-uppercase float-right"><i
                        class="fa fa-search mr-2"></i><span class="hidden-sm-down">Search</span></a>
            </div>
            <!-- Search Modal -->
            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <button type="button" class="close-search-bar" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&#10006;</span>
                    </button>
                    <div class="modal-content">

                        <div class="p-0">
                            <input type="text" id="search-input" class="form-control" placeholder="Search...">
                        </div>

                        <div class="spinner text-center" style="display: none;"><img src='<?php echo \App\Config::W_FRONT_ASSETS.'images/loader.gif' ?>' /></div>
                        <div class="model-body"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 p-4 bg-white logo">
                <a href="<?php echo App\Config::W_ROOT; ?>"><img src="<?php echo \App\Config::W_FRONT_ASSETS ?>images/Logo.png"></a>
            </div>
            <div class="col-lg-12 bg-white">
                <nav class="navbar navbar-toggleable-sm navbar-light sidenav sidenav-tran" id="mySidenav">
                    <a href="javascript:void(0)" class="close-nav hidden-md-up">×</a>
                    <a class="navbar-brand sticky-logo hidden-sm-down" href="#"><img src="<?php echo \App\Config::W_FRONT_ASSETS ?>images/logo-scrolled.png"></a>
                        <ul class="navbar-nav m-md-auto">

                            <?php if(!empty($menus)){
                                foreach($menus as $key=>$menu){
                                $link = ($menu['type'] == 1 || $menu['type'] == 2) ? (\App\Config::W_ROOT.$menu['slug']) : $menu['slug'];
                             ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $link; ?>" target="<?php echo ($menu['new_tab'] ? '_blank' : '');?>"><?php echo $menu['name'] ?></a>
                            </li>
                            <?php } } ?>
                        </ul>
                </nav>
            </div>
        </div>
    </header>
