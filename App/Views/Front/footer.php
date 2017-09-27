
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

<footer>
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
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<?php } ?>
<script type="text/javascript"
        src="<?php echo \App\Config::W_ADMIN_ASSETS ?>/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo \App\Config::W_FRONT_ASSETS ?>js/bootstrap.min.js"></script>

<script type="text/javascript">
var url = "<?php echo \App\Config::W_ROOT.'search-data'; ?>";
    $(document).ready(function () {
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

        // Search result
        if($("#search-input").length>0){

            $("#search-input").autocomplete({
                source: function (request, response) {
                    if ($.trim(request.term) != "") {
                        append_response_data(request, response);
                    }
                },
                minLength: 3,
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                console.log(item);
                var inner_html = '<div class="col-md-4"><div class="thumbnail"><a href="/w3images/lights.jpg"><img src="http://local.thewall.report/uploads/featured_image/budda-quotes-on-life-fb-quotes-web-and-twitter-banner-SOUL.jpg" alt="Lights" style="width:100%"><div class="caption"><p>Lorem ipsum...</p></div></a></div></div>';
                return $("<li></li>")
                    .data("ui-autocomplete-item", item)
                    .append('<div class="row">'+inner_html+'</div>')
                    .appendTo(ul);
            };
        }

        function append_response_data(request, response) {
            /*response([{ label: "Loading...", loading: true}]);*/
            $.ajax({
                url: url,
                dataType: "json",
                data: {term: request.term},
                beforeSend: function () {

                },
                success: function (data) {
                    response(data);
                }
            });
        }
    });
</script>
<div class="row">
    <div class="col-md-4">
        <div class="thumbnail">
            <a href="/w3images/lights.jpg">
                <img src="http://local.thewall.report/uploads/featured_image/budda-quotes-on-life-fb-quotes-web-and-twitter-banner-SOUL.jpg" alt="Lights" style="width:100%">
                <div class="caption">
                    <p>Lorem ipsum...</p>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="thumbnail">
            <a href="/w3images/nature.jpg">
                <img src="http://local.thewall.report/uploads/featured_image/budda-quotes-on-life-fb-quotes-web-and-twitter-banner-SOUL.jpg" alt="Nature" style="width:100%">
                <div class="caption">
                    <p>Lorem ipsum...</p>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="thumbnail">
            <a href="/w3images/fjords.jpg">
                <img src="http://local.thewall.report/uploads/featured_image/budda-quotes-on-life-fb-quotes-web-and-twitter-banner-SOUL.jpg alt="Fjords" style="width:100%">
                <div class="caption">
                    <p>Lorem ipsum...</p>
                </div>
            </a>
        </div>
    </div>
</div>
</body>
</html>
