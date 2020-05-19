<?php
    $sdlens_path =SLIDEDECK_UPDATE_SITE."/update-sdlens.php";
    $args = array('body' => array('action' => "getlenses") );
    $json_lensdata = wp_remote_post($sdlens_path,$args);
    if(!is_wp_error($json_lensdata))
    {
        $premium_lenses = json_decode($json_lensdata["body"],true);
    }
    $options = get_option( $this->option_name );

    if( isset( $options['addon_access_key']) ) {
      $addon_access_key = $options['addon_access_key'];
    }
    else
    {
      $addon_access_key = "";
    }


    /*
    $premium_lenses = array(
        'block-title' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/block-title/thumbnail-large.jpg",
            'name' => "Block Title",
            'description' => "Shows the titles of your slides with a solid background.",
            'utm_content' => "SD2LENSBLOCKTITLE"
        ),
        'classic' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/classic/thumbnail-large.jpg",
            'name' => "Classic",
            'description' => "Classic lens is our throwback to our original concept of SlideDeck",
            'utm_content' => "SD2LENSCLASSIC"
        ),
        'half-moon' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/half-moon/thumbnail-large.jpg",
            'name' => "Half Moon",
            'description' => "Great lens for showing your mixed media content.",
            'utm_content' => "SD2LENSHALFMOON"
        ),
        'layerpro' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/layerpro/thumbnail-large.jpg",
            'name' => "Layerpro",
            'description' => "Create mind-blowing sliders by adding multiple layers.",
            'utm_content' => "SD2LENSLAYERPRO"
        ),
        'leather' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/leather/thumbnail-large.jpg",
            'name' => "Leather",
            'description' => "A simple, configurable lens with a skeuomorphic twist.",
            'utm_content' => "SD2LENSLEATHER"
        ),
        'o-town' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/o-town/thumbnail-large.jpg",
            'name' => "O Town",
            'description' => "It's the most popular lens we've created that is vertical.",
            'utm_content' => "SD2LENSOTOWN"
        ),
        'parallax' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/parallax/thumbnail-large.jpg",
            'name' => "Parallax",
            'description' => "With Parallax Lens, you can give parallax effect to your slider images.",
            'utm_content' => "SD2LENSPARALLAX"
        ),
        'parfocal' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/parfocal/thumbnail-large.jpg",
            'name' => "Parfocal",
            'description' => "Parafocal lens is inspired from the Ken Burns Effect.",
            'utm_content' => "SD2LENSPARFOCAL"
        ),
        'polarad' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/polarad/thumbnail-large.jpg",
            'name' => "Polarad",
            'description' => "Great for sidebars and profile pages. Also shows Instagram likes.",
            'utm_content' => "SD2LENSPOLARAD"
        ),
        'prime' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/prime/thumbnail-large.jpg",
            'name' => "Prime",
            'description' => "Showcase your content in fullwidth sliders, or in a lightbox effect.",
            'utm_content' => "SD2LENSPRIME"
        ),
        'reporter' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/reporter/thumbnail-large.jpg",
            'name' => "Reporter",
            'description' => "Gives equal priority to images and text in your SlideDeck.",
            'utm_content' => "SD2LENSREPORTER"
        ),
        'tiled' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/tiled/thumbnail-large.jpg",
            'name' => "Tiled",
            'description' => "Transcend your normal image sliders into something beautiful.",
            'utm_content' => "SD2LENSTILED"
        ),
        'titles' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/titles/thumbnail-large.jpg",
            'name' => "Titles",
            'description' => "Ideal for showcasing 5 or more of your most popular blog posts.",
            'utm_content' => "SD2LENSTITLES"
        ),
        'vanilla' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/vanilla/thumbnail-large.jpg",
            'name' => "Vanilla",
            'description' => "Add flavours with a wide range of slider customization options.",
            'utm_content' => "SD2LENSVANILLA"
        ),
        'video' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/lenses/video/thumbnail-large.jpg",
            'name' => "Proto Video",
            'description' => "With Proto Video lens showcase your videos in slide format.",
            'utm_content' => "SD2LENSVIDEO"
        )
    );
    */
?>
<?php
if(isset($premium_lenses) && !empty($premium_lenses))
foreach( $premium_lenses as $slug => $lens_meta ): ?>

    <?php if( !in_array( $slug, $lens_slugs ) ) :

     $action = $this->namespace . '_upload_premium_lenses';
        $_wpnonce = wp_create_nonce( $this->namespace . '_upload_premium_lenses' );
        $_lens= $slug;

?>


        <div class="lens add-lens">
          <a href="https://www.slidedeck.com/addons/?utm_source=sd5_lenses&utm_medium=link&utm_campaign=sd5_lite" target="_blank" >
          <div class="lense-offer" style="position:absolute;z-index:2;color:#fff;background:#DF3333;padding:5px;margin-top:-10px;margin-left:-10px;">
            included in mega bundle
          </div>
        </a>
             <div class="inner">
                <span class="thumbnail upload-premium-lens-img">
                    <span class="thumbnail-inner" style="background-image:url(<?php echo $lens_meta['thumbnail']; ?>);"></span>
                </span>
                <img class="uploading-lens-img" width="100%" height="100%" src="<?php echo esc_url( SLIDEDECK_URLPATH); ?>/images/ajax_loader.gif" style="position:absolute;left:0%;right:0%;bottom:0%;display:none;" />
                <!-- <img src="<?php echo $lens_meta['thumbnail']; ?>" /> -->
                <h4><?php echo $lens_meta['name']; ?>
                  <a style="margin-right:-20px" title="Help" href="https://www.slidedeck.com/documentation/?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link#<?php echo $slug;?>" target="_blank" class="help-icon" >
                      <span class=""></span>
                  </a>

                </h4>
                <p><?php echo $lens_meta['description']; ?></p>
            
                <div class="upgrade-button-cta">
                    <!--<a href="https://www.slidedeck.com/premium-lenses-ee0f2/?lens=<?php echo $slug; ?>&utm_source=premium_lenses_page&utm_medium=link&utm_content=<?php echo $lens_meta['utm_content']; ?>&utm_campaign=sd3_upgrade<?php echo self::get_cohort_query_string( '&' ) . slidedeck_km_link( 'Browse Premium Lens', array( 'name' => $lens_meta['name'], 'location' => 'Lens Management' ) ); ?>" target="_blank" class="button">-->
                    <?php if(isset($addon_access_key) && $addon_access_key != '' && in_array($lens_meta['id'], $free_lenses_available) ) { ?>
                        <a class="button upload-lens" data-nonce="<?php echo $_wpnonce; ?>" data-lens="<?php echo $_lens; ?>">
                        <span class="button-noise">
                            <span class="upload-premium-lens">Install & Activate</span>
                            <span class="uploading-lens" style="display:none;">Installing . . .</span>
                        </span>

                    </a>
                     <?php } else { ?>
                      <!--  <a href="https://www.slidedeck.com/addons/?utm_source=sd5_lenses&utm_medium=link&utm_campaign=sd5_lite" target="_blank" class="button">
                        <span class="button-noise">
                            <span>Learn More</span>
                            <span class="dashicons dashicons-external"></span>
                        </span>
                    </a> -->
                    <?php } ?>


                </div>
            </div>
            <div class="actions"></div>
        </div>

    <?php endif; ?>

<?php endforeach; ?>
<style>
    .upload-lens {
        cursor: pointer;
    }
</style>
<script>
  jQuery(document).ready( function() {

   jQuery(".upload-lens").click( function(e) {
      e.preventDefault();
      jQuery(this).off('click');
      var lens = jQuery(this).attr("data-lens")
      var nonce = jQuery(this).attr("data-nonce")

      jQuery(this).parents('.inner').find('.upload-premium-lens-img').css({'opacity':'0.5'});
      jQuery(this).parents('.inner').find('.uploading-lens-img').css({'display':'block'});
      jQuery(this).find('.upload-premium-lens').css({'display':'none'});
      jQuery(this).find('.uploading-lens').css({'display':'block'});
      jQuery(this).css({'cursor':'wait'});

      jQuery.ajax({
         type : "post",

         url : "admin-ajax.php",
         data : {action: "slidedeck_upload_premium_lenses", _wpnonce : nonce, _lens: lens},
         success: function(response) {

               jQuery(this).parents('.inner').find('.upload-premium-lens-img').css({'opacity':'1.0'});
                jQuery(this).parents('.inner').find('.uploading-lens-img').css({'display':'none'});
                jQuery(this).find('.upload-premium-lens').css({'display':'block'});
                jQuery(this).find('.uploading-lens').css({'display':'none'});
                jQuery(this).css({'cursor':'pointer'});
               location.reload();
         }
      })

   })

})
</script>
