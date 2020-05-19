<?php
    $sdsource_path =SLIDEDECK_UPDATE_SITE."/update-sdsource.php";
    $args = array('body' => array('action' => "getsources") );
    $json_sourcedata = wp_remote_post($sdsource_path,$args);
    if(!is_wp_error($json_sourcedata))
    {
        $premium_sources = json_decode($json_sourcedata["body"],true);
    }
    $options = get_option( $this->option_name );
    if( isset( $options['addon_access_key']) ) {
      $addon_access_key = $options['addon_access_key'];
    }
    else{
      $addon_access_key = "";
    }
    // if(isset($addon_access_key) && $addon_access_key != '')
    /*
    $premium_sources = array(
        'dailymotion' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/dailymotion/thumbnail-large.jpg",
            'name' => "Dailymotion",
            'description' => "Show your Dailymotion videos via SlideDeck sliders.",
            'utm_content' => "SDSOURCEDAILYMOTION"
        ),
        'dribbble' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/dribbble/thumbnail-large.jpg",
            'name' => "Dribbble",
            'description' => "Showcase your Dribbble artwork as slides on your WordPress website.",
            'utm_content' => "SDSOURCEDRIBBBLE"
        ),
        'facebook' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/facebook/thumbnail-large.jpg",
            'name' => "Facebook",
            'description' => "Show your Facebook posts in slide format on your WordPress website.",
            'utm_content' => "SDSOURCEFACEBOOK"
        ),
        'fivehundredpixels' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/fivehundredpixels/thumbnail-large.jpg",
            'name' => "500px",
            'description' => "Showcase your 500px account images as slides on your WordPress website.",
            'utm_content' => "SDSOURCEFIVEHUNDREDPIXELS"
        ),
        'flickr' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/flickr/thumbnail-large.jpg",
            'name' => "Flickr",
            'description' => "Showcase your Flickr images and videos in the form of slides.",
            'utm_content' => "SDSOURCEFLICKR"
        ),
        'gplus' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/gplus/thumbnail-large.jpg",
            'name' => "Google Plus",
            'description' => "Integrate your g+ account with SlideDeck.",
            'utm_content' => "SDSOURCEGPLUS"
        ),
        'gplusimages' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/gplusimages/thumbnail-large.jpg",
            'name' => "Google Plus Images",
            'description' => "Make slides of your Google Plus Images and how them to your users.",
            'utm_content' => "SDSOURCEGPLUSIMAGES"
        ),
        'instagram' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/instagram/thumbnail-large.jpg",
            'name' => "Instagram",
            'description' => "Make slides of your Instagram photos and show them to your users.",
            'utm_content' => "SDSOURCEINSTAGRAM"
        ),
        'nextgengallery' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/nextgengallery/thumbnail-large.jpg",
            'name' => "NextGen Gallery",
            'description' => "Display your NextGEN gallery images in your SlideDeck slides.",
            'utm_content' => "SDSOURCENEXTGENGALLERY"
        ),
        'pinterest' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/pinterest/thumbnail-large.jpg",
            'name' => "Pinterest",
            'description' => "Showcase your Pinterest posts as slides on your WordPress website.",
            'utm_content' => "SDSOURCEPINTEREST"
        ),
        'posts' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/posts/thumbnail-large.jpg",
            'name' => "WP Posts",
            'description' => "Show your top posts to your users in slide format.",
            'utm_content' => "SDSOURCEPOSTS"
        ),
        'rss' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/rss/thumbnail-large.jpg",
            'name' => "RSS",
            'description' => "Highlight the RSS Feeds into the slider of your WordPress website.",
            'utm_content' => "SDSOURCERSS"
        ),
        'tumblr' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/tumblr/thumbnail-large.jpg",
            'name' => "Tumblr",
            'description' => "Showcase your Tumblr images as slides on your website.",
            'utm_content' => "SDSOURCETUMBLR"
        ),
        'vimeo' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/vimeo/thumbnail-large.jpg",
            'name' => "Vimeo",
            'description' => "Show your Vimeo videos via SlideDeck sliders.",
            'utm_content' => "SDSOURCEVIMEO"
        ),
        'woocommerce' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/woocommerce/thumbnail-large.jpg",
            'name' => "Woocommerce",
            'description' => "Show your WooCommerce website products in the sliders.",
            'utm_content' => "SDSOURCEWOOCOMMERCE"
        ),
        'youtube' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/youtube/thumbnail-large.jpg",
            'name' => "YouTube",
            'description' => "Show your YouTube videos in slider form on your WordPress website.",
            'utm_content' => "SDSOURCEYOUTUBE"
        ),
        'zenfolio' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/sources/zenfolio/thumbnail-large.jpg",
            'name' => "Zenfolio",
            'description' => "Showcase your Zenfolio account images as slides on your WordPress website.",
            'utm_content' => "SDSOURCEZENFOLIO"
        ),
    );
     * */
?>
<?php
if(isset($premium_sources) && !empty($premium_sources))
foreach( $premium_sources as $slug => $source_meta ): ?>

    <?php if( !in_array( $slug, $source_slugs ) ) :
        $action = $this->namespace . '_upload_premium_sources';
        $_wpnonce = wp_create_nonce( $this->namespace . '_upload_premium_sources' );
        $_source= $slug;
     ?>

        <div class="lens add-lens">
            <div class="inner">
                <span class="thumbnail">
                    <span class="thumbnail-inner" style="background-image:url(<?php echo $source_meta['thumbnail']; ?>);"></span>
                </span>
                <img class="uploading-source-img" width="100%" height="100%" src="<?php echo esc_url( SLIDEDECK_URLPATH); ?>/images/ajax_loader.gif" style="position:absolute;left:0%;right:0%;bottom:0%;display:none;" />
                <!-- <img src="<?php echo $source_meta['thumbnail']; ?>" />-->
                <h4><?php echo $source_meta['name']; ?></h4>
                <p><?php echo $source_meta['description']; ?></p>
                <div class="upgrade-button-cta">
                    <!--<a href="http://www.slidedeck.com/premium-sources-ee0f2/?source=<?php echo $slug; ?>&utm_source=premium_sources_page&utm_medium=link&utm_content=<?php echo $source_meta['utm_content']; ?>&utm_campaign=sd_upgrade<?php echo self::get_cohort_query_string( '&' ) . slidedeck_km_link( 'Browse Premium Source', array( 'name' => $source_meta['name'], 'location' => 'Source Management' ) ); ?>" target="_blank" class="button">-->
                    <?php if(isset($addon_access_key) && $addon_access_key != '' && in_array($source_meta['id'], $free_sources_available) ) { ?>
                        <a class="button upload-source" data-nonce="<?php echo $_wpnonce; ?>" data-source="<?php echo $_source; ?>">
                        <span class="button-noise">
                            <span class="upload-premium-source">Install & Activate</span>
                            <span class="uploading-source" style="display:none;">Installing . . .</span>
                        </span>
                    </a>
                    <?php } else { ?>
                        <a href="https://www.slidedeck.com/addons/?utm_source=sd5_sources&utm_medium=link&utm_campaign=sd5_lite" target="_blank" class="button">
                        <span class="button-noise">
                            <span>Learn More</span>
                            <span class="dashicons dashicons-external"></span>
                        </span>
                    </a>
                    <?php } ?>

                    <a title="Help" href="https://www.slidedeck.com/documentation/?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link#source-management" target="_blank" class="help-icon" >
                        <span class=""></span>
                    </a>
                </div>
            </div>
            <div class="actions"></div>
        </div>

    <?php endif; ?>

<?php endforeach; ?>
<style>
    .upload-source {
        cursor: pointer;
    }
</style>
<script>
  jQuery(document).ready( function() {

   jQuery(".upload-source").click( function(e) {
      e.preventDefault();
      jQuery(this).off('click');
      var source = jQuery(this).attr("data-source")
      var nonce = jQuery(this).attr("data-nonce")

      jQuery(this).parents('.inner').find('.upload-premium-source-img').css({'opacity':'0.5'});
      jQuery(this).parents('.inner').find('.uploading-source-img').css({'display':'block'});
      jQuery(this).find('.upload-premium-source').css({'display':'none'});
      jQuery(this).find('.uploading-source').css({'display':'block'});
      jQuery(this).css({'cursor':'wait'});

      jQuery.ajax({
         type : "post",

         url : "admin-ajax.php",
         data : {action: "slidedeck_upload_premium_sources", _wpnonce : nonce, _source: source},
         success: function(response) {

               jQuery(this).parents('.inner').find('.upload-premium-source-img').css({'opacity':'1.0'});
                jQuery(this).parents('.inner').find('.uploading-source-img').css({'display':'none'});
                jQuery(this).find('.upload-premium-source').css({'display':'block'});
                jQuery(this).find('.uploading-source').css({'display':'none'});
                jQuery(this).css({'cursor':'pointer'});
               location.reload();
         }
      })

   })

})
</script>
