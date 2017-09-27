<?php
$pageTitle = 'Contact Us';
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
use Core\Recaptcha;
$recaptcha = new Recaptcha();
?>
<div class="row">
    <div class="col-lg-12 bg-white p-4 details-block">
        <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>
      <div class="details-content pb-4">
            <h1>PAGE NOT FOUND... OOPS!</h1>
        </div>
    </div>
</div>
<?php
include(\App\Config::F_ROOT . 'App/Views/Front/footer.php');
?>

