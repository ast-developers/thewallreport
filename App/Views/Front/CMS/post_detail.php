<?php
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
$getFeaturedBanners = Core\Helper::getFeaturedBanners();
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
            <?php $image = (!empty($post['profile_image'])) ? \App\Config::W_USER_AVATAR_ROOT . $post['profile_image'] : 'http://2.gravatar.com/avatar/b4b0cd6cbad741f702799b03c5a7e4ff?s=20&amp;d=mm&amp;r=g'; ?>
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

            <div class="video pt-5">

                <?php echo $post['description']; ?>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-8">

                <div class="d-block pb-4"><i class="fa fa-eye mr-2"></i>Post Views: <?php echo $post['views'] ?></div>

                <div class="d-block pb-4">
                    <ul class="tags-list pl-0">
                        <?php
                        if (!empty($tags)) {
                            foreach ($tags as $tag) {
                                ?>
                                <li>
                                    <a href="#"><?php echo $tag ?></a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
                <div class="">

                    <div class="col-lg-12 share-post-block-bg p-4 mb-4">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-4">
                                <h4>SHARE ON</h4>
                            </div>
                            <div class="col-md-8 d-flex align-items-center justify-content-md-end">
                                <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/"
                                     data-layout="button_count"></div>

                                <iframe
                                    src="https://platform.twitter.com/widgets/tweet_button.html?size=l&url=<?php echo \App\Config::W_ROOT . $post['slug'] ?>&related=twitterapi%2Ctwitter&text=<?php echo $post['name'] ?> The Wall Report"
                                    width="95"
                                    height="40"
                                    title="Twitter Share Button"
                                    data-size="default"
                                    style="border: 0; overflow: hidden!important;"
                                    class="Twitter-Share-Button"
                                    >
                                </iframe>
                                <a style="margin-right: 15px;" data-pin-do="buttonPin"
                                   href="https://www.pinterest.com/pin/create/button/?url=<?php echo \App\Config::W_ROOT . $post['slug'] ?>"
                                   data-pin-height="28"></a>
                                <g:plusone size="tall"></g:plusone>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-4">
                <div class="featured-section">
                    <h4>Featured</h4>

                    <div class="owl-carousel owl-theme">
                        <?php if (!empty($getFeaturedBanners)) {
                            foreach ($getFeaturedBanners as $banner) {
                                $image = (!empty($banner['featured_image'])) ? \App\Config::W_FEATURED_IMAGE_ROOT . $banner['featured_image'] : 'http://thewall.report/wp-content/themes/15zine/library/images/placeholders/placeholder-360x240.png';
                                ?>
                                <div class="item">
                                    <figure><a href="#"><img src="<?php echo $image; ?>"></a>
                                    </figure>
                                    <h5><a href="#"><?php echo $banner['name'] ?></a></h5>
                                <span class="cb-date"><time class="updated"
                                                            datetime="2017-06-30"><?php echo date("F j, Y", strtotime($banner['published_at'])) ?></time></span>
                                </div>
                            <?php }
                        } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
include(\App\Config::F_ROOT . 'App/Views/Front/footer.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            loop: true,
            items: 1,
            margin: 10,
            nav: true,
            smartSpeed: 800
            //autoHeight:true
        })
    });
</script>
