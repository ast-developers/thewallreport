<div class="featured-section">
    <h4>Featured</h4>

    <div class="owl-carousel owl-theme">
        <?php if (!empty($getFeaturedBanners)) {
            foreach ($getFeaturedBanners as $banner) {
                $image = \Core\Helper::getCMSFeaturedImage($banner, '360x240');
                ?>
                <div class="item">
                    <figure><a href="<?php echo \App\Config::W_ROOT . $banner['slug'] ?>"><img src="<?php echo $image; ?>"></a></figure>
                    <h5>
                        <a href="<?php echo \App\Config::W_ROOT . $banner['slug'] ?>"><?php echo $banner['name'] ?></a>
                    </h5>
                    <span class="cb-date">
                        <time class="updated" datetime="2017-06-30"><?php echo date("F j, Y", strtotime($banner['published_at'])) ?></time>
                    </span>
                </div>
            <?php }
        } ?>
    </div>
</div>