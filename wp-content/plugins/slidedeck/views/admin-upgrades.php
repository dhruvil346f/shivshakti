<?php
/**
 * SlideDeck Upgrade Options
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

<div class="slidedeck-wrapper upgrades">
    <?php slidedeck_flash(); ?>
    <div class="wrap">
        <div id="slidedeck-upgrade-wrapper">
            <!--
            <div class="slidedeck-license-key-wrapper">
            	<form id="verify_addons_license_key" action="">
            		<input type="hidden" name="action" value="slidedeck_verify_addons_license_key" />
            		<?php foreach( (array) $_REQUEST as $key => $val ): ?>
            			<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $val; ?>" />
        			<?php endforeach; ?>
        			<?php
	        			if( empty( $license_key ) && isset( $_REQUEST['license_key']) && !empty( $_REQUEST['license_key'] ) ){
	        				$license_key = $_REQUEST['license_key'];
	        			}
        			?>
	                <?php slidedeck_html_input( 'data[license_key]', $license_key, array( 'type' => 'password', 'attr' => array( 'class' => 'fancy license-key-text-field' ), 'label' => "Update Your SlideDeck License Key" ) ); ?>
	                <?php wp_nonce_field( "{$this->namespace}_verify_addons_license_key", 'verify_addons_nonce' ); ?>
	                <a href="#verify" class="verify-license-key button">Verify</a>
            	</form>
            </div>
            -->
            <div class="addon-verification-response">
                <!--<span>
                    <a target="_blank" href="https://www.slidedeck.com/cart/?add-to-cart=20823&utm_source=sd5_upgrade_banner&utm_campaign=sd5_lite_pro_bundle&utm_medium=link">
                   <img src="https://s3-us-west-2.amazonaws.com/slidedeck-pro/addons_assets/images/slidedeck5litebanner-new.png" width="100%" height="100%" alt="SlideDeck 5 Wordpress Slider in Minutes">
                   </a>
                   </span>
                -->
                <div class="club_wrapper_main">
                    <div class="clubplan">
                        <div id="club-pricing" class="cc_aligncenter"></div>
                        <div class="pricing_cc">
                            <div class="pricing-3column">
                                <div class="row">
                                    <div class="starter_2b">
                                        <div class="cc-features">
                                            <div class="blox_elem_price_plan_name">
                                                <h3><span class="dashicons"></span> Features</h3>
                                            </div>
                                        </div>
                                        <div class="top">
                                            <div class="blox_elem_price_plan_text">
                                                <ul>
                                                    <li title="Renewal"><span class="dashicons"></span> Lenses</li>
                                                    <li title="One Time Sign Up Fee"><span class="dashicons"></span> Image Slider</li>
                                                    <li title="One Time Sign Up Fee"><span class="dashicons"></span> Video Slider</li>
                                                    <li title="One Time Sign Up Fee"><span class="dashicons"></span> Text Slider (Dev Add-on)</li>
                                                    <li title="One Time Sign Up Fee"><span class="dashicons"></span> HTML Slider (Dev add-on)</li>
                                                    <li title="One Time Sign Up Fee"><span class="dashicons"></span> Custom CSS</li>
                                                    <li title="One Time Sign Up Fee"><span class="dashicons"></span> Call to Action (CTA)</li>
                                                    <li title="One Time Sign Up Fee"><span class="dashicons"></span> Ready to use Templates</li>
                                                    <li title="Any new theme or plugin released in the future - usually one per month"><span class="dashicons"></span> Social Media Sources</li>
                                                    <li title="All Current Themes &amp; Plugins"><span class="dashicons"></span>Video Sources</li>
                                                    <li title="All Current Themes &amp; Plugins"><span class="dashicons"></span>Image Gallery Sources</li>
                                                    <li title="All Current Themes &amp; Plugins"><span class="dashicons"></span>NextGen Gallery</li>
                                                    <li title="All Current Themes &amp; Plugins"><span class="dashicons"></span>Scheduler Add-on</li>
                                                    <li title="All Current Themes &amp; Plugins"><span class="dashicons"></span>Import/Export Add-on</li>
                                                    <li title="All Current Themes &amp; Plugins"><span class="dashicons"></span>Lead generation Add-on</li>
                                                    <li title="Access to Downloads &amp; Updates, Support for Trouble-shooting, Bug Fixes"><span class="dashicons"></span> Updates, Support</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="superior_2b yearly">
                                        <div class="superior_2b_container">
                                            <div class="cc-pricing-top">
                                                <div class="blox_elem_price_plan_name">
                                                    <h3>SlideDeck Plugin</h3>
                                                </div>
                                                <div class="blox_elem_price_plan_price">
                                                    <div class="cc-product-price">Free</div>
                                                </div>
                                            </div>
                                            <div class="top">
                                                <div class="blox_elem_price_plan_text_superior">
                                                    <ul>
                                                        <li>3</li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                        <li><span class="dashicons dashicons-no-alt"></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<a class="pricing-buy-this-pack purchase popular_purchase" target="_blank" href="https://downloads.wordpress.org/plugin/slidedeck.5.1.9.zip">Download NOW</a>-->
                                    </div>
                                    <div class="superior_2b monthly-popular">
                                        <div class="superior_2b_container">
                                            <div class="cc-pricing-top-popular">
                                                <div class="blox_elem_price_plan_name">
                                                    <h3>Extensions Bundle</h3>
                                                </div>
                                                <div class="blox_elem_price_plan_price">
                                                    <div class="cc-product-price">Pro</div>
                                                </div>
                                            </div>
                                            <div class="top">
                                                <div class="blox_elem_price_plan_text_superior">
                                                    <ul>
                                                        <li>20+</li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                        <li><span class="dashicons dashicons-yes"></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="pricing-buy-this-pack purchase popular_purchase" target="_blank" href="https://www.slidedeck.com/slidedeck5-pricing/">BUY NOW</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
