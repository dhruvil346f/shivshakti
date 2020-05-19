<?php
/**
 * Constants used by this plugin
 *
 * @package SlideDeck
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

// The current version of this plugin
if( !defined( 'SLIDEDECK_VERSION' ) ) define( 'SLIDEDECK_VERSION', self::$version );

// Environment - change to "development" to load .dev.js JavaScript files (DON'T FORGET TO TURN IT BACK BEFORE USING IN PRODUCTION)
//if( !defined( 'SLIDEDECK_ENVIRONMENT' ) ) define( 'SLIDEDECK_ENVIRONMENT', 'development' );
if( !defined( 'SLIDEDECK_ENVIRONMENT' ) ) define( 'SLIDEDECK_ENVIRONMENT', 'production' );

// The license of this plugin
if( !defined( 'SLIDEDECK_LICENSE' ) ) define( 'SLIDEDECK_LICENSE', self::$license );

// The directory the plugin resides in
if( !defined( 'SLIDEDECK_DIRNAME' ) ) define( 'SLIDEDECK_DIRNAME', dirname( dirname( __FILE__ ) ) );

// The URL path of this plugin
if( !defined( 'SLIDEDECK_URLPATH' ) ) define( 'SLIDEDECK_URLPATH', trailingslashit( plugins_url() ) . basename( SLIDEDECK_DIRNAME ) );

if( !defined( 'SLIDEDECK_IMAGE_BLACKLIST' ) ) define( 'SLIDEDECK_IMAGE_BLACKLIST',                '/(tweetmeme|stats|share-buttons|advertisement|feedburner|commindo|valueclickmedia|imediaconnection|adify|traffiq|premiumnetwork|advertisingz|gayadnetwork|vantageous|networkadvertising|advertising|digitalpoint|viraladnetwork|decknetwork|burstmedia|doubleclick).|feeds\.[a-zA-Z0-9\-_]+\.com\/~ff|wp\-digg\-this|feeds\.wordpress\.com|www\.scoop\.it\/rv|\/media\/post_label_source|ads\.pheedo\.com/i' );
if( !defined( 'SLIDEDECK_POST_TYPE' ) ) define( 'SLIDEDECK_POST_TYPE',                      'sdslide' );
if( !defined( 'SLIDEDECK_SLIDE_POST_TYPE' ) ) define( 'SLIDEDECK_SLIDE_POST_TYPE',                'sd_custom_slide' );
if( !defined( 'SLIDEDECK2_POST_TYPE' ) ) define( 'SLIDEDECK2_POST_TYPE',                      'slidedeck2' );
if( !defined( 'SLIDEDECK2_SLIDE_POST_TYPE' ) ) define( 'SLIDEDECK2_SLIDE_POST_TYPE',                'sd2_custom_slide' );
if( !defined( 'SLIDEDECK1_POST_TYPE' ) ) define( 'SLIDEDECK1_POST_TYPE',                      'slidedeck' );
if( !defined( 'SLIDEDECK1_SLIDE_POST_TYPE' ) ) define( 'SLIDEDECK1_SLIDE_POST_TYPE',                'slidedeck_slide' );
if( !defined( 'SLIDEDECK_NEW_TITLE' ) ) define( 'SLIDEDECK_NEW_TITLE',                      'My SlideDeck' );

/* used for slidedeck mega bundle product
checks if slidedeck5addon is active on the site
if active - changes the path of the lense, source,template,addon to fetch the datab
if inactive - keeps the default path of free plugin.
*/
if( !function_exists('is_plugin_active') ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

$pluginPath = WP_PLUGIN_DIR . "/slidedeck5addons/slidedeck5addons.php";
$active_plugins = (array) get_option( 'active_plugins', array() );
if (in_array("slidedeck5addon/slidedeck5addon.php", $active_plugins))
  {
  if( !defined( 'SLIDEDECK_CUSTOM_LENS_DIR' ) ) define( 'SLIDEDECK_CUSTOM_LENS_DIR',                WP_PLUGIN_DIR . "/slidedeck5addon/slidedeck-lenses" );
  if( !defined( 'SLIDEDECK_CUSTOM_SOURCE_DIR' ) ) define( 'SLIDEDECK_CUSTOM_SOURCE_DIR',                WP_PLUGIN_DIR . "/slidedeck5addon/slidedeck-sources" );
  if( !defined( 'SLIDEDECK_CUSTOM_TEMPLATE_DIR' ) ) define( 'SLIDEDECK_CUSTOM_TEMPLATE_DIR',                WP_PLUGIN_DIR . "/slidedeck5addon/slidedeck-templates" );
  if( !defined( 'SLIDEDECK_ADDONS_DIR' ) ) define( 'SLIDEDECK_ADDONS_DIR',                     WP_PLUGIN_DIR . "/slidedeck5addon/slidedeck-addons" );
  }
else
  {
  if( !defined( 'SLIDEDECK_CUSTOM_LENS_DIR' ) ) define( 'SLIDEDECK_CUSTOM_LENS_DIR',                WP_PLUGIN_DIR . "/slidedeck-lenses" );
  if( !defined( 'SLIDEDECK_CUSTOM_SOURCE_DIR' ) ) define( 'SLIDEDECK_CUSTOM_SOURCE_DIR',                WP_PLUGIN_DIR . "/slidedeck-sources" );
  if( !defined( 'SLIDEDECK_CUSTOM_TEMPLATE_DIR' ) ) define( 'SLIDEDECK_CUSTOM_TEMPLATE_DIR',                WP_PLUGIN_DIR . "/slidedeck-templates" );
  if( !defined( 'SLIDEDECK_ADDONS_DIR' ) ) define( 'SLIDEDECK_ADDONS_DIR',                     WP_PLUGIN_DIR . "/slidedeck-addons" );
  }

if( !defined( 'SLIDEDECK_IS_AJAX_REQUEST' ) ) define( 'SLIDEDECK_IS_AJAX_REQUEST',                ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) );
if( !defined( 'SLIDEDECK_DEFAULT_LENS' ) ) define( 'SLIDEDECK_DEFAULT_LENS',                   'tool-kit' );
if( !defined( 'SLIDEDECK_UPDATE_SITE' ) ) define( 'SLIDEDECK_UPDATE_SITE',                    'http://update.slidedeck.com/update-slidedeck3-com' );
if( !defined( 'SLIDEDECK_RENEWAL_URL' ) ) define( 'SLIDEDECK_RENEWAL_URL',                    'http://www.slidedeck.com/?post_type=product&add-to-cart=13649' );

// define blank image
if( !defined( 'SLIDEDECK_BLANK_IMAGE' ) ) define( 'SLIDEDECK_BLANK_IMAGE',                    esc_url( plugins_url( '../images/blank.gif', __FILE__ ) ));

/**
 * Added by kajal : to fix error Undefined index: REMOTE_ADDR
 */
if( isset( $_SERVER['REMOTE_ADDR'] ) ) {
	$remote_addr = $_SERVER['REMOTE_ADDR'];
}
else {
	$remote_addr = '';
}
// SlideDeck anonymous user hash
if( !defined( 'SLIDEDECK_USER_HASH' ) ) define( 'SLIDEDECK_USER_HASH', sha1( ( isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '' ) . $remote_addr ) );
// KISS Metrics API Key
if( !defined( 'SLIDEDECK_KMAPI_KEY' ) ) define( 'SLIDEDECK_KMAPI_KEY', "e1a603779b1d37b049548f9c8d7a804954ec7a36" );
