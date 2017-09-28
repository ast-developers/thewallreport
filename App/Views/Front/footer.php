
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
<script src="<?php echo \App\Config::W_FRONT_ASSETS ?>js/owl.carousel.min.js"></script>

<script type="text/javascript">
var search_url = "<?php echo \App\Config::W_ROOT.'search/' ?>";
var url = "<?php echo \App\Config::W_ROOT.'search-data'; ?>";
var spinner = "<?php echo \App\Config::W_FRONT_ASSETS.'images/loader.gif' ?>";
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
        $("#search-input").on("keyup", function( event ){
            var text = $('#search-input').val();
            var model_content=$('.modal-content').find('.row');
            if(text.length > 2){
                $.ajax({
                    url: url,
                    dataType: "json",
                    method:'POST',
                    data: {term: text},
                    beforeSend: function () {
                        $('.spinner').html("<img src='"+spinner+"' />");
                    },
                    success: function (data) {
                        $('.spinner').empty();
                        $('.no-found-result').empty();
                        $(model_content).empty();
                        $('.button-area').empty()
                        var result_message=(typeof data.count != 'undefined' && data.count>0)?"FOUND " +data.count+ " RESULTS FOR: <span class='search-text'>"+text+"</span>":"NO RESULTS FOUND FOR:<span class='search-text'>"+text+"</span>";
                        if(typeof data.count != 'undefined' && data.count>0){
                            $('.found-result').html(result_message);
                            $.each( data.data, function( key, value ) {
                                $(model_content).append("<div class='col-lg-4 text-center pb-2'><a href='"+value.slug+"'><div class='search-img hidden-md-down'><img src="+value.featured_image+"></div><h2 class='title'>"+value.name+"</h2></a><span class='search-date d-block'>FEBRUARY 3, 2017</span></div>");
                            });
                            $("<a class='see-all-btn' href='"+search_url+text+"'>SEE ALL RESULTS</a>").appendTo('.button-area');
                        }else{
                            $('.button-area').empty();
                            $('.found-result').empty();
                            $('.no-found-result').html(result_message)
                        }
                    }
                });
            }
        });

        function append_response_data(request, response) {
            /*response([{ label: "Loading...", loading: true}]);*/
            $.ajax({
                url: url,
                dataType: "json",
                method:'POST',
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
<script id="dsq-count-scr" src="//thewallreport.disqus.com/count.js" async></script>
</body>
</html>
