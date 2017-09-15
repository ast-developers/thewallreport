<?php
if(!empty($flash_message)){
    foreach($flash_message as $message) { ?>
        <div class="alert <?php echo $error_class; ?>">
            <strong><?php echo $message ?></strong>
        </div>
        <?php
    }
}

if(!empty($_SESSION['flash_message'])){
    foreach($_SESSION['flash_message'] as $message) { ?>
        <div class="alert <?php echo $_SESSION['error_class']; ?>">
            <strong><?php echo $message ?></strong>
        </div>
        <?php
    }
    unset($_SESSION['flash_message']);
    unset($_SESSION['error_class']);
}


?>