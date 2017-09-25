<?php
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
?>
<div class="row">
    <div class="col-lg-12 bg-white p-4 details-block">
        <div class="details-content pb-5">
            <h1><?php echo $post['name'] ?></h1>
            <div class="cb-byline">
                <span class="cb-author"> <a href="#"><img alt="" src="http://2.gravatar.com/avatar/b4b0cd6cbad741f702799b03c5a7e4ff?s=20&amp;d=mm&amp;r=g" class="avatar avatar-20 photo" height="20" width="20"><?php echo $post['name'] ?></a></span><span
                    class="cb-separator"><i class="fa fa-times"></i></span><span class="cb-date"><time
                        datetime="2017-02-03"><?php echo date("F j, Y", strtotime($post['created_at'])) ?></time></span><span class="cb-separator"><i
                        class="fa fa-times"></i></span><span class="cb-category cb-element"><!--<a
                        href="#" >Hip Hop</a>--></span></div>

            <div class="video pt-5">

                <?php echo $post['description']; ?>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-8">
                <i class="fa fa-eye mr-2"></i>Post Views: 77

            </div>
            <div class="col-xl-4">
                <div class="featured-section">
                    <h4>Featured</h4>

<!--                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <figure><a href="#"><img
                                        src="http://thewall.report/wp-content/uploads/2017/06/maxresdefault-1-360x240.jpg"></a>
                            </figure>
                            <h5><a href="#">“Respect Life” – Season 3 – Episode 1</a></h5>
                                <span class="cb-date"><time class="updated"
                                                            datetime="2017-06-30">June 30, 2017</time></span>
                        </div>
                        <div class="item">
                            <figure><a href="#"><img
                                        src="http://thewall.report/wp-content/uploads/2017/06/maxresdefault-1-360x240.jpg"></a>
                            </figure>
                            <h5><a href="#">“Respect Life” – Season 3 – Episode 1</a></h5>
                                <span class="cb-date"><time class="updated"
                                                            datetime="2017-06-30">June 30, 2017</time></span>
                        </div>
                        <div class="item">
                            <figure><a href="#"><img
                                        src="http://thewall.report/wp-content/uploads/2017/06/maxresdefault-1-360x240.jpg"></a>
                            </figure>
                            <h5><a href="#">“BLAC CHYNA AND ROB OFF THE RAILS, 50 CENT REVIEWS 4:44, GENERATION
                                    BATTLE + MORE</a></h5>
                                <span class="cb-date"><time class="updated"
                                                            datetime="2017-06-30">June 30, 2017</time></span>
                        </div>

                    </div>-->

                </div>
            </div>
        </div>
    </div>
</div>
<?php
include(\App\Config::F_ROOT . 'App/Views/Front/footer.php');
?>
