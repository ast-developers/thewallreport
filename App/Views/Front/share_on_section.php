<div class="col-lg-12 share-post-block-bg p-4 mb-4">
    <div class="row d-flex align-items-center">
        <div class="col-md-4">
            <h4>SHARE ON</h4>
        </div>
        <div class="col-md-8 d-flex align-items-center justify-content-md-end">
            <!--<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/"
                 data-layout="button_count"></div>-->
            <?php
            $fbUrl = \App\Config::W_ROOT.$slug;
            if(isset($feed)){
                $fbUrl = \App\Config::W_ROOT.'feed/'.$feed['post_id'].'/'.$feed['feed_id'];
            }
            ?>
            <div class="fb-share-button" data-href="<?php echo $fbUrl; ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $fbUrl; ?>&amp;src=sdkpreparse"></a></div>

            <iframe
                src="https://platform.twitter.com/widgets/tweet_button.html?size=l&url=<?php echo \App\Config::W_ROOT . $slug; ?>&related=twitterapi%2Ctwitter&text=<?php echo $header; ?> The Wall Report"
                width="95"
                height="40"
                title="Twitter Share Button"
                data-size="default"
                style="border: 0; overflow: hidden!important;"
                class="Twitter-Share-Button"
            >
            </iframe>
            <a style="margin-right: 15px;" data-pin-do="buttonPin"
               href="https://www.pinterest.com/pin/create/button/?url=<?php echo \App\Config::W_ROOT . $slug ?>"
               data-pin-height="28"></a>
            <g:plusone size="tall"></g:plusone>
        </div>
    </div>
</div>