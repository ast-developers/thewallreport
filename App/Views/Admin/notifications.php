<?php
if(!empty($flash_message)){
    foreach($flash_message as $message) { ?>
        <div class="alert <?php echo $error_class; ?>">
            <strong><?php echo $message ?></strong>
        </div>
        <?php
    }
}
?>