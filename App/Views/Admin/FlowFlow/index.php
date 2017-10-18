<?php
$pagetitle = 'Flow-FLow';
require_once(\App\Config::F_FLOW_FLOW_ROOT.'ff-injector.php');
$flowFlowInjector = new FFInjector(true);
include(\App\Config::F_ROOT . 'App/Views/Admin/header.php') ?>

    <!-- BEGIN PAGE -->
    <div class="page-content">
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">

            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">
                    <h3 class="page-title">
                        Social River
                    </h3>
                </div>
            </div>
            <!-- END PAGE HEADER-->

            <?php include(\App\Config::F_VIEW . 'Admin/notifications.php') ?>

            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12 responsive" data-tablet="span12 fix-offset" data-desktop="span12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <?php $flowFlowInjector->admin("Stream River - Social Streams Plugin"); ?>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT-->

        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->

<?php include(\App\Config::F_ROOT . 'App/Views/Admin/footer.php') ?>

<script>
    $(document).ready(function () {
        App.init();
    });
</script>
</body>


