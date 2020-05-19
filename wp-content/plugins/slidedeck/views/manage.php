<?php
/**
 * Overview list of SlideDecks
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
<?php
    $opt = get_option($this->option_name);
    if(isset($opt['addon_access_key'])) :
    $addon_access_key = $opt['addon_access_key'];
    else :
    $addon_access_key = '';
    endif;
?>
<?php slidedeck_flash(); ?>

<div class="slidedeck-wrapper">
    <div class="" id="slidedeck-overview">
        <?php if( isset( $_GET['msg_deleted'] ) ): ?>
            <div id="slidedeck-flash-message" class="updated" style="max-width:964px;"><p><?php _e( "SlideDeck successfully deleted!", $namespace ); ?></p></div>
            <script type="text/javascript">(function($){if(typeof($)!="undefined"){$(document).ready(function(){setTimeout(function(){$("#slidedeck-flash-message").fadeOut("slow");},5000);});}})(jQuery);</script>
        <?php endif; ?>
        <div id="slidedeck-types">
            <span class="demo button"><a target="_blank" href="https://www.slidedeck.com/slidedeck-types-examples/?utm_source=sd5_demos&utm_campaign=sd5_litel&utm_medium=link">Demo</a></span>
            <span class="docs button"><a target="_blank" href="https://docs.slidedeck.com/?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link">Documentation</a></span>
            <div class="loader" style="display:none">
	<img  src= "<?php echo SLIDEDECK_URL .'/images/lazy-load-large.gif' ?>" >
	</div>
	<?php


do_action("slidedeck_dashboard"); ?>
            <?php echo $this->upgrade_button('manage'); ?>
            <h1><?php _e( "Manage SlideDeck 3", $namespace ); ?></h1>
            <?php
               //$create_dynamic_slidedeck_block_html = apply_filters( "{$namespace}_create_dynamic_slidedeck_block", "" );
               //echo $create_dynamic_slidedeck_block_html;

               $create_new_slide_slidedeck_block = apply_filters( "{$namespace}_create_new_slide_slidedeck_block", "" );
               echo $create_new_slide_slidedeck_block;

               $create_slide_using_template_block = apply_filters( "{$namespace}_create_slide_using_template_block", "" );
               echo $create_slide_using_template_block;

               //$create_custom_slidedeck_block_html = apply_filters( "{$namespace}_create_custom_slidedeck_block", "" );
               //echo $create_custom_slidedeck_block_html;
            ?>
        </div>

        <div id="slidedeck-table">
            <div id="sd-addon-register" class="sd-addon-register">
                <?php if(!isset($addon_access_key) || empty($addon_access_key)) :  ?>
            <!-- <span class="sd-free-addon"><a href="https://www.slidedeck.com/sdlp/subscribe-to-get-your-free-copy/" target="blank" class="">Subscribe to get free addons</a></span> -->
            <?php endif; ?>
            <!-- <span class="sd-free-addon-form">

                <input type="text" placeholder="Enter subscription key" id="slidedeck-addon-key" name="slidedeck-addon-key" value="<?php if(isset($addon_access_key))echo $addon_access_key;?>" />
                    <?php wp_nonce_field( "{$this->namespace}_verify_addon_key", 'verify_addon_nonce' ); ?>
                        <input type="button" id="slidedeck-addon-key-submit" class="button" name="slidedeck-addon-key-submit" value="Verify Key" />

            </span> -->
            <?php if(isset($addon_access_key)) : ?>
                <script>jQuery('#slidedeck-addon-key-submit').addClass('disabled');
               jQuery( "#slidedeck-addon-key" ).focusin(function() {
                    jQuery('#slidedeck-addon-key-submit').removeClass('disabled');
                });
                jQuery( "#slidedeck-addon-key" ).focusout(function() {
                    jQuery('#slidedeck-addon-key-submit').addClass('disabled');
                });
                </script>
            <?php endif; ?>
            </div>
            <div id="sd-addon-register-msg"></div>
            <?php if( !empty( $slidedecks ) ): ?>

                <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" id="slidedeck-table-sort">
                    <fieldset>
                        <?php  /*
                                *Seach field and submit button for slider search
                                */ ?>
                        <input type="search" placeholder="Search slider by name.." id="slidedeck-search" name="slidedeck-search"  />
                        <input type="submit" id="slidedeck-search-submit" class="button" name="slidedeck-search-submit" value="Search" />
                        <input type="hidden" value="<?php echo $namespace; ?>_sort_manage_table" name="action" />
                        <?php wp_nonce_field( "slidedeck-sort-manage-table" ); ?>

                        <label for="slidedeck-table-sort-select" class="slidedeck-table-sort-select-label"><?php _e( "Sort By:", $namespace ); ?></label>
                        <select name="orderby" id="slidedeck-table-sort-select" class="fancy">
                            <?php foreach( $order_options as $value => $label ): ?>
                                <option value="<?php echo $value; ?>"<?php if( $value == $orderby ) echo ' selected="selected"'; ?>><?php _e( $label, $namespace ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </fieldset>
                </form>

            <?php endif; ?>

            <div class="float-wrapper">
                <div class="left">

                    <?php include( SLIDEDECK_DIRNAME . '/views/elements/_manage-table.php' ); ?>
                </div>
                <div class="right">
                    <div class="right-inner">
                        <div id="manage-iab" class="iab">
                            <a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/slidedeck?filter=5#postform"><img src="<?php echo SLIDEDECK_URLPATH .'/images/leave-us-rating.png'?>" border="0" width="184" height="160"/></a>
                        </div>
                        <div id="manage-iab manage-iab-offer" class="iab">
                        </div>
                        <?php if(isset($addon_access_key)) :  ?>
                        <div id="slidedeck-support-questions" class="right-column-module">
                            <h4><?php _e( "Have questions?", $namespace ); ?></h4>
                            <p><?php _e( "See if there are any solutions in our support section.", $namespace ); ?></p>
                            <a href="<?php admin_url( 'admin.php' ); ?>?page=slidedeck.php/support" class="button slidedeck-noisy-button" target="_blank"><span><?php _e( "Get Support" , $namespace ); ?></span></a>
                        </div>
                        <?php endif; ?>
                        <?php do_action( "{$namespace}_manage_sidebar_bottom" ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
