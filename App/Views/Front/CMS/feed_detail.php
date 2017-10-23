<?php
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
$getFeaturedBanners = Core\Helper::getFeaturedBanners();
$disqusPageUrl = \App\Config::W_ROOT . 'feed/' . $feed['post_id'] . '/' . $feed['feed_id'];
$disqusPageIdentifier = $feed['post_id'] . '_' . $feed['feed_id'];
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
        <div class="row">
            <div class="col-lg-7 m-auto">
                <div class="details-content feed-details pb-5">
                    <div class="video pb-4">
                        <?php
                        if ($feed['post_type'] == 'youtube') { ?>
                            <iframe width="100%" height="350"
                                    src="https://www.youtube.com/embed/<?php echo $feed['post_id'] ?>"
                                    frameborder="0" allowfullscreen></iframe>
                        <?php } else {
                                if (strpos($feed['media_type'], 'video') !== false) {
                                    ?>
                                    <video width="100%" height="350" controls>
                                        <source src="<?php echo $feed['media_url']; ?>">
                                        Your browser does not support the video tag.
                                    </video>
                                    <?php
                                } else {
                                    ?>
                                    <img src="<?php echo $feed['media_url']; ?>">
                                    <?php
                                }
                        } ?>
                    </div>
                    <h1><?php echo $feed['post_header']; ?></h1>
                    <p><?php echo $feed['post_text']; ?></p>
                    <?php $user_name = (!empty($feed['user_screenname'])) ? $feed['user_screenname'] : $feed['user_nickname'] ?>
                    <div class="user-info mt-4">
                        <figure class="user-pic">
                            <img src="<?php echo $feed['user_pic']; ?>" class="" alt=""/></figure>
                        <span class="user-name"><?php echo $user_name ?></span>
                        Posted on <?php echo $feed['post_type'] . ': ' . date("M j", $feed['post_timestamp']); ?>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="ff-item-bar">
                                <?php if(isset(json_decode($feed['post_additional'])->views)){ ?>
                                    <span class="ff-views"><i
                                                class="ff-icon-view"></i>
                                        <span><?php echo json_decode($feed['post_additional'])->views ?></span></span>
                                <?php } ?>
                                <span class="ff-likes"><i
                                            class="ff-icon-like"></i><?php echo json_decode($feed['post_additional'])->likes ?>
                                </span>
                                <span href="<?php echo $feed['post_permalink'] ?>" class="ff-comments"><i
                                            class="ff-icon-comment"></i><?php echo json_decode($feed['post_additional'])->comments ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 text-sm-right">
                            <div class="feed-social">
                                <ul>
                                    <li>
                                        <a href="http://www.facebook.com/sharer.php?u=<?php echo \App\Config::W_ROOT.'feed/'.$feed['post_id'].'/'.$feed['feed_id'] ?>"><i
                                                    class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/share?url=<?php echo \App\Config::W_ROOT.'feed/'.$feed['post_id'].'/'.$feed['feed_id'] ?>"><i
                                                    class="fa fa-twitter"></i></a></li>
                                    <li>
                                        <a href="https://plus.google.com/share?url=<?php echo \App\Config::W_ROOT.'feed/'.$feed['post_id'].'/'.$feed['feed_id'] ?>"><i
                                                    class="fa fa-google-plus"></i> </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xl-12">
                            <div class="d-block pb-4 mt-5"><i class="fa fa-eye mr-2"></i>Post
                                Views: <?php echo $feed['views'] ?>
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
