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
?>
    <div class="row">
        <div class="col-lg-12 bg-white pr-4 pl-4 pb-4">
            <?php foreach ($banners as $key => $banner) { ?>
                <?php $parent_class = ($key % 2 == 0) ? '<div class="row no-gutters">' : '' ?>
                <?php $end_of_div = ($key % 2 == 0) ? '' : '</div>' ?>
                <?php $class = ($key % 2 == 0) ? ' col-xl-8 ' : ' col-xl-4 ' ?>
                <?php $image = (!empty($banner['featured_image'])) ? \App\Config::W_FEATURED_IMAGE_ROOT . $banner['featured_image'] : 'http://thewall.report/wp-content/themes/15zine/library/images/placeholders/placeholder-759x300.png' ?>
                <?php echo $parent_class ?>
                <div class="<?php echo $class; ?> grid-img">
                    <a href="<?php echo \App\Config::W_ROOT . $banner['slug'] ?>"><img src="<?php echo $image; ?>"></a>
                    <a href="<?php echo \App\Config::W_ROOT . $banner['slug'] ?>">
                        <div class="top-article">
                            <div class="article-content">
                                <h2><?php echo $banner['name'] ?></h2>

                                <div class="cb-byline">
                                    <span class="cb-author"><?php echo $banner['creator'] ?></span>
                                    <span class="times"><i class="fa fa-times"></i></span>
                                    <span
                                        class="cb-date"><?php echo date("F j, Y", strtotime($banner['published_at'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php echo $end_of_div ?>
            <?php } ?>
        </div>
    </div>

    <table width="100%">
        <tr>
            <td style="width: 300px;vertical-align: top;padding-top: 113px; background: black;">
                <?php
                $stream_id = isset($_REQUEST['stream']) ? $_REQUEST['stream'] : 1;
                $flowFlowInjector->stream($stream_id);
                ?>
            </td>

        </tr>
    </table>
<?php
include(\App\Config::F_ROOT . 'App/Views/Front/footer.php');
