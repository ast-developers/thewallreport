<?php
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
$getFeaturedBanners = Core\Helper::getFeaturedBanners();
?>
<div class="row">
    <div class="col-lg-12 bg-white p-4">
        <div class="row">
            <div class="col-xl-8">
                <div class="search-header">
                    <h5>SEARCH RESULTS FOR </h5>
                    <h1 class="search-title"><?php echo $search_text; ?></h1>
                </div>
                <?php if(!empty($data)){
                    foreach($data as $value){
                    ?>
                        <div class="row search-post-content no-gutters">
                            <?php $image = (!empty($value['featured_image'])) ? \App\Config::W_FEATURED_IMAGE_ROOT . $value['featured_image'] : 'http://thewall.report/wp-content/themes/15zine/library/images/placeholders/placeholder-260x170.png'; ?>
                            <div class="col-md-4 format-audio">
                                <figure class="cb-mask"><a href="<?php echo \App\Config::W_ROOT.$value['slug'] ?>"><img src="<?php echo $image; ?>"></a></figure>
                            </div>
                            <div class="col-md-8 pl-md-4">
                                <h4><a href="#"><?php echo $value['name'] ?></a></h4>
                                <div class="cb-byline">
                                    <span class="cb-author"><?php echo $value['creator'] ?></span>

                                    <?php if ((!empty($value['published_at']))) { ?>
                                        <span class="times"><i class="fa fa-times"></i></span>
                                        <span class="cb-date"><?php echo date("F j, Y", strtotime($value['published_at'])) ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-12"><hr></div>
                        </div>
                <?php } } ?>
                <nav class="cb-pagination clearfix"><ul class="page-numbers">
                            <li><a class="prev page-numbers" href="<?php echo \App\Config::W_ROOT.'search/'.$search_text.'/1' ?>"><i class="fa fa-long-arrow-left"></i></a></li>

                        <?php for($i=1;$i<=$total_pages;$i++){ ?>
                            <li><a class="page-numbers" href="<?php echo \App\Config::W_ROOT.'search/'.$search_text.'/'.$i ?>"><?php echo $i ?></a></li>
                        <?php } ?>
                        <li><span class="page-numbers dots">…</span></li>
                        <?php if(!empty($total_pages)){ ?>
                            <li><a class="next page-numbers" href="<?php echo \App\Config::W_ROOT.'search/'.$search_text.'/'.$total_pages ?>"><i class="fa fa-long-arrow-right"></i></a></li>
                        <?php } ?>


                    </ul>
                </nav>

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
