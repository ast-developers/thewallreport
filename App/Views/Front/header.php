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
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo (isset($pageTitle)?($pageTitle.' - '.\App\Config::PAGE_TITLE_PREFIX):\App\Config::PAGE_TITLE_PREFIX); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo \App\Config::W_FRONT_ASSETS ?>css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Open+Sans:400,400i,600,600i,700,700i,800,800i"
          rel="stylesheet">
    <link href="<?php echo \App\Config::W_FRONT_ASSETS ?>css/owl.carousel.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo \App\Config::W_FRONT_ASSETS ?>css/responsive.css" rel="stylesheet">
    <link href="<?php echo \App\Config::W_FRONT_ASSETS ?>css/style.css" rel="stylesheet">
    <link href="<?php echo \App\Config::W_FRONT_ASSETS ?>css/owl.carousel.min.css" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script
        type="text/javascript"
        async defer
        src="//assets.pinterest.com/js/pinit.js"
        ></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
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
                <a href="#" data-toggle="modal" data-target="#searchModal" title="Search" class="search-bar text-white text-uppercase float-right"><i
                        class="fa fa-search mr-2"></i>Search</a>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <button type="button" class="close-search-bar" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&#10006;</span>
                    </button>
                    <div class="modal-content">

                        <div class="modal-body p-0">
                            <input type="text" id="text" class="form-control" placeholder="Search...">
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12 p-4 bg-white">
                <img src="<?php echo \App\Config::W_FRONT_ASSETS ?>images/Logo.png">
            </div>
            <div class="col-lg-12 bg-white">
                <nav class="navbar navbar-toggleable-sm navbar-light">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                            data-target="#navbar-top" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand hidden-md-up" href="#"><img src="<?php echo \App\Config::W_FRONT_ASSETS ?>images/Logo.png"></a>
                    <div class="collapse navbar-collapse" id="navbar-top">
                        <ul class="navbar-nav m-auto">

                            <?php if(!empty($menus)){
                                foreach($menus as $key=>$menu){
                             ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $menu['slug'] ?>"><?php echo $menu['name'] ?></a>
                            </li>
                            <?php } } ?>
                        </ul>

                    </div>
                </nav>
            </div>
        </div>
    </header>
