</div> <!-- /container -->
<div class="container-fluid">
    <section>
        <div class="row">
            <div class="col-lg-12">
                <div class="ff-filter-holder">
                    <span class="ff-filter ff-type-all ff-filter--active">All</span>
                    <span class="ff-filter ff-type-instagram" data-filter="instagram"><i
                            class="fa fa-instagram"></i></span>
                    <span class="ff-filter ff-type-twitter" data-filter="twitter"><i class="fa fa-twitter"></i></span>
                    <span class="ff-filter ff-type-youtube" data-filter="youtube"><i
                            class="fa fa-youtube-play"></i></span>
                    <span class="ff-search"><input type="text" placeholder="Search" class="form-control"></span>
                </div>

            </div>
        </div>
    </section>
</div>

<footer id="footer" class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <span class="copyright d-block">2017 © THE WALL REPORT. ALL RIGHTS RESERVED.</span>
            <span class="back-to-top"><i class="fa fa-angle-up"></i></span>

        </div>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/public/theme/front/assets/js/jquery-1.8.3.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script src="<?php echo \App\Config::W_FRONT_ASSETS ?>js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Show or hide the sticky footer button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 200) {
                $('.back-to-top').fadeIn(200);
            } else {
                $('.back-to-top').fadeOut(200);
            }
        });

        // Animate the scroll to top
        $('.back-to-top').click(function(event) {
            event.preventDefault();

            $('html, body').animate({scrollTop: 0}, 300);
        })
    });
</script>

</body>
</html>