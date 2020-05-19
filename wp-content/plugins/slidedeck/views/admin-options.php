<?php
/**
 * SlideDeck Administrative Options
 * 
 * More information on this project:
 * http://www.slidedeck.com/
 * 
 * Full Usage Documentation: http://www.slidedeck.com/usage-documentation 
 * 
 * @package SlideDeck
 * @subpackage SlideDeck 3 Pro for WordPress
 * @author Hummingbird Web Solutions Pvt. Ltd.
 */

/*
Copyright 2012 HBWSL  (email : support@hbwsl.com)

This file is part of SlideDeck.

SlideDeck is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

SlideDeck is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with SlideDeck.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<div class="slidedeck-wrapper advanced-options">
    <?php slidedeck_flash(); ?>
    <div class="">
        <div class="slidedeck-header">
            <h1><?php _e( "SlideDeck Advanced Options", $namespace ); ?></h1>
        </div>
        <div id="slidedeck-option-wrapper">
            <p class="intro"><?php _e( "These options are for situations where SlideDeck might not be working correctly. Only change them if you are having difficulty with your SlideDeck installation, <em>or if you are certain of what they do</em>.", $namespace ); ?></p>
            <form action="" method="post" id="overview_options_form">
                <formset>
                    <div class="inner">
                        <?php wp_nonce_field( "{$this->namespace}-update-options" ); ?>
                        <ul>
                            <!--
                            <li>
                                <div class="slidedeck-license-key-wrapper">
                                	<?php // slidedeck_html_input( 'data[license_key]', slidedeck_get_license_key(), array( 'type' => 'password', 'attr' => array( 'class' => 'fancy license-key-text-field' ), 'label' => "Your SlideDeck License Key" ) ); ?>
                                	<?php // wp_nonce_field( "{$this->namespace}_verify_license_key", 'verify_license_nonce' ); ?>
                                	<a href="#verify" class="verify-license-key button">Verify</a>
                                	<div class="license-key-verification-response"><span class="waiting">Waiting...</span></div>
                                </div>
                            </li>
                            -->
                            <li>
                                <?php slidedeck_html_input( 'data[always_load_assets]', $data['always_load_assets'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'radio', 'label' => "Always load SlideDeck JavaScript/CSS on every page?" ) ); ?><br />
                            </li>
                            <li>
                                <?php slidedeck_html_input( 'data[disable_wpautop]', $data['disable_wpautop'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'radio', 'label' => "Disable <code>wpautop()</code> function?" ) ); ?>
                            </li>
                            <li>
                            	<?php slidedeck_html_input( 'data[dont_enqueue_scrollwheel_library]', $data['dont_enqueue_scrollwheel_library'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'radio', 'label' => "Don't enqueue the jquery.mousewheel.js library (if you have your own solution)" ) ); ?>
                            </li>
                            <li>
                            	<?php slidedeck_html_input( 'data[dont_enqueue_easing_library]', $data['dont_enqueue_easing_library'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'radio', 'label' => "Don't enqueue the jquery.easing.1.3.js library (if you have your own solution)" ) ); ?>
                            </li>
                            <li>
                                <?php slidedeck_html_input( 'data[disable_edit_create]', $data['disable_edit_create'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'radio', 'label' => "Disable the ability to Add New and Edit SlideDecks for non Admins" ) ); ?>
                            </li>
                            <li>
                                <?php slidedeck_html_input( 'data[iframe_by_default]', $data['iframe_by_default'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'radio', 'label' => "Include the &ldquo;iframe=1&rdquo; attribute in all new shortcode embeds by default" ) ); ?>
                            </li>
                            <li>
                                <?php slidedeck_html_input( 'data[anonymous_stats_optin]', $data['anonymous_stats_optin'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'radio', 'label' => "Opt-in to make SlideDeck better with anonymous usage statistics", 'description' => "If you opt-in, anonymous statistics about how you use SlideDeck 3 will be sent to hbwsl to help us make SlideDeck 3 better suited to your needs. Absolutely no personally identifiable information is transmitted." ) ); ?><br />
                            </li>
                            <li>
                            	<?php slidedeck_html_input( 'data[twitter_user]', $data['twitter_user'], array( 'attr' => array( 'class' => 'fancy' ), 'label' => "Twitter user to tweet via for overlays" ) ); ?>
                            </li>
                            <li>
				 	<?php slidedeck_html_input( 'instagram_client_id', $instagram_client_id, array( 'type' => 'text', 'attr' => array( 'class' => 'fancy' ), 'label' => "Instagram Client Id" ) ); ?>

<div style="float:right;font-size:14px;text-decoration:none;">
<a href="https://www.instagram.com/developer/"  target="_blank">Click here to get your client id</a>
 </div>     <br><br>                   
<span style="float:right;">

<br>
 <a href='https://api.instagram.com/oauth/authorize/?client_id=<?php echo $instagram_client_id;?>&redirect_uri=<?php echo admin_url('admin.php?page=slidedeck.php/options');; ?>&response_type=token' class="button instabutton" ><?php _e('Generate Instagram Access Token','ds') ?></a></span></li>				


                            <li>

                            	<?php slidedeck_html_input( 'last_saved_instagram_access_token', $last_saved_instagram_access_token, array( 'type' => 'password', 'attr' => array( 'class' => 'fancy' ), 'label' => "Last used Instagram Access Token" ) ); ?>
                            </li>
                            <li>
			
                            	<?php slidedeck_html_input( 'last_saved_gplus_api_key', $last_saved_gplus_api_key, array( 'type' => 'password', 'attr' => array( 'class' => 'fancy' ), 'label' => "Last used Google+ API Key" ) ); ?>
                            </li>
                            <li>
                            	<?php slidedeck_html_input( 'last_saved_youtube_api_key', $last_saved_youtube_api_key, array( 'type' => 'password', 'attr' => array( 'class' => 'fancy' ), 'label' => "Last used Youtube API Key" ) ); ?>
                            </li>
	    		    <li>
                            	<?php slidedeck_html_input( 'last_saved_dribbble_api_key', $last_saved_dribbble_api_key, array( 'type' => 'password', 'attr' => array( 'class' => 'fancy' ), 'label' => "Last used Dribbble OAuth Key" ) ); ?>
                            </li>
			 
				<li>
                            	<?php slidedeck_html_input( 'last_saved_tumblr_api_key', $last_saved_tumblr_api_key, array( 'type' => 'password', 'attr' => array( 'class' => 'fancy' ), 'label' => "Last used tumblr OAuth Consumer Key" ) ); ?>
                            </li>	
			
                            <li>
                                <?php slidedeck_html_input( 'data[flush_wp_object_cache]', $data['flush_wp_object_cache'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'radio', 'label' => "Enable aggressive cache flushing", 'description' => "Enables a brute force wp_cache_flush() call whenever a SlideDeck is saved." ) ); ?><br />
                            </li>
                        </ul>
                    </div>
                    <div class="save-wrapper">
                        <input type="submit" class="button-primary" value="Update Options" />
                    </div>
                </formset>
            </form>
        </div>
    </div>
</div>
