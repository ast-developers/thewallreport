<?php
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
$getFeaturedBanners = Core\Helper::getFeaturedBanners();
?>
<div class="row">
    <div class="col-lg-12 bg-white p-4">
        <div class="row">
            <div class="col-xl-8">
                <div class="search-header">
                    <h1 class="search-title"><?php echo $page['name'] ?></h1>
                </div>
                <div class="row search-post-content no-gutters">
                    <?php echo $page['description']; ?>
                    <div class="col-lg-12"></div>
                </div>
            </div>

            <div class="col-xl-4">
                <?php include_once (\App\Config::F_VIEW.'Front/featured_post_right_side_bar.php');?>
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
