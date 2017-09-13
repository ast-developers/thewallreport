<form class="form-vertical forget-form" method="post"
      action="<?php echo \App\Config::W_ROOT . "admin/forgot-password" ?>">
    <input type="hidden" name="token" value="<?php echo \Core\Csrf::getToken(); ?>">

    <h3 class="">Forget Password ?</h3>

    <p>Enter your e-mail address below to reset your password.</p>

    <div class="control-group">
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-envelope"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email"/>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="button" id="back-btn" class="btn">
            <i class="m-icon-swapleft"></i> Back
        </button>
        <button type="submit" name="submit" class="btn green pull-right">
            Submit <i class="m-icon-swapright m-icon-white"></i>
        </button>
    </div>
</form>

