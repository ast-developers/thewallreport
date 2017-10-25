<?php
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
$getFeaturedBanners = Core\Helper::getFeaturedBanners();
$disqusPageUrl = \App\Config::W_ROOT . $post['slug'];
$disqusPageIdentifier = $post['slug'];
use Core\Helper;
?>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=<?php echo \App\Config::SHARE_ON_FACEBOOK_APP_ID ?>";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div class="row">
    <div class="col-lg-12 bg-white p-4 details-block">
        <div class="details-content pb-5">
            <?php $image = (!empty($post['profile_image'])) ? (\App\Config::S3_BASE_URL . \App\Config::S3_PROFILE_IMAGE_DIR . "/" . $post['profile_image']) : 'http://2.gravatar.com/avatar/b4b0cd6cbad741f702799b03c5a7e4ff?s=20&amp;d=mm&amp;r=g'; ?>
            <h1><?php echo $post['name'] ?></h1>

            <div class="cb-byline">
                <span class="cb-author"> <a href="#"><img alt="" src="<?php echo $image ?>"
                                                          class="avatar avatar-20 photo" height="20"
                                                          width="20"><?php echo $post['creator'] ?></a></span>
                <?php if ((!empty($post['published_at']))) { ?>
                    <span
                            class="cb-separator"><i class="fa fa-times"></i></span>
                    <span class="cb-date"><time
                                datetime="2017-02-03"><?php echo date("F j, Y", strtotime($post['published_at'])) ?></time></span>
                <?php } ?>

                <?php
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        ?>
                        <span class="cb-separator"><i
                                    class="fa fa-times"></i></span><span class="cb-category cb-element">
                    <a href="#"><?php echo $category ?></a></span>
                    <?php }
                } ?>
            </div>

            <div class="video video-block">
                <?php
                $helper = new Helper();
                $parsedDetail = $helper->parsePageDesc($post['description']);
                ?>
                <?php echo $parsedDetail; ?>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-8">

                <div class="d-block pb-4"><i class="fa fa-eye mr-2"></i>Post Views: <?php echo $post['views'] ?></div>
                <?php if (!empty($tags)) { ?>
                    <div class="d-block pb-4">
                        <ul class="tags-list pl-0">
                            <?php

                            foreach ($tags as $tag) {
                                ?>
                                <li>
                                    <a href="#"><?php echo $tag ?></a>
                                </li>
                            <?php }
                            ?>
                        </ul>
                    </div>
                <?php } ?>
                <div class="">
                    <?php
                    $slug = $post['slug'];
                    $header = $post['name'];
                    include_once(\App\Config::F_VIEW . 'Front/share_on_section.php'); ?>
                    <!-- Disqus Commenting Start -->
                    <div class="col-md-12">
                        <?php include_once(\App\Config::F_VIEW . 'Front/disqus.php'); ?>
                    </div>
                    <!-- Disqus Commenting End -->

                </div>
            </div>

            <div class="col-xl-4">
                <?php include_once(\App\Config::F_VIEW . 'Front/featured_post_right_side_bar.php'); ?>
            </div>
                </div>

    </div>
</div>
<?php
include(\App\Config::F_ROOT . 'App/Views/Front/footer.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        App.init();
    });
</script>
