<?php
/**
 * SlideDeck Source Model
 * 
 * Model for handling CRUD and other basic functionality for Source management
 * 
 * @author Hummingbird Web Solutions Pvt. Ltd.
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
class SlideDeckSource {
    var $namespace = "slidedeck";
    
    // Expected meta values and types
    var $source_meta = array(
        "name" => "",
        "uri" => "",
        "lenses" => "",
        "description" => "",
        "default_nav_styles" => true,
        "version" => "",
        "variations" => array(),
        "author" => "",
        "autor_uri" => "",
        "contributors" => array(),
        "tags" => array()
    );
    
    /**
     * Indents a flat JSON string to make it more human-readable.
     * 
     * Script courtesy of recursive-design.com. Original post:
     * http://recursive-design.com/blog/2008/03/11/format-json-with-php/
     *
     * @param string $json The original JSON string to process.
     *
     * @return string Indented version of the original JSON string.
     */
    private function _indent_json( $json ) {
        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = '    ';
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;
        
        for ($i=0; $i<=$strLen; $i++) {
        
            // Grab the next character in the string.
            $char = substr($json, $i, 1);
        
            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;
            
            // If this character is the end of an element, 
            // output a new line and indent the next line.
            } else if(($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos --;
                for ($j=0; $j<$pos; $j++) {
                    $result .= $indentStr;
                }
            }
            
            // Add the character to the result string.
            $result .= $char;
        
            // If the last character was the beginning of an element, 
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }
                
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
            
            $prevChar = $char;
        }
        
        // Add spacing after colons between key/value pairs in JSON object
        $result = preg_replace( "/\":(\"|\{|\[|\d)/", '": $1', $result );
        
        return $result;
    }
	
	

	private function _rdelete( $dir ) {
	    if( substr( $dir, -1 ) == "/" ) {
	        $dir = substr( $dir, 0, -1 );
	    }
	
	    if( !file_exists( $dir ) || !is_dir( $dir ) ) {
	        return false;
	    } elseif( !is_writable( $dir ) ) {
	        return false;
	    } else {
	        $handle = opendir( $dir );
	       
	        while( $contents = readdir( $handle ) ) {
	            if( $contents != '.' && $contents != '..' ) {
	                $path = $dir . "/" . $contents;
	               
	                if( is_dir( $path ) ) {
	                    $this->_rdelete( $path );
	                } else {
	                    unlink( $path );
	                }
	            }
	        }
			
	        closedir( $handle );

            if( !rmdir( $dir ) ) {
                return false;
            }
	       
	        return true;
	    }
	}
    
    
	/**
	 * Delete a lens
	 * 
	 * @param string $slug The slug of the lens to be deleted
	 * 
	 * @return boolean
	 */
	function delete( $slug ) {
		$source = $this->get( $slug );
                $dir = '';
                if(isset($source['files']))
                    $dir = dirname( $source['files']['meta'] );
		
		return $this->_rdelete( $dir );
	}
    
	/**
	 * Filter empty values from an array
	 * 
	 * For use as a callback function by array_filter()
	 * 
	 * @param mixed The value to check against
	 */
	function filter_empty( $val ) {
		return !empty( $val );
	}
	
    /**
     * Load a lens
     * 
     * Loads a lens or all lenses (if no lens slug is specified). Parses all meta about the lens
     * and builds an array of information about the lens including paths for all its related
     * asset files.
     * 
     * @param string $slug The slug of a specific lens
     * 
     * @return array
     */
    function get( $slug = "" ) {
        
      
            $sources = array();
            $all_source_files = array();
            $folders = !empty( $slug ) ? $slug : "*";
            
            // Get stock lens files that come with SlideDeck distribution
            $source_files = (array) glob( SLIDEDECK_DIRNAME . '/sources/' . $folders . '/source.json' );

            // Check for custom lenses if the custom lenses folder exists
            if( is_dir( SLIDEDECK_CUSTOM_SOURCE_DIR ) ) {
                // Make sure we can read the folder
                if( is_readable( SLIDEDECK_CUSTOM_SOURCE_DIR ) ) {
                    // Load and combine the custom lenses in with the stock lenses
                    $custom_source_files = (array) glob( SLIDEDECK_CUSTOM_SOURCE_DIR . '/' . $folders . '/source.json' );
                	$source_files = array_merge( $source_files, $custom_source_files );
                }
            }
            // Loop through each lens file to build an array of lenses
            foreach( (array) $source_files as $source_file ) {
                $key = basename( dirname( $source_file ) );
                $all_source_files[$key] = $source_file;
            }
            
            // Append each lens to the $lenses array including the lens' meta
            foreach ( (array) array_values( $all_source_files ) as $source_file ) {
                if ( is_readable( $source_file ) ) {
                    $source_meta = $this->get_meta( $source_file );
                    $sources[$source_meta['slug']] = $source_meta;
                }
            }
            
            
      
        
        
        return $sources;
    }

	/**
	 * Get Lens CSS content
	 * 
	 * Loads a lens' CSS file and returns the content of the lens file with the 
	 * meta comment extracted.
	 * 
	 * @param string $filename The file name of the lens to get the content from
	 * @param boolean $strip_meta Should the meta be stripped from the top of the page?
	 * 
	 * @return string
	 */
	function get_content( $filename ) {
		$source_content = "";
		
		// Only load the content if this is actually a file and it isn't empty
		if ( is_file( $filename ) && filesize( $filename ) > 0 ) {
			$f = fopen( $filename , 'r' );
			$source_content = fread( $f, filesize( $filename ) );
		}
		
		return $source_content;
	}
	
   
    /**
     * Process lens meta data from a lens file. Used by slidedeck_get_lens and slidedeck_get_lenses
     * 
     * @param object $lens_file
     * 
     * @uses site_url()
     * 
     * @return arr Lens meta data
     */
    function get_meta( $filename ) {
    	global $SlideDeckPlugin;
		
        
        
        
        
            $source_data = file_get_contents( $filename );
            $source_folder = dirname( $filename );
            $source_slug = basename( $source_folder );
            
            // Pre-populate the lens meta with default values and types
            $source_meta = $this->source_meta;
            // Lens JSON descriptor
            $source_file_meta = json_decode( $source_data, true );
            // Merge with the default options
            $source_meta = array_merge( $source_meta, $source_file_meta );
            
            // Get the lens' base folder URL
            $source_url = untrailingslashit( WP_PLUGIN_URL ) . str_replace(str_replace("\\","/",WP_PLUGIN_DIR), "", str_replace("\\","/",$source_folder));
            
            // Adjust URL for SSL if we are running the current page through SSL
            if( is_ssl() ) $source_url = str_replace( "http://", "https://", $source_url );
            
            $source = array(
                
                'thumbnail' => $source_url . "/thumbnail.jpg",
                'thumbnail-large' => $source_url . "/thumbnail-large.jpg",
                'slug' => $source_slug,
                
                'meta' => $source_meta,
                'files' => array(
                    'meta' => $source_folder . '/source.json'
                    
                )
            );

	    
			
            

         

        return $source;
    }

    /**
     * Check if this lens is protected
     * 
     * Checks to see if the lens file requested belongs to one of the stock lenses that comes with
     * SlideDeck. Any lens that exists in the /wp-content/plugins/slidedeck/lenses folder is considered
     * protected and cannot be edited via the editing interface. To edit one of these lenses, copy
     * it first to the /wp-content/plugins/slidedeck-lenses folder via FTP or the management interface.
     * 
     * @param string $lens_filename The full filename of the lens to check
     * 
     * @return boolean
     */
    function is_protected( $source_filename ) {
        $protected = true;
        
        // Check for existence of the file first
        $file_exists = is_file( $source_filename );
        
        if( $file_exists ) {
            if( str_replace( "\\", "/", dirname( dirname( $source_filename ) ) ) == str_replace( "\\", "/", SLIDEDECK_CUSTOM_SOURCE_DIR ) ) {
                $protected = false;
            }
        }
        
        return $protected;
    }
    
    /**
     * Detect if the Lens folder is writeable
     * 
     * Looks to make sure that the custom Lens folder exists and is writeable. Returns an object
     * with an appropriate error message and status.
     * 
     * @return object
     */
    function is_writable() {
        $response = array(
            'valid' => false,
            'error' => ""
        );
        
        if( is_dir( SLIDEDECK_CUSTOM_SOURCE_DIR ) ) {
            if( is_writable( SLIDEDECK_CUSTOM_SOURCE_DIR ) ) {
                $response['valid'] = true;
            } else {
                $response['valid'] = false;
                $response['error'] = "<strong>ERROR:</strong> The " . SLIDEDECK_CUSTOM_SOURCE_DIR . " directory is not writable, please make sure the server can write to it.";
            }
        } else {
            $response['valid'] = false;
            $response['error'] = "<strong>ERROR:</strong> The " . SLIDEDECK_CUSTOM_SOURCE_DIR . " directory does not exist, please create it and make sure the server can write to it.";
        }
        
        return (object) $response;
    }
    
    /**
     * Parses raw HTML and returns an array of images
     * 
     * @param string $html_string Raw HTML to be processed
     * 
     * @return array
     */
    function parse_html_for_images( $html_string = "" ) {
        $html_string = preg_replace( "/([\n\r]+)/", "", $html_string );
        
        $image_strs = array();
        preg_match_all( '/<img(\s*([a-zA-Z]+)\=[\"\']([a-zA-Z0-9\/\#\&\=\|\-_\+\%\!\?\:\;\.\(\)\~\s\,]*)[\"\'])+\s*\/?>/', $html_string, $image_strs );

        $images_all = array();
        if( isset( $image_strs[0] ) && !empty( $image_strs[0] ) ) {
            foreach( (array) $image_strs[0] as $image_str ) {
                $image_attr = array();
                preg_match_all( '/([a-zA-Z]+)\=[\"\']([a-zA-Z0-9\/\#\&\=\|\-_\+\%\!\?\:\;\.\(\)\~\s\,]*)[\"\']/', $image_str, $image_attr );
                
                if( in_array( 'src', $image_attr[1] ) ) {
                    $images_all[] = array_combine( $image_attr[1], $image_attr[2] );
                }
            }
        }
        
        $images = array();
        if( !empty( $images_all ) ) {
            foreach( $images_all as $image ) {
                // Filter out advertisements and tracking beacons
                if( $this->test_image_for_ads_and_tracking( $image['src'] ) ) {
                    $images[] = $image['src'];
                }
            }
        }
        
        return $images;
    }
    
    /**
     * Parses image URL and returns false if it's a banned image 
     * 
     * @param string $image an image URL
     * 
     * @return mixed false if is an advertisment/banned and the image strign if not
     */
    function test_image_for_ads_and_tracking( $input_image = "" ) {
        // Filter out advertisements and tracking beacons
        $blacklist_regex = apply_filters( "{$this->namespace}_image_blacklist", SLIDEDECK_IMAGE_BLACKLIST );
        if( preg_match( $blacklist_regex, $input_image ) )
            return false;
        
        return $input_image;
    }
    
    
}
