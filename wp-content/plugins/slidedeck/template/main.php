<?php

$pluginPath = WP_PLUGIN_DIR . "/slidedeck5addons/slidedeck5addons.php";
$active_plugins = (array) get_option( 'active_plugins', array() );
if(!empty($_GET['template']))
{


	$template=$_GET['template'];

  if (in_array("slidedeck5addon/slidedeck5addon.php", $active_plugins))
    {
      $string = file_get_contents(SLIDEDECK_DIRNAME  ."/../slidedeck5addon/slidedeck-templates/".$template."/slidedeck-".$template.".json");
    }
    else{
      $string = file_get_contents(SLIDEDECK_DIRNAME  ."/../slidedeck-templates/".$template."/slidedeck-".$template.".json");
    }


 $slider_data = json_decode($string, true);
$slider_id = absint($_GET['slidedeck_id']);
            /* Step 1 : Import slider information and its settings. Old data will be override. */
if ( ! function_exists( 'post_exists' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/post.php' );
}
            // Prepare data for slider info.
            $exists_post_id = post_exists( $slider_data['slider_title'] );

            $update_slider = array(
                "ID" => $slider_id,
                "post_title" => ( $exists_post_id != $slider_id ) ? $slider_data['slider_title']. '' : $slider_data['slider_title'],
                "post_status" => "publish",
            );
            //Update slider basic info.
            wp_update_post($update_slider);

            //Update slider settings and its meta information.
            foreach ($slider_data['slider_settings'] as $meta_key => $meta_value) {
                update_post_meta($slider_id, $meta_key, maybe_unserialize( $meta_value ) );
            }

            /* Step 2: Import slides in slider if any. Old slide will be removed. */

            if ( isset( $slider_data['slides'] ) && !empty( $slider_data['slides'] ) ) {

                //First remove all old slide of the slider.
                $slider_slides = get_posts(
                        array(
                            "post_parent" => $slider_id,
                            'post_type' => 'sd2_custom_slide',
                            "posts_per_page" => -1,
                            "order" => "ASC",
                            "orderby" => "ID",
                            "post_status" => "any",
                        )
                );

                if (is_array($slider_slides) && count($slider_slides) > 0) {
                    // Delete all the Children of the Parent Page
                    foreach ($slider_slides as $slider_slide) {
                        wp_delete_post($slider_slide->ID, true);
                    }
                }

                //Import each slide and its settings.
                foreach ($slider_data['slides'] as $slide) {
                    $new_slide = array(
                        'post_parent' => $slider_id,
                        'post_title' => $slide['slide_title'],
                        'post_type' => $slide['slide_type'],
                        'post_content' => $slide['slide_content'],
                        'post_excerpt' => $slide['slide_excerpt'],
                        "post_status" => "publish",
                    );
                    // Create new slide.
                    $slide_id = wp_insert_post($new_slide);

                    if (!$slide_id) { //If slide not create then continue process for next slide.
                        continue;
                    }

                    // Add slide settings.
                    foreach ($slide['slide_meta'] as $meta_key => $meta_value) {
                        update_post_meta($slide_id, $meta_key, maybe_unserialize( $meta_value ) );
                    }

                    //If slide image source is upload then download image and create attachment and update slide setting.
                    if ( isset( $slide['_image_attachment_url'] ) && !empty( $slide['_image_attachment_url'] ) ) {
                       // $image = wp_get_attachment_image_src( $slide['slide_meta']['_image_attachment'] );
												if (!isset ($image)){
													$image = "";
												}
                        if (!$image) {
                            // Get the image from a remote URL.
                            if (in_array("slidedeck5addon/slidedeck5addon.php", $active_plugins))
                              {
                                $attachemt_id = import_remote_image(SLIDEDECK_URL  ."../slidedeck5addon/slidedeck-templates/".$template."/img/".basename($slide['_image_attachment_url']), $slide_id );
                              }
                              else{
                                $attachemt_id = import_remote_image(SLIDEDECK_URL  ."../slidedeck-templates/".$template."/img/".basename($slide['_image_attachment_url']), $slide_id );
                              }


                            // Update slide with new attachement id.
                            if( $attachemt_id ) {
                                update_post_meta( $slide_id, '_image_attachment', $attachemt_id );
                            }
                        }
                    }
                }
            }

             $path = admin_url( "admin.php?page=" . SLIDEDECK_BASENAME );
          $str=   "&action=edit&slidedeck=" . $slider_id;
            wp_redirect( $path.$str );






}



function import_remote_image( $image_url, $slide_id ) {
	$wp_upload_dir='';
	$stream = wp_remote_get( $image_url, array( 'timeout' => 60 ) );
	$type = wp_remote_retrieve_header( $stream, 'content-type' );

	$mirror = wp_upload_bits( basename( $image_url ), null, wp_remote_retrieve_body( $stream ) );

	$attachment = array(
			'guid'           => $wp_upload_dir . '/' . basename( $image_url ),
			'post_title' => basename( $image_url ),
			'post_mime_type' => $type
	);

	$attach_id = wp_insert_attachment( $attachment, $mirror['file'], $slide_id );

	// Generate and update attachment metadata.
	if ( !function_exists( 'wp_generate_attachment_metadata' ) ) {
		require ABSPATH . 'wp-admin/includes/image.php';
	}

	// Generate and update attachment metadata.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $mirror['file'] );
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;


return $attachemt_id;
}


?>
