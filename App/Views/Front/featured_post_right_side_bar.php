<div class="featured-section">
    <h4>Featured</h4>

    <div class="owl-carousel owl-theme">
        <?php if (!empty($getFeaturedBanners)) {
            foreach ($getFeaturedBanners as $banner) {
                $image = (!empty($banner['featured_image'])) ? \App\Config::W_FEATURED_IMAGE_ROOT . $banner['featured_image'] : \App\Config::W_FRONT_ASSETS . 'images/placeholder-360x240.png';
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