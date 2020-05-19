<?php

$sd3addon_path =SLIDEDECK_UPDATE_SITE."/update-sdaddon.php";
$args = array('body' => array('action' => "getaddons") );
$json_addondata = wp_remote_post($sd3addon_path,$args);

if(!is_wp_error($json_addondata))
{
	$external_addons = json_decode($json_addondata["body"],true);
}
$options = get_option( $this->option_name );
if( isset( $options['addon_access_key']) ) {
  $addon_access_key = $options['addon_access_key'];
}
else{
  $addon_access_key = "";
}

if(isset($external_addons) && !empty($external_addons))
foreach( $external_addons as $slug => $addon_meta ): ?>

    <?php if( !in_array( $addon_meta['slug'], $addon_slugs ) ) :
        $action = $this->namespace . '_upload_premium_addons';
        $_wpnonce = wp_create_nonce( $this->namespace . '_upload_premium_addons' );
        $_addon = $addon_meta['slug'];


?>
 	    <?php if( !class_exists($addon_meta['class']) ) : ?>
        <div class="lens add-lens">
            <div class="inner">
                <!--
                <span class="thumbnail">
			<span class="thumbnail-inner" style="background-image:url(<?php //echo $addon['thumbnail']; ?>);"></span>
		</span>
                -->
								<?php
								if (isset($addon['thumbnail'])){
									echo $addon['thumbnail'];
								}
								else {
									$addon['thumbnail'] = "";
								}
								?>

                <img class = "sdaddon-img upload-premium-addon-img" style ="width:258px; height:160px;" src="<?php echo $addon_meta['thumbnail']; ?>" />
                <img class="uploading-addon-img" width="100%" height="100%" src="<?php echo esc_url( SLIDEDECK_URLPATH); ?>/images/ajax_loader.gif" style="position:absolute;left:0%;right:0%;bottom:0%;display:none;" />
                <h4><?php echo $addon_meta['name']; ?></h4>
                <p><?php echo $addon_meta['description']; ?></p>
                <div class="upgrade-button-cta">
                    <!--<a href="http://www.slidedeck.com/premium-lenses-ee0f2/?lens=<?php echo $slug; ?>&utm_source=premium_lenses_page&utm_medium=link&utm_content=<?php echo $addon_meta['utm_content']; ?>&utm_campaign=sd3_upgrade<?php echo self::get_cohort_query_string( '&' ) . slidedeck_km_link( 'Browse Premium Lens', array( 'name' => $addon_meta['name'], 'location' => 'Lens Management' ) ); ?>" target="_blank" class="upgrade-button green">-->
                    <?php if(isset($addon_access_key) && $addon_access_key != '' && in_array($addon_meta['id'], $free_addons_available) ) { ?>
                        <a class="button upload-addon" data-nonce="<?php echo $_wpnonce; ?>" data-addon="<?php echo $_addon; ?>">
                        <span class="button-noise">
                            <span class="upload-premium-addon">Install & Activate</span>
                            <span class="uploading-addon" style="display:none;">Installing . . .</span>
                        </span>
                    </a>
                     <?php } else { ?>
                        <a href="https://www.slidedeck.com/addons/?utm_source=sd5_addons&utm_medium=link&utm_campaign=sd5_lite" target="_blank" class="button">
                        <span class="button-noise">
                            <span>Learn More</span>
                            <span class="dashicons dashicons-external"></span>
                        </span>
                    </a>
                    <?php } ?>


                   <a title="Help" href="https://www.slidedeck.com/documentation/?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link#add-ons-management" target="_blank" class="help-icon" >
                        <span class=""></span>
                    </a>
                </div>
            </div>
            <div class="actions"></div>
        </div>

    <?php endif; ?>
   	<?php endif; ?>

<?php endforeach; ?>
<style>
    .upload-addon {
        cursor: pointer;
    }
</style>
<script>
  jQuery(document).ready( function() {

   jQuery(".upload-addon").click( function(e) {
      e.preventDefault();
      jQuery(this).off('click');
      var addon = jQuery(this).attr("data-addon")
      var nonce = jQuery(this).attr("data-nonce")

      jQuery(this).parents('.inner').find('.upload-premium-addon-img').css({'opacity':'0.5'});
      jQuery(this).parents('.inner').find('.uploading-addon-img').css({'display':'block'});
      jQuery(this).find('.upload-premium-addon').css({'display':'none'});
      jQuery(this).find('.uploading-addon').css({'display':'block'});
      jQuery(this).css({'cursor':'wait'});

      jQuery.ajax({
         type : "post",

         url : "admin-ajax.php",
         data : {action: "slidedeck_upload_premium_addons", _wpnonce : nonce, _addon: addon},
         success: function(response) {

               jQuery(this).parents('.inner').find('.upload-premium-addon-img').css({'opacity':'1.0'});
                jQuery(this).parents('.inner').find('.uploading-addon-img').css({'display':'none'});
                jQuery(this).find('.upload-premium-addon').css({'display':'block'});
                jQuery(this).find('.uploading-addon').css({'display':'none'});
                jQuery(this).css({'cursor':'pointer'});
               location.reload();
         }
      })

   })

})
</script>
