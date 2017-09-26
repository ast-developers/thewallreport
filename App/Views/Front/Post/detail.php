<?php
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
$getFeaturedBanners = Core\Helper::getFeaturedBanners();
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=516509108520777";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div class="row">
    <div class="col-lg-12 bg-white p-4 details-block">
        <div class="details-content pb-5">
            <?php $image = (!empty($post['profile_image'])) ? \App\Config::W_USER_AVATAR_ROOT.$post['profile_image'] : 'http://2.gravatar.com/avatar/b4b0cd6cbad741f702799b03c5a7e4ff?s=20&amp;d=mm&amp;r=g'; ?>
            <h1><?php echo $post['name'] ?></h1>
            <div class="cb-byline">
                <span class="cb-author"> <a href="#"><img alt="" src="<?php echo $image ?>" class="avatar avatar-20 photo" height="20" width="20"><?php echo $post['creator'] ?></a></span><span
                    class="cb-separator"><i class="fa fa-times"></i></span><span class="cb-date"><time
                        datetime="2017-02-03"><?php echo date("F j, Y", strtotime($post['published_at'])) ?></time></span><span class="cb-separator"><i
                        class="fa fa-times"></i></span><span class="cb-category cb-element"><!--<a
                        href="#" >Hip Hop</a>--></span></div>

            <div class="video pt-5">

                <?php echo $post['description']; ?>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-8">
                <i class="fa fa-eye mr-2"></i>Post Views: <?php echo $post['views'] ?>
                </br>
                <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
            </div>
            <div class="col-xl-4">
                <div class="featured-section">
                    <h4>Featured</h4>

                    <div class="owl-carousel owl-theme">
                        <?php if(!empty($getFeaturedBanners)){
                            foreach($getFeaturedBanners as $banner){
                                $image = (!empty($banner['featured_image'])) ? \App\Config::W_FEATURED_IMAGE_ROOT . $banner['featured_image'] : 'http://thewall.report/wp-content/themes/15zine/library/images/placeholders/placeholder-360x240.png';
                            ?>
                                <div class="item">
                                    <figure><a href="#"><img src="<?php echo $image; ?>"></a>
                                    </figure>
                                    <h5><a href="#"><?php echo $banner['name'] ?></a></h5>
                                <span class="cb-date"><time class="updated"
                                                            datetime="2017-06-30"><?php echo date("F j, Y", strtotime($banner['published_at'])) ?></time></span>
                                </div>
                        <?php } } ?>
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
    $(document).ready(function() {
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
