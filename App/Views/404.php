<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title><?php echo \App\Config::PAGE_TITLE_PREFIX . (isset($pagetitle) ? (' | ' . $pagetitle) : ''); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link href="<?php echo \App\Config::W_ADMIN_ASSETS ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body class="fixed-top">
<div class="page-container row-fluid">
    <div class="page-content">
        <div class="container-fluid">
            <div class="span12">
                <div class="row-fluid page-404">
                    <div class="span5 number"></div>
                    <div class="span7 details">
                        <h3>Opps, You're lost.</h3>
                        <p>
                            <?php
                            if($message) {
                                echo $message;
                            } else {
                                ?>We can not find the page you're looking for.<br> Is there a typo in the url?<?php
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
