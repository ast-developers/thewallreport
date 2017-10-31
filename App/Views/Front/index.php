<?php
/**
 * Flow-Flow
 *
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `FlowFlowAdmin.php`
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>
 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */
//Used for example moderation
$pageTitle = "A Real-Time Collection of News";
require_once(\App\Config::F_FLOW_FLOW_ROOT . 'ff-injector.php');
$flowFlowInjector = new FFInjector();
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
//$getBanners = Core\Helper::getFeaturedBanners();
$banners = array_chunk($getBanners,2);
?>
    <div class="row">
        <div class="col-lg-12 bg-white pr-4 pl-4 pb-4 mt-1 home-header-banner">
            <?php  if(!empty($banners[0])){
            foreach ($banners[0] as $key => $banner) { ?>
                <?php $parent_class = ($key % 2 == 0) ? '<div class="row no-gutters">' : '' ?>
                <?php $end_of_div = ($key % 2 == 0) ? '' : '</div>' ?>
                <?php $class = ($key % 2 == 0) ? ' col-md-8 ' : ' col-md-4 ' ?>
                <?php  $name = ($key % 2 == 0) ? '<h4>'.$banner['name'].'</h4>' : '<h4>'.$banner['name'].'</h4>'?>
                <?php $image = (!empty($banner['featured_image'])) ? (\Core\Helper::getFeaturedImage($banner)) : '' ?>
                <?php echo $parent_class ?>
                <div class="<?php echo $class; ?> grid-img">
                    <a href="<?php echo \App\Config::W_ROOT . $banner['slug'] ?>"><img src="<?php echo $image; ?>">
                        <div class="top-article">
                            <div class="article-content">
                                <?php echo $name ?>

                                <div class="cb-byline">
                                    <!--<span class="cb-author"><?php /*echo $banner['creator'] */?></span>
                                    <span class="times"><i class="fa fa-times"></i></span>-->
                                    <span class="cb-date"><?php echo date("F j, Y", strtotime($banner['published_at'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php echo $end_of_div ?>
            <?php } }?>

            <?php  if(!empty($banners[1])){
                foreach ($banners[1] as $key => $banner) { ?>
                    <?php $parent_class = ($key % 2 == 0) ? '<div class="row no-gutters">' : '' ?>
                    <?php $end_of_div = ($key % 2 == 0) ? '' : '</div>' ?>
                    <?php $class = ($key % 2 != 0) ? ' col-md-8 ' : ' col-md-4 ' ?>
                    <?php  $name = ($key % 2 != 0) ? '<h4>'.$banner['name'].'</h4>' : '<h4>'.$banner['name'].'</h4>'?>
                    <?php $image = (!empty($banner['featured_image'])) ? (\Core\Helper::getFeaturedImage($banner)) : '' ?>
                    <?php echo $parent_class ?>
                    <div class="<?php echo $class; ?> grid-img">
                        <a href="<?php echo \App\Config::W_ROOT . $banner['slug'] ?>"><img src="<?php echo $image; ?>">
                            <div class="top-article">
                                <div class="article-content">
                                    <?php echo $name; ?>

                                    <div class="cb-byline">
                                        <!--<span class="cb-author"><?php /*echo $banner['creator'] */?></span>
                                        <span class="times"><i class="fa fa-times"></i></span>-->
                                        <span class="cb-date"><?php echo date("F j, Y", strtotime($banner['published_at'])) ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php echo $end_of_div ?>
                <?php } }?>

            <?php if(!empty($advertisement['center'])){ ?>
                <div class="bottom-ads">
                    <?php if($advertisement['center']['type']=='banner'){ ?>
                        <img src="<?php echo (\App\Config::S3_BASE_URL . \App\Config::S3_ADVERT_IMAGE_DIR . "/" . $advertisement['center']['banner_image']); ?>">
                    <?php }else{
                        echo $advertisement['center']['adsense_code'];
                    } ?>
                </div>
            <?php } ?>

        </div>

        <?php if(!empty($advertisement['left'])){ ?>
            <div class="left-ads">
                <?php if($advertisement['left']['type']=='banner'){ ?>
                    <img src="<?php echo (\App\Config::S3_BASE_URL . \App\Config::S3_ADVERT_IMAGE_DIR . "/" . $advertisement['left']['banner_image']); ?>">
                <?php }else{
                    echo $advertisement['left']['adsense_code'];
                } ?>
            </div>
        <?php } ?>
        <?php if(!empty($advertisement['right'])){ ?>
            <div class="right-ads">
                <?php if($advertisement['right']['type']=='banner'){ ?>
                    <img src="<?php echo (\App\Config::S3_BASE_URL . \App\Config::S3_ADVERT_IMAGE_DIR . "/" . $advertisement['right']['banner_image']); ?>">
                <?php }else{
                    echo $advertisement['right']['adsense_code'];
                } ?>
            </div>
        <?php } ?>

    </div>
</div> <!-- /container -->

<div id="ff-stream-block">
    <table width="100%">
        <tr>
            <td>
                <?php
                $stream_id = isset($_REQUEST['stream']) ? $_REQUEST['stream'] : 1;
                $flowFlowInjector->stream($stream_id);
                ?>
            </td>

        </tr>
    </table>
</div>
<?php
include(\App\Config::F_ROOT . 'App/Views/Front/footer.php');
