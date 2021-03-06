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
                <?php if (!empty($data)) {
                    foreach ($data as $value) {
                        ?>
                        <div class="row search-post-content no-gutters">
                            <?php $image = (!empty($value['featured_image'])) ? ((\Core\Helper::getFeaturedImage($value))) : 'http://thewall.report/wp-content/themes/15zine/library/images/placeholders/placeholder-260x170.png'; ?>
                            <div class="col-md-4 format-audio">
                                <figure class="cb-mask"><a
                                        href="<?php echo \App\Config::W_ROOT . $value['slug'] ?>"><img
                                            src="<?php echo $image; ?>"></a></figure>
                            </div>
                            <div class="col-md-8 pl-md-4">
                                <h4><a href="#"><?php echo $value['name'] ?></a></h4>

                                <div class="cb-byline">
                                    <span class="cb-author"><?php echo $value['creator'] ?></span>

                                    <?php if ((!empty($value['published_at']))) { ?>
                                        <span class="times"><i class="fa fa-times"></i></span>
                                        <span
                                            class="cb-date"><?php echo date("F j, Y", strtotime($value['published_at'])) ?></span>
                                    <?php } ?>
                                </div>
                                <div class="cb-excerpt mt-3"><?php echo Core\Helper::getShortDescription($value['description']); ?></div>
                                <div class="cb-post-meta mt-3">
                                    <ul>
                                        <?php if (isset($value['category_name']) && $categories = (explode(',', $value['category_name']))) {
                                            if(!empty($categories[0])){
                                            foreach ($categories as $category) {
                                                ?>
                                                <li><a href=""><?php echo $category ?></a></li>

                                            <?php } } } ?>
                                        <li><a href="<?php echo \App\Config::W_ROOT.$value['slug']; ?>#disqus_thread" data-disqus-identifier="<?php echo $value['slug']; ?>">Comment</a></li>
                                    </ul>
                                </div>


                            </div>
                            <div class="col-lg-12">
                                <hr>
                            </div>
                        </div>
                    <?php }
                } ?>
                <nav class="cb-pagination clearfix">
                    <ul class="page-numbers">

                        <?php if (!empty($prev)) { ?>
                            <li><a class="prev page-numbers"
                                   href="<?php echo \App\Config::W_ROOT . 'search/' . $search_text . '/' . $prev ?>"><i
                                        class="fa fa-long-arrow-left"></i></a></li>
                        <?php } ?>
                        <?php if (!empty($total_pages)) {
                            for ($i = 1; $i <= $total_pages; $i++) {
                                ?>
                                <li><a class="page-numbers <?php echo ($current == $i) ? 'current' : '' ?>"
                                       href="<?php echo \App\Config::W_ROOT . 'search/' . $search_text . '/' . $i ?>"><?php echo $i ?></a>
                                </li>
                            <?php }
                        } ?>
                        <!--<li><span class="page-numbers dots">…</span></li>-->
                        <?php if (!empty($next)) { ?>
                            <li><a class="next page-numbers"
                                   href="<?php echo \App\Config::W_ROOT . 'search/' . $search_text . '/' . $next ?>"><i
                                        class="fa fa-long-arrow-right"></i></a></li>
                        <?php } ?>


                    </ul>
                </nav>

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
        App.init();
    });
</script>
