<?php
require_once(\App\Config::F_FLOW_FLOW_ROOT . 'ff-injector.php');
$flowFlowInjector = new FFInjector();
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
?>
<div class="row">
    <div class="col-lg-12 bg-white p-4">
        <div class="row">
            <?php $class = (!empty($page['show_featured_sidebar']) && $page['show_featured_sidebar'] == 1) ? 'col-xl-8' : 'col-xl-12' ?>
            <div class="<?php echo $class ?>">
                <div class="search-header">
                    <?php if (!empty($page['show_title']) && $page['show_title'] == 1) { ?>
                        <h1 class="search-title"><?php echo $page['name'] ?></h1>
                    <?php } ?>
                </div>
                <div class="row search-post-content no-gutters">
                    <?php
                    $cat = \Core\Helper::parseCategoryShortCode($page['description']);
                    $feed = \Core\Helper::parseFlowStreamShortCode($page['description']);
                    $featuredPost = \Core\Helper::getFeaturedPostByCategoryData($cat);
                    ?>
                    <div class="cb-module-f cb-all-big cb-module-block cb-module-fw clearfix">
                        <?php if (!empty($featuredPost)) { ?>
                            <div class="row">
                                <?php
                                foreach ($featuredPost as $post) {
                                    $image = \Core\Helper::getCMSFeaturedImage($post, '360x240');
                                    ?>
                                    <div class="col-sm-4">
                                        <a href="<?php echo \App\Config::W_ROOT . $post['slug']; ?>" class="model-blocks">
                                            <div class="block-details">
                                                <div class="block-name">
                                                    <?php echo $post['name'];  ?>
                                                </div>
                                                <div class="block-date">
                                                    <?php echo $post['published_at'];  ?>
                                                </div>
                                            </div>

                                            <img width="360" height="490"
                                                 src="<?php echo $image; ?>"
                                                 class="attachment-cb-360-490 size-cb-360-490 wp-post-image">
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                    $description = \Core\Helper::removeShortCodeFromDescription($page['description']);
                    echo $description ?>
                    <div class="col-lg-12"></div>
                </div>
            </div>
            <?php
                if (!empty($page['show_featured_sidebar']) && $page['show_featured_sidebar'] == 1) {
                    $getFeaturedBanners = Core\Helper::getFeaturedBanners();
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
