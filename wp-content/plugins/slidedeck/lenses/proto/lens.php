<?php
class SlideDeckLens_Proto extends SlideDeckLens_Scaffold {
    var $options_model = array(
        'Appearance' => array(
            'titleFont' => array(
                'value' => 'bitter'
            ),
            'hideSpines' => array(
                'type' => 'hidden',
                'value' => true
            )
        )
    );
    
    function __construct(){
        parent::__construct();
        add_filter( "{$this->namespace}_get_slides", array( &$this, "slidedeck_get_slides" ), 11, 2 );
        // added filters to remove lens code from the core
        add_filter( "{$this->namespace}_render_slidedeck_wrapper_content_before_proto", array( &$this, "slidedeck_render_slidedeck_wrapper_content_before" ), 12, 6 );
        add_filter( "{$this->namespace}_render_slidedeck_wrapper_content_after_proto", array( &$this, "slidedeck_render_slidedeck_wrapper_content_after" ), 12, 2 );
        
        add_filter( "{$this->namespace}_render_slidedeck_wrapper_before_proto", array( &$this, "slidedeck_render_slidedeck_wrapper_before" ), 13, 8);
        add_filter( "{$this->namespace}_render_slidedeck_wrapper_after_proto", array( &$this, "slidedeck_render_slidedeck_wrapper_after" ), 13, 1 );
        
        add_filter( "{$this->namespace}_render_slidedeck_navigation_content_proto", array( &$this, "slidedeck_render_slidedeck_navigation_content" ), 15, 1 );
        
        add_filter( "{$this->namespace}_render_dt_and_dd_elements_before_proto", array( &$this, "slidedeck_render_dt_and_dd_elements_before" ), 14, 7 );
        add_filter( "{$this->namespace}_render_dt_and_dd_elements_after_proto", array( &$this, "slidedeck_render_dt_and_dd_elements_after" ), 14, 1 );

        add_filter( "{$this->namespace}_render_slidedeck_footer_scripts_proto", array( &$this, "slidedeck_render_slidedeck_footer_scripts" ), 12, 5 );
        add_filter( "{$this->namespace}_render_slidedeck_image_protection_proto", array( &$this, "slidedeck_render_slidedeck_image_protection" ), 12, 3 );
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
        
        $html .= '<dl id="' . $slidedeck_unique_id . '" class="' . implode( " ", $slidedeck_classes ) . '" style="' . $slidedeck_styles_str . '">';
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
        
        if( $slide['type'] == "video" ){
            $output .= '<dd itemprop="video" itemscope itemtype="http://schema.org/VideoObject" style="' . $slide['styles'] . '" class="' . implode( " ", $slide['classes'] ) . '" data-thumbnail-src="' . $slide['thumbnail'] . '" data-slide-id="'.$slide_id.'" >';
        } else {
            $output .= '<dd itemscope="" itemtype="http://schema.org/ImageObject" style="' . $slide['styles'] . '" class="' . implode( " ", $slide['classes'] ) . '" data-thumbnail-src="' . $slide['thumbnail'] . '" data-slide-id="'.$slide_id.'" >';
        }
        return $output;
    }
    function slidedeck_render_dt_and_dd_elements_after($output) {
        
        $output .= "</dd>";
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
}
