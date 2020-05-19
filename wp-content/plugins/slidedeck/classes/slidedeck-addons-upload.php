<?php
/**
 * Addon Upload class for SlideDeck Addons, It is designed to install addons from an uploaded zip file.
 *
 * @package SlideDeck
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
require_once (ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
class SlideDeck_Addons_Upload extends WP_Upgrader {
    var $namespace = "slidedeck";
	var $result;
	var $bulk = false;
    var $show_before = '';
    /**
     * Messaging Install Strings
     * 
     * Sets messaging strings for Addon installation
     */
	function install_strings() {
		$this->strings['no_package'] = __( "Install package not available.", $this->namespace );
		$this->strings['unpack_package'] = __( "Unpacking the package&#8230;", $this->namespace );
		$this->strings['installing_package'] = __( "Installing the Addon&#8230;", $this->namespace );
		$this->strings['process_failed'] = __( "Addon install failed.", $this->namespace );
		$this->strings['process_success'] = __( "Addon installed successfully.", $this->namespace );
	}
    
    /**
     * Install Package
     * 
     * Installs the package in the appropriate addons directory
     * 
     * @uses add_filter()
     * @uses is_wp_error()
     * @uses remove_filter()
     * @uses SlideDeck_Addon_Upload::install_string()
     * @uses WP_Upgrader::init()
     * @uses WP_Upgrader::run()
     */
	function install( $package ) {
		
		// create addon directory if it does not exists
		
		if( !is_dir( SLIDEDECK_ADDONS_DIR ) ) {
            if( is_writable( dirname( SLIDEDECK_ADDONS_DIR ) ) ) {
                mkdir( SLIDEDECK_ADDONS_DIR, 0755 );
            }
        }

		$this->init();
		$this->install_strings();

		add_filter( 'upgrader_source_selection', array( &$this, 'check_package' ) );
        add_filter( 'slidedeck_addon_remote_destination', array( &$this, 'slidedeck_addon_destination' ), 10, 3 );
        add_filter( 'slidedeck_addon_destination', array( &$this, 'slidedeck_addon_destination' ), 10, 3 );

		$options = array(
			'package' => $package,
			'destination' => SLIDEDECK_ADDONS_DIR,
			'clear_destination' => false, //Do not overwrite files.
			'clear_working' => true,
			'hook_extra' => array(
                'addon_dirname' => $this->skin->options['addons_dirname']
            )
		);

		$this->run( $options );

		remove_filter( 'upgrader_source_selection', array( &$this, 'check_package' ) );
		remove_filter( 'slidedeck_remote_addon_destination', array( &$this, 'slidedeck_addon_destination' ) );
		remove_filter( 'slidedeck_addon_destination', array( &$this, 'slidedeck_addon_destination' ) );

		if( !$this->result || is_wp_error( $this->result ) )
			return $this->result;
		
		// activate the addon
		/*
         * Handle addon installation and activation dynamically.
         */
        if( 'slidedeck_scheduler' == $this->result['destination_name'] ) {
            add_option( "slidedeck_addon_activate", true );
        } else {
            add_option( "slidedeck_" . str_replace( "-", "_", $this->result['destination_name'] ) . "_addon_activate", true );
        }

		return true;
	}
    
    /**
     * Check the package for validity
     * 
     * Makes sure that the uploaded addons contains all the required files and is configured
     * with the basic required meta data. Returns a WP_Error or the valid package source.
     * 
     * @global $wp_filesystem
     * @global $SlideDeckPlugin
     * 
     * @uses is_wp_error()
     * @uses SlideDeckAddon::get_meta()
     * @uses trailingslashit()
     * @uses WP_Error
     * @uses WP_Filesystem_Base::wp_content_dir()
     * 
     * @return mixed
     */
	function check_package( $source ) {
		global $wp_filesystem, $SlideDeckPlugin;

		if( is_wp_error( $source ) )
			return $source;

		// Check the folder contains a valid addons
		$working_directory = str_replace( $wp_filesystem->wp_content_dir(), trailingslashit( WP_CONTENT_DIR ), $source );
		if( !is_dir( $working_directory ) ) // Sanity check, if the above fails, lets not prevent installation.
			return $source;

		if( !is_dir( SLIDEDECK_ADDONS_DIR ) )
			return new WP_Error( 'incompatible_archive', $this->strings['incompatible_archive'], __( "The /wp-content/plugins/slidedeck-addons folder does not exist, please make sure it exists and is writable by the server.", $this->namespace ) );
		
		if( !is_writable( SLIDEDECK_ADDONS_DIR ) )
			return new WP_Error( 'incompatible_archive', $this->strings['incompatible_archive'], __( "The /wp-content/plugins/slidedeck-addons folder could not be written to.", $this->namespace ) );
		
		if( !file_exists( $working_directory . 'addons.json' ) ) // A proper archive should have a addons.json file in the single subdirectory
			return new WP_Error( 'incompatible_archive', $this->strings['incompatible_archive'], __( "The Addon is missing the <code>addons.json</code> meta descriptor file.", $this->namespace ) );

		$addons_meta = $SlideDeckPlugin->Addons->get_meta( $working_directory . 'addons.json' );
		if( empty( $addons_meta['meta']['name'] ) )
			return new WP_Error( 'incompatible_archive', $this->strings['incompatible_archive'], __( "The <code>addons.json</code> stylesheet doesn't contain a valid addons header.", $this->namespace ) );

		return $source;
	}
	
	/**
     * Install Package routine
     * 
     * install_package() method copied from original WP_Upgrader class and modified for use with
     * SlideDeck Addon installation.
     *
     * @package WordPress
     * @subpackage Upgrader
     * @since 3.3.0
     * 
     * @param array $args Arguments for the package installation
     * 
     * @global $wp_filesystem
     * 
     * @uses apply_filters()
     * @uses copy_dir()
     * @uses is_wp_error()
     * @uses trailingslashit()
     * @uses wp_parse_args()
     * @uses WP_Error
     * @uses WP_Filesystem_Base::delete()
     * @uses WP_Filesystem_Base::dirlist()
     * @uses WP_Filesystem_Base::exists()
     * @uses WP_Filesystem_Base::find_folder()
     * @uses WP_Upgrader_Skin::feedback()
     * 
     * @return object
     */
    function install_package($args = array()) {
        global $wp_filesystem;
        $defaults = array( 'source' => '', 'destination' => '', //Please always pass these
                        'clear_destination' => false, 'clear_working' => false,
                        'hook_extra' => array());

        $args = wp_parse_args($args, $defaults);
        extract($args);

        @set_time_limit( 300 );

        if ( empty($source) || empty($destination) )
            return new WP_Error('bad_request', $this->strings['bad_request']);

        $this->skin->feedback('installing_package');

        $res = apply_filters('upgrader_pre_install', true, $hook_extra);
        if ( is_wp_error($res) )
            return $res;

        //Retain the Original source and destinations
        $remote_source = $source;
        $local_destination = $destination;

        $source_files = array_keys( $wp_filesystem->dirlist($remote_source) );
        $remote_destination = $wp_filesystem->find_folder($local_destination);

        //Locate which directory to copy to the new folder, This is based on the actual folder holding the files.
        if ( 1 == count($source_files) && $wp_filesystem->is_dir( trailingslashit($source) . $source_files[0] . '/') ) //Only one folder? Then we want its contents.
            $source = trailingslashit($source) . trailingslashit($source_files[0]);
        elseif ( count($source_files) == 0 )
            return new WP_Error( 'incompatible_archive', $this->strings['incompatible_archive'], __( 'The plugin contains no files.' ) ); //There are no files?
        else //Its only a single file, The upgrader will use the foldername of this file as the destination folder. foldername is based on zip filename.
            $source = trailingslashit($source);

        //Hook ability to change the source file location..
        $source = apply_filters('upgrader_source_selection', $source, $remote_source, $this);
        if ( is_wp_error($source) )
            return $source;

        //Has the source location changed? If so, we need a new source_files list.
        if ( $source !== $remote_source )
            $source_files = array_keys( $wp_filesystem->dirlist($source) );
        
        //Protection against deleting files in any important base directories.
        if ( in_array( $destination, array(ABSPATH, WP_CONTENT_DIR, WP_PLUGIN_DIR, WP_CONTENT_DIR . '/themes') ) ) {
            $remote_destination = trailingslashit($remote_destination) . trailingslashit(basename($source));
            $destination = trailingslashit($destination) . trailingslashit(basename($source));
        }
        
        /* BEGIN :: Modifications for SlideDeck Addons */
       
        // Modify the remote destination based to create the addons' sub-folder
        $remote_destination = apply_filters( "{$this->namespace}_addon_remote_destination", $remote_destination, $source, $hook_extra );
        // Modify the destination based to create the addons' sub-folder
        $destination = apply_filters( "{$this->namespace}_addon_destination", $destination, $source, $hook_extra );
        
        /* END :: Modifications for SlideDeck Addons */
        
        if ( $clear_destination ) {
            //We're going to clear the destination if there's something there
            $this->skin->feedback('remove_old');
            $removed = true;
            if ( $wp_filesystem->exists($remote_destination) )
                $removed = $wp_filesystem->delete($remote_destination, true);
            $removed = apply_filters('upgrader_clear_destination', $removed, $local_destination, $remote_destination, $hook_extra);

            if ( is_wp_error($removed) )
                return $removed;
            else if ( ! $removed )
                return new WP_Error('remove_old_failed', $this->strings['remove_old_failed']);
        } elseif ( $wp_filesystem->exists($remote_destination) ) {
            //If we're not clearing the destination folder and something exists there already, Bail.
            //But first check to see if there are actually any files in the folder.
            $_files = $wp_filesystem->dirlist($remote_destination);
            if ( ! empty($_files) ) {
                $wp_filesystem->delete($remote_source, true); //Clear out the source files.
                return new WP_Error('folder_exists', $this->strings['folder_exists'], $remote_destination );
            }
        }

        //Create destination if needed
        if ( !$wp_filesystem->exists($remote_destination) )
            if ( !$wp_filesystem->mkdir($remote_destination, FS_CHMOD_DIR) )
                return new WP_Error('mkdir_failed', $this->strings['mkdir_failed'], $remote_destination);

        // Copy new version of item into place.
        $result = copy_dir($source, $remote_destination);
        if ( is_wp_error($result) ) {
            if ( $clear_working )
                $wp_filesystem->delete($remote_source, true);
            return $result;
        }

        //Clear the Working folder?
        if ( $clear_working )
            $wp_filesystem->delete($remote_source, true);

        $destination_name = basename( str_replace($local_destination, '', $destination) );
        if ( '.' == $destination_name )
            $destination_name = '';

        $this->result = compact('local_source', 'source', 'source_name', 'source_files', 'destination', 'destination_name', 'local_destination', 'remote_destination', 'clear_destination', 'delete_source_dir');

        $res = apply_filters('upgrader_post_install', true, $hook_extra, $this->result);
        if ( is_wp_error($res) ) {
            $this->result = $res;
            return $res;
        }

        //Bombard the calling function will all the info which we've just used.
        return $this->result;
    }

    /**
     * Hook into destination override filter for SlideDeck Addons
     * 
     * Appends the directory for the newly uploaded addons to the SlideDeck custom
     * addons directory name root. Returns the modified addons directory path
     * 
     * @global $SlideDeckPlugin
     * 
     * @param string $destination The destination directory of the addons
     * @param object $source The addons file package object being uploaded
     * @param array $hook_extra Additional extras passed to the upload request
     * 
     * @uses SlideDeckAddon::copy_inc()
     * @uses trailingslashit()
     * 
     * @return string
     */
    function slidedeck_addon_destination( $destination, $source, $hook_extra ) {
        global $SlideDeckPlugin;
        
        $addon_dirname = "";
        
        // If $hook_extras already has the addons_dirname, use it
        if( isset( $hook_extra['addon_dirname'] ) && !empty( $hook_extra['addon_dirname'] ) ) {
            $addon_dirname = $hook_extra['addon_dirname'];
        }
                
        $destination = trailingslashit( $destination ) . trailingslashit( $addon_dirname );
        
        return $destination;
    }
}

/**
 * SlideDeck Addon Installer Addon for the WordPress Installer.
 * 
 * Controls the display output and responses when uploading Addons
 */
class SlideDeck_Addon_Installer_Skin extends WP_Upgrader_Skin {
	var $type;

	function __construct( $args = array() ) {
		
		$defaults = array( 'type' => 'web', 'url' => '', 'addons_dirname' => '', 'nonce' => '', 'title' => '' );
		$args = wp_parse_args( $args, $defaults );

		$this->type = $args['type'];
        $this->api = isset( $args['api'] ) ? $args['api'] : array();

		parent::__construct( $args );
	}

	function before() {
		if( !empty( $this->api ) ) {
			/* translators: 1: theme name, 2: version */
			$this->upgrader->strings['process_success'] = __( "Successfully installed the Addon", "slidedeck" );
		}
	}

	function after() {
		$install_actions = array(
			'return' => '<a href="' . slidedeck_action( '/addons' ) . '" title="' . __( "Return to SlideDeck Addon Management", "slidedeck" ) . '">' . __( "Return to SlideDeck Addons Management", "slidedeck" ) . '</a>'
		);
		
		$install_actions = apply_filters( 'install_slidedeck_addon_complete_actions', $install_actions, $this->api );
		
		if( !empty( $install_actions ) )
			$this->feedback( implode( ' | ', (array) $install_actions ) );
	}
}
