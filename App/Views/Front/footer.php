
<!--<div class="container-fluid">
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
</div>-->

<footer class="container-fluid">
    <div class="row">
        <div class="col-md-12 text-center" id="footer">
            <span class="copyright d-block">2017 © THE WALL REPORT. ALL RIGHTS RESERVED.</span>
            <span class="back-to-top"><i class="fa fa-angle-up"></i></span>

        </div>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php
if(!isset($flowFlowInjector)){ ?>
    <script type="text/javascript" src="<?php echo \App\Config::W_FRONT_ASSETS ?>js/jquery-1.11.1.min.js"></script>
<?php } ?>
<script src="<?php echo \App\Config::W_FRONT_ASSETS ?>js/jquery-ui-1.12.1.min.js" type="text/javascript" ></script>
<script src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/jquery-validation/dist/jquery.validate.min.js" type="text/javascript" ></script>
<script src="<?php echo \App\Config::W_FRONT_ASSETS ?>js/bootstrap.min.js" type="text/javascript" ></script>
<script src="<?php echo \App\Config::W_FRONT_ASSETS ?>js/owl.carousel.min.js" type="text/javascript" ></script>
<script src="<?php echo \App\Config::W_FRONT_ASSETS ?>js/app.js" type="text/javascript" ></script>

<script type="text/javascript">
var search_url = "<?php echo \App\Config::W_ROOT.'search/' ?>";
var url = "<?php echo \App\Config::W_ROOT.'search-data'; ?>";
var spinner = "<?php echo \App\Config::W_FRONT_ASSETS.'images/loader.gif' ?>";
    $(document).ready(function () {
        // Manage sticky header
        App.manageHeader();
        // Show or hide the sticky footer button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 200) {
                $('.back-to-top').fadeIn(200);
            } else {
                $('.back-to-top').fadeOut(200);
            }
        });

        // Animate the scroll to top
        $('.back-to-top').click(function (event) {
            event.preventDefault();

            $('html, body').animate({scrollTop: 0}, 300);
        })

        $("#search-input").on("keyup", function (event) {
            var text = $('#search-input').val();
            var model_content = $('.modal-content').find('.model-body');
            if (text.length > 2) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {term: text},
                    beforeSend: function () {
                        $('.spinner').show();
                    },
                    success: function (data) {
                        $('.spinner').hide();
                        $(model_content).html(data);
                    }
                });
            }
        });
        $('#search-input').keyup(function (e) {
            if (e.keyCode == 13) {
                window.location.href = search_url + $('#search-input').val();
            }
        });
    });
</script>
<script id="dsq-count-scr" src="//thewallreport.disqus.com/count.js" async></script>
</body>
</html>
