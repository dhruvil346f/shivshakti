<?php
class SlideDeckLens_Fashion extends SlideDeckLens_Scaffold {
    var $options_model = array(
        'Appearance' => array(
            'accentColor' => array(
                'value' => "#f9e836"
            ),
            'titleFont' => array(
                'value' => "lato"
            ),
			'show-title-rule' => array(
				'suffix' => 'Shows/Hides the double bar rule behind the title',
				'label' => 'Show Title Rule',
				'type' => 'radio',
                'data' => "boolean",
                'value' => true,
                'weight' => 70
			),
			'show-shadow' => array(
				'suffix' => 'Shows/Hides white drop shadow around content',
				'label' => 'Show Box Shadow',
				'type' => 'radio',
                'data' => "boolean",
                'value' => true,
                'weight' => 80
			),
            'hideSpines' => array(
                'type' => 'hidden',
                'value' => true
            )
        ),
        'Navigation' => array(
            'navigation-type' => array(
				'name' => 'navigation-type',
				'type' => 'select',
				'values' => array(
					'number-nav' => 'Numbers',
					'dot-nav' => 'Dots'
				),
				'value' => 'numbers',
				'label' => 'Navigation Type',
				'description' => "Show dots or numbers on the navigation bar",
				'weight' => 20
			),
        )
    );
    function __construct(){
        parent::__construct();
        add_filter( "{$this->namespace}_get_slides", array( &$this, "slidedeck_get_slides" ), 11, 2 );
        // added filters to remove lens code from the core
        add_filter( "{$this->namespace}_render_slidedeck_wrapper_content_before_fashion", array( &$this, "slidedeck_render_slidedeck_wrapper_content_before" ), 12, 6 );
        add_filter( "{$this->namespace}_render_slidedeck_wrapper_content_after_fashion", array( &$this, "slidedeck_render_slidedeck_wrapper_content_after" ), 12, 2 );
        
        add_filter( "{$this->namespace}_render_slidedeck_wrapper_before_fashion", array( &$this, "slidedeck_render_slidedeck_wrapper_before" ), 13, 8);
        add_filter( "{$this->namespace}_render_slidedeck_wrapper_after_fashion", array( &$this, "slidedeck_render_slidedeck_wrapper_after" ), 13, 1 );
        
        add_filter( "{$this->namespace}_render_slidedeck_navigation_content_fashion", array( &$this, "slidedeck_render_slidedeck_navigation_content" ), 15, 1 );
        
        add_filter( "{$this->namespace}_render_dt_and_dd_elements_before_fashion", array( &$this, "slidedeck_render_dt_and_dd_elements_before" ), 14, 7 );
        add_filter( "{$this->namespace}_render_dt_and_dd_elements_after_fashion", array( &$this, "slidedeck_render_dt_and_dd_elements_after" ), 14, 1 );

        add_filter( "{$this->namespace}_render_slidedeck_footer_scripts_fashion", array( &$this, "slidedeck_render_slidedeck_footer_scripts" ), 12, 5 );
        add_filter( "{$this->namespace}_render_slidedeck_image_protection_fashion", array( &$this, "slidedeck_render_slidedeck_image_protection" ), 12, 3 );
        // end of filters added to remove lens code from the core
    }
    function slidedeck_render_slidedeck_footer_scripts($footer_scripts, $slidedeck_unique_id, $jquery_cycle_options, $javascript_options, $vertical_scripts ) {
        
        $footer_scripts .= '<script type="text/javascript">jQuery("#' . $slidedeck_unique_id . '").slidedeck( ' . json_encode( $javascript_options ) . ' )' . $vertical_scripts . ';</script>';
        return $footer_scripts;
    }
    function slidedeck_render_slidedeck_image_protection($footer_scripts, $slidedeck_unique_id, $id ) {
        
        $footer_scripts .= '<script type="text/javascript">
                    jQuery("#' . $slidedeck_unique_id . '-frame img").bind("contextmenu", function(e){
                    var defaultImageProtection = jQuery("#' . $slidedeck_unique_id . '-frame").data("sd3-image_protection");
                    if(defaultImageProtection == "0")
                        return true;
                    else
                        return false;
                    });
                 </script>';
        return $footer_scripts;
    }
    function slidedeck_render_slidedeck_wrapper_content_before($html, $slidedeck, $slidedeck_unique_id, $id, $slidedeck_styles_str, $slidedeck_classes ) {
        
        $html .= '<ul id="' . $slidedeck_unique_id . '" class="' . implode( " ", $slidedeck_classes ) . '" style="' . $slidedeck_styles_str . '">';
        return $html;
    }
    function slidedeck_render_slidedeck_wrapper_content_after($html) {
        
        $html.= '</ul>';
        return $html;
    }
    function slidedeck_render_slidedeck_wrapper_before($html, $slidedeck, $slidedeck_unique_id, $id, $frame_styles_str, $slidedeck_image_protection, $frame_classes, $slidedeck_lazy_load_padding ) {
        
        $html .= '<div id="' . $slidedeck_unique_id . '-frame" class="' . implode( " ", $frame_classes ) . '" style="' . $frame_styles_str . '" data-sd2-lazy-load-padding="' . $slidedeck_lazy_load_padding . '" data-sd3-image_protection="' . $slidedeck_image_protection . '">';
        return $html;
    }
    function slidedeck_render_slidedeck_navigation_content($html) {
        $html .= '<a class="deck-navigation horizontal prev" href="#prev-horizontal"><span>Previous</span></a>';
        $html .= '<a class="deck-navigation horizontal next" href="#next-horizontal"><span>Next</span></a>';
        $html .= '<a class="deck-navigation vertical prev" href="#prev-vertical"><span>Previous</span></a>';
        $html .= '<a class="deck-navigation vertical next" href="#next-vertical"><span>Next</span></a>';
        return $html;
    }
    function slidedeck_render_slidedeck_wrapper_after($html) {
        
        $html.= '</div>';
        return $html;
    }
    function slidedeck_render_dt_and_dd_elements_before($output, $slidedeck, $slide, $slide_id, $spine_classes, $spine_styles, $slide_title) {
        wp_enqueue_script( 'cycle-all' );
        if( $slide['type'] == "video" ){
            $output .= '<li itemscope="" itemtype="http://schema.org/VideoObject" style="' . $slide['styles'] . '" class="' . implode( " ", $slide['classes'] ) . '" data-thumbnail-src="' . $slide['thumbnail'] . '" data-slide-id="'.$slide_id.'" >';
        } else {
            $output .= '<li itemscope="" itemtype="http://schema.org/ImageObject" style="' . $slide['styles'] . '" class="' . implode( " ", $slide['classes'] ) . '" data-thumbnail-src="' . $slide['thumbnail'] . '" data-slide-id="'.$slide_id.'" >';
        }
        return $output;
    }
    function slidedeck_render_dt_and_dd_elements_after($output) {
        
        $output .= "</li>";
        return $output;
    }
    /**
     * Adding the accent-color class to the <a> tags if Twitter
     *
     * @param array $slides Array of Slides
     * @param array $slidedeck The SlideDeck object being rendered
     * 
     * @uses SlideDeckLens_Scaffold::is_valid()
     * 
     * @return array
     */
    function slidedeck_get_slides( $slides, $slidedeck ){
        if( $this->is_valid( $slidedeck['lens'] ) ){
            foreach( $slides as &$slide ){
                if( $slidedeck['source'] == 'twitter' ){
                    $slide['content'] = preg_replace( '/\<a /', '<a class="accent-color" ', $slide['content'] );
                }
            }
        }
        return $slides;
    }
	/**
     * Modify Slide title to wrap in spans for stlying
     * 
     * @param array $nodes $nodes Various information nodes available to use in the template file
     * 
     * @return array
     */
	function slidedeck_slide_nodes( $nodes, $slidedeck ){
		if( $this->is_valid( $slidedeck['lens'] ) ) {
			$temp_title = $nodes['title'];
			$title_parts = explode( " ", $temp_title );
			$new_title = "";
            $count = 1;
			foreach( $title_parts as $title_part ){
				if( $count == 1 ){
    				$new_title .= '<span class="first">'. $title_part .'</span> ';
				}else{
    				$new_title .= '<span>'. $title_part .'</span> ';
				}
                $count++;
			}
			$nodes['title'] = $new_title;
            
            if( in_array('twitter', $slidedeck['source'] ) ){
                        
                $url_regex = '/((https?|ftp|gopher|telnet|file|notes|ms-help):((\/\/)|(\\\\))+[\w\d:#@%\/\;$()~_?\+-=\\\.&]*)/';
               
                /**
                 * This preg split takes a tweet (URLs, words, hashtags, usernames) and breaks it up wherever
                 * there is already a html tag (the input has <a> tags wrapped around the aforementioned) and breaks it up.
                 * This gives us an array with strings, and links broken up into elements.
                 * 
                 * This allow us to break each word and "linkified" words in their own spans.
                 */
                $split_html = preg_split( '/<\/?\w+((\s+\w+(\s*=\s*(?:\".*?\\\"|.*?|[^">\s]+))?)+\s*|\s*)\/?>/s', $nodes['excerpt'] );
                
                // Reset the excerpt node for appending to.
                $nodes['excerpt'] = '';
                foreach( $split_html as $segment ){
                    if( preg_match( $url_regex, $segment ) ){
                        // If the current segment looks like a URL, wrap and append it.
                        $nodes['excerpt'] .= '<span><a class="accent-color" href="'. $segment .'" target="_blank">'. $segment .'</a></span>';
                    }elseif( preg_match( '/(\@([a-zA-Z0-9_]+))|(\#([a-zA-Z0-9_]+))/', $segment ) ){
                        // If the current segment looks like a mention or hashtag, wrap and append it. 
                        $nodes['excerpt'] .= '<span><a class="accent-color" href="http://twitter.com/search?q='. $segment .'" target="_blank">'. $segment .'</a></span>';
                    }else{
                        /**
                         * If the current segment is neither, then we can reasonably assume it's a string of words.
                         * Here we'll run the existing split and wrap code.
                         */
                        if( !empty( $segment ) ){
                            $segment = trim( $segment );
                			$temp_excerpt = strip_tags( $segment );
                			$excerpt_parts = explode( " ", $temp_excerpt );
                			$new_excerpt = "";
                			$count = 1;
                			foreach( $excerpt_parts as $excerpt_part ){
                    			if ( $count == 1 ) {
                        			$new_excerpt .= '<span class="first">'. $excerpt_part .'</span> ';
                    			} else {
                        		    $new_excerpt .= '<span>'. $excerpt_part .'</span> ';	
                    			}
                			}
                            $new_excerpt = preg_replace($url_regex, '<a href="$1" target="_blank">'. "$1" .'</a>', $new_excerpt);
                            $new_excerpt = preg_replace( array(
                                '/\@([a-zA-Z0-9_]+)/',
                                '/\#([a-zA-Z0-9_]+)/'
                            ), array(
                                '<a href="http://twitter.com/$1" target="_blank">@$1</a>',
                                '<a href="http://twitter.com/search?q=%23$1" target="_blank">#$1</a>'
                            ), $new_excerpt );
                            
                			$nodes['excerpt'] .= $new_excerpt;
                        } // if( !empty( $segment ) )
                    } // else (is a string)
                } // foreach( $split_html as $segment )
            } // if the source is twitter
		} // if is a valid lens
		
		return $nodes;
	}

	function slidedeck_dimensions( &$width, &$height, &$outer_width, &$outer_height, &$slidedeck ) {
		if( $this->is_valid( $slidedeck['lens'] ) ) {
			// Add 44px for the bottom navigation on the lens.
			$height = $height - 44;
		}
	}

    /**
     * Add appropriate classes for this Lens to the SlideDeck frame
     * 
     * @param array $slidedeck_classes Classes to be applied
     * @param array $slidedeck The SlideDeck object being rendered
     * 
     * @return array
     */
    function slidedeck_frame_classes( $slidedeck_classes, $slidedeck ) {
        if( $this->is_valid( $slidedeck['lens'] ) ) {
            $slidedeck_classes[] = $this->prefix . $slidedeck['options']['navigation-type'];	
        }
        
        return $slidedeck_classes;
    }
}
