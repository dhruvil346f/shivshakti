<?php
    $sdtemplate_path =SLIDEDECK_UPDATE_SITE."/update-sdtemplate.php";
    $args = array('body' => array('action' => "gettemplates") );
    $json_templatedata = wp_remote_post($sdtemplate_path,$args);
    if(!is_wp_error($json_templatedata))
    {
        $premium_templates = json_decode($json_templatedata["body"],true);
    }
    $options = get_option( $this->option_name );

    if( isset( $options['addon_access_key']) ) {
      $addon_access_key = $options['addon_access_key'];
    }
    else{
      $addon_access_key = "";
    }

    /*
    $premium_templates = array(
        'Adventure-Plus' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/adventure-plus/thumbnail-large.png",
            'name' => "Adventure Plus",
            'description' => "Is an alluring slider template. It uses flip effect to change the slides.",
            'utm_content' => "SDTEMPLATEAPLUS"
        ),
        'Altitude' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/altitude/thumbnail-large.png",
            'name' => "Altitude",
            'description' => "Make elegant slides, which changes in beautiful manner & its text follows.",
            'utm_content' => "SDTEMPLATEALTITUDE"
        ),
        'classic' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/classic/thumbnail-large.png",
            'name' => "Classic",
            'description' => "'Classic Lens' makes this template truly classic.",
            'utm_content' => "SDTEMPLATECLASSIC"
        ),
        'Elegant' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/elegant/thumbnail-large.png",
            'name' => "Elegant",
            'description' => "Elegant template uses 'Fashion lens' to give an elegant look to your sliders.",
            'utm_content' => "SDTEMPLATEELEGANT"
        ),
        'InnovationPro' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/innovationpro/thumbnail-large.png",
            'name' => "Innovation Pro",
            'description' => "Specially designed to make image sliders look lively and attractive.",
            'utm_content' => "SDTEMPLATEIPRO"
        ),
        'o-town' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/o-town/thumbnail-large.png",
            'name' => "O Town",
            'description' => "It is a great way to showcase your products in a vertical slider.",
            'utm_content' => "SDTEMPLATEOTOWN"
        ),
        'Photo-Flip' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/photo-flip/thumbnail-large.png",
            'name' => "Photo Flip",
            'description' => "Give a flip effect to your sliders with Photo Flip.",
            'utm_content' => "SDTEMPLATEPFLIP"
        ),
        'Product-Slider' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/product-slider/thumbnail-large.png",
            'name' => "Product Slider",
            'description' => "Amazing template to display your products. It uses 'Tool Kit' lens.",
            'utm_content' => "SDTEMPLATEPSLIDER"
        ),
        'Showcase' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/showcase/thumbnail-large.png",
            'name' => "Showcase",
            'description' => "Make awesome drag effect that enhance your slider's beauty.",
            'utm_content' => "SDTEMPLATESHOWCASE"
        ),
        'Simple' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/simple/thumbnail-large.png",
            'name' => "Simple",
            'description' => "Give a rugged leather look to your slider with this template.",
            'utm_content' => "SDTEMPLATESIMPLE"
        ),
        'titles' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/titles/thumbnail-large.png",
            'name' => "Titles",
            'description' => "It is beautiful template that goes best with health and fitness websites.",
            'utm_content' => "SDTEMPLATETITLES"
        ),
        'Travellog' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/travellog/thumbnail-large.png",
            'name' => "Travellog",
            'description' => "Perfect for travel/adventure websites, to attract your visitors.",
            'utm_content' => "SDTEMPLATETRAVELLOG"
        ),
        'Vibes' => array(
            'thumbnail' => "https://s3-us-west-2.amazonaws.com/slidedeck-pro/upsell_assets/images/templates/vibes/thumbnail-large.png",
            'name' => "Vibes",
            'description' => "'Tiled Lens' in this template offers a rich looking transition to slides.",
            'utm_content' => "SDTEMPLATEVIBES"
        )
    );
    */
?>
<?php
if(isset($premium_templates) && !empty($premium_templates))
foreach( $premium_templates as $slug => $template_meta ): ?>

    <?php if( !in_array( $slug, $template_slugs ) ) :
        $action = $this->namespace . '_upload_premium_templates';
        $_wpnonce = wp_create_nonce( $this->namespace . '_upload_premium_templates' );
        $_template= $slug;

?>

        <div class="lens add-lens">
            <div class="inner">

                <span class="thumbnail">


	        <span class="thumbnail-inner" style="background-image:url(<?php echo $template_meta['thumbnail']; ?>);"></span>


	        </span>

                <img class="uploading-template-img" width="100%" height="100%" src="<?php echo esc_url( SLIDEDECK_URLPATH); ?>/images/ajax_loader.gif" style="position:absolute;left:0%;right:0%;bottom:0%;display:none;" />


                <h4><?php echo $template_meta['name']; ?></h4>
                <p><?php echo $template_meta['description']; ?></p>
                <div class="upgrade-button-cta">
                    <!--<a href="http://www.slidedeck.com/premium-templates-ee0f2/?template=<?php echo $slug; ?>&utm_source=premium_templates_page&utm_medium=link&utm_content=<?php echo $template_meta['utm_content']; ?>&utm_campaign=sd_upgrade<?php echo self::get_cohort_query_string( '&' ) . slidedeck_km_link( 'Browse Premium Template', array( 'name' => $template_meta['name'], 'location' => 'Template Management' ) ); ?>" target="_blank" class="button">-->
                     <?php if(isset($addon_access_key) && $addon_access_key != '' && in_array($template_meta['id'], $free_templates_available) ) { ?>
                         <a class="button upload-template" data-nonce="<?php echo $_wpnonce; ?>" data-template="<?php echo $_template; ?>">
                        <span class="button-noise">
                            <span class="upload-premium-template">Install & Activate</span>
                            <span class="uploading-template" style="display:none;">Installing . . .</span>
                        </span>
                    </a>
                     <?php } else { ?>
                        <a href="https://www.slidedeck.com/addons/?utm_source=sd5_templates&utm_medium=link&utm_campaign=sd5_lite" target="_blank" class="button">
                        <span class="button-noise">
                            <span>Learn More</span>
                            <span class="dashicons dashicons-external"></span>
                        </span>
                    </a>
                    <?php } ?>
                    <a title="Help" href="https://www.slidedeck.com/documentation/?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link#template-management" target="_blank" class="help-icon" >
                        <span class=""></span>
                    </a>

                </div>
            </div>
            <div class="actions"></div>
        </div>

    <?php endif; ?>

<?php endforeach; ?>
<style>
    .upload-template {
        cursor: pointer;
    }
</style>
<script>
  jQuery(document).ready( function() {

   jQuery(".upload-template").click( function(e) {
      e.preventDefault();
      jQuery(this).off('click');
      var template = jQuery(this).attr("data-template")
      var nonce = jQuery(this).attr("data-nonce")

      jQuery(this).parents('.inner').find('.upload-premium-template-img').css({'opacity':'0.5'});
      jQuery(this).parents('.inner').find('.uploading-template-img').css({'display':'block'});
      jQuery(this).find('.upload-premium-template').css({'display':'none'});
      jQuery(this).find('.uploading-template').css({'display':'block'});
      jQuery(this).css({'cursor':'wait'});

      jQuery.ajax({
         type : "post",

         url : "admin-ajax.php",
         data : {action: "slidedeck_upload_premium_templates", _wpnonce : nonce, _template: template},
         success: function(response) {

               jQuery(this).parents('.inner').find('.upload-premium-template-img').css({'opacity':'1.0'});
                jQuery(this).parents('.inner').find('.uploading-template-img').css({'display':'none'});
                jQuery(this).find('.upload-premium-template').css({'display':'block'});
                jQuery(this).find('.uploading-template').css({'display':'none'});
                jQuery(this).css({'cursor':'pointer'});
               location.reload();
         }
      })

   })

})
</script>
