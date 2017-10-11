<?php
require_once(\App\Config::F_FLOW_FLOW_ROOT . 'ff-injector.php');
$flowFlowInjector = new FFInjector();
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
use Core\Helper;
?>
<div class="row">
    <div class="col-lg-12 bg-white p-4">
        <div class="row">
            <?php $class = (!empty($page['show_featured_sidebar']) && $page['show_featured_sidebar'] == 1) ? 'col-xl-8' : 'col-xl-12' ?>
            <div class="<?php echo $class ?>">
                <div class="search-header">
                    <?php if (!empty($page['show_title']) && $page['show_title']) { ?>
                        <h1 class="search-title"><?php echo $page['name'] ?></h1>
                    <?php } ?>
                </div>
                <div class="row search-post-content no-gutters">
                    <?php
                    $helper = new Helper();
                    $parsedDetail = $helper->parsePageDesc($page['description']);
                    $feed = Helper::parseFlowStreamShortCode($page['description']);
                    ?>
                    <div class="cb-module-f cb-all-big cb-module-block cb-module-fw clearfix">
                        <?php echo $parsedDetail;?>
                    </div>
                    <div class="col-lg-12"></div>
                </div>
            </div>
            <?php
                if (!empty($page['show_featured_sidebar']) && $page['show_featured_sidebar'] == 1) {
                    $getFeaturedBanners = Helper::getFeaturedBanners();
                ?>
                <div class="col-xl-4">
                    <?php include_once(\App\Config::F_VIEW . 'Front/featured_post_right_side_bar.php'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div><!-- /container -->
<?php if(!empty($feed['0']['id'])){ ?>
    <div id="ff-stream-block">
        <table width="100%">
            <tr>
                <td>
                    <?php
                    $stream_id = $feed['0']['id'];
                    $flowFlowInjector->stream($stream_id);
                    ?>
                </td>

            </tr>
        </table>
    </div>
<?php } ?>
<?php
include(\App\Config::F_ROOT . 'App/Views/Front/footer.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        App.init();
    });
</script>
