<?php
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
$getFeaturedBanners = Core\Helper::getFeaturedBanners();
$disqusPageUrl = \App\Config::W_ROOT . $feed['post_id'];
$disqusPageIdentifier = $feed['post_id'];
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
    <div class="col-lg-12 bg-white p-4">
        <div class="details-content pb-5">
            <div class="cb-byline">
            </div>

            <div class="video pt-5">
                <?php
                if ($feed['post_type'] == 'youtube') { ?>
                    <iframe width="854" height="480" src="https://www.youtube.com/embed/<?php echo $feed['post_id'] ?>"
                            frameborder="0" allowfullscreen></iframe>
                <?php } else { ?>
                    <img src="<?php echo $feed['media_url']; ?>">
                <?php } ?>
            </div>
            <h1><?php echo $feed['post_header']; ?></h1>
            <p><?php echo $feed['post_text']; ?></p>
            <?php $user_name = (!empty($feed['user_screenname'])) ? $feed['user_screenname'] : $feed['user_nickname'] ?>
            <img src="<?php echo $feed['user_pic']; ?>" class="img-responsive img-thumbnail" alt="Cinque Terre"
                 style="width:65px;height:auto;"><span><?php echo $user_name ?></span>
            <p>Posted on <?php echo $feed['post_type'] . ': ' . date("F j", $feed['post_timestamp']); ?></p>
            <div class="ff-item-bar">
                <a href="<?php echo $feed['post_permalink'] ?>" class="ff-likes"><i
                            class="ff-icon-like"></i><?php echo json_decode($feed['post_additional'])->likes ?></a>
                <a href="<?php echo $feed['post_permalink'] ?>" class="ff-comments"><i
                            class="ff-icon-comment"></i><?php echo json_decode($feed['post_additional'])->comments ?>
                </a>
            </div>
            <div class="row">
                <div class="col-xl-12">

                    <div class="d-block pb-4"><i class="fa fa-eye mr-2"></i>Post Views: <?php echo $feed['views'] ?>
                    </div>
                    <div class="">
                        <?php
                        $slug = $feed['post_id'];
                        $header = $feed['post_header'];
                        include_once(\App\Config::F_VIEW . 'Front/share_on_section.php'); ?>
                        <!-- Disqus Commenting Start -->
                        <div class="col-md-12">
                            <?php include_once(\App\Config::F_VIEW . 'Front/disqus.php'); ?>
                        </div>
                        <!-- Disqus Commenting End -->
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
        App.init();
    });
</script>
