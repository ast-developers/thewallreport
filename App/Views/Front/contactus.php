<?php
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
?>
<div class="row">
    <div class="col-lg-12 bg-white p-4 details-block">
        <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>
        <div class="details-content pb-4">
            <p>Get in touch and we'll get back to you as soon as we can. We look forward to hearing from you!</p>

            <h1>Contact Form</h1>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <form method="post" class="contact-us-form" action="<?php echo \App\Config::W_ROOT . "contact-us" ?>">
                    <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">

                    <div class="form-group">
                        <label for="name">Name<span class="text-danger">*</span></label>

                        <div class="validation">
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email<span class="text-danger">*</span></label>

                        <div class="validation">
                            <input type="text" name="email" class="form-control" id="email"></div>
                    </div>
                    <div class="form-group">
                        <label for="message">Message<span class="text-danger">*</span></label>

                        <div class="validation">
                            <textarea class="form-control" name="message" id="message" rows="4"></textarea></div>
                    </div>
                    <div class="form-group">
                        <label for="security_check">What is thirteen minus 6?<span class="text-danger">*</span></label>

                        <div class="validation">
                            <input type="text" name="security_check" class="form-control" id="security_check"></div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-black" id="button" value="Send">
                    </div>
                </form>
            </div>
            <div class="col-xl-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Email</label>

                    <div><a class="text-black" href="mailto:therealwallreport@gmail.com">therealwallreport@gmail.com</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
include(\App\Config::F_ROOT . 'App/Views/Front/footer.php');
?>
<script src="<?php echo \App\Config::W_FRONT_ASSETS ?>js/contactus.js"></script>
<script>
    $(document).ready(function () {
        ContatcUs.initList();
    });

</script>
