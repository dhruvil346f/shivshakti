<?php
/**
 * SlideDeck Options view
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
<div id="options-group-wrapper">
    <?php do_action( "{$namespace}_options_group_wrapper_top", $slidedeck ); ?>
    <div id="slidedeck-options-groups">
        <dl class="slidedeck">
            <dd>
                <dl class="slidesVertical clearfix">

                    <dt><?php _e( "Lenses", $namespace ); ?></dt>
                    <dd class="clearfix options-group-leneses">
                        <div id="slidedeck-section-lenses" class="options-list clearfix">
                            <?php include( SLIDEDECK_DIRNAME . '/views/elements/_options-lenses.php' ); ?>
                        </div>
                    </dd>

                	<dt><?php _e( "Setup", $namespace ); ?></dt>
                	<dd class="clearfix options-group-setup">

                        <ul class="options-list">
                            <?php if($slidedeck['lens'] != 'pixel') : ?>
                            <li id="slidedeck-sizes">
                                <?php else: ?>
                            <li id="slidedeck-sizes" style="display:none;">
                                <?php endif; ?>
                                <span class="label"><?php _e( $options_model['Setup']['size']['label'], $namespace ); ?> <span class="tooltip" title="<?php _e( $options_model['Setup']['size']['description'], $namespace ); ?>"></span></span>
    							<?php
    							    $inc = 1;

							    /*$sizes['fullwidth']= array(
                    									'label' => 'Full Width',
                    									'width' => '850',
                    									'height' => '500'

            										);*/

    							    foreach( $sizes as $value => $size ):
    							?>
    							    <label class="<?php echo $value."-size"; ?> <?php if( $inc++ == ( count( $sizes ) - 1 ) ) echo 'last-fixed-size'; ?>">
    							        <input type="radio" name="options[size]" value="<?php echo $value; ?>" class="fancy"<?php if( $slidedeck['options']['size'] == $value ) echo ' checked="checked"'; ?> />
    							        <?php echo $size['label']; ?>
    							        <?php if( in_array( $value,  array( "small", "medium", "large" ) ) ): ?><em><?php echo "{$size['width']}x{$size['height']}"; ?></em><?php endif; ?>
    							    </label>
    							<?php endforeach; ?>

                                <?php if( isset( $sizes['custom'] )  ) :?>
    							<span id="slidedeck-custom-dimensions"<?php if( $slidedeck['options']['size'] == "custom" ) echo ' class="selected"'; ?>>
                                        <label><input type="text" name="options[width]" value="<?php echo $slidedeck['options']['width']; ?>" size="5" /> px</label> x
    							    <label><input id="customHeight" class="sd-height" type="text" name="options[height]" value="<?php echo $slidedeck['options']['height']; ?>" size="5" /> px</label>
    							</span><?php endif; ?>
                                <?php if( isset( $sizes['fullwidth'] ) || isset( $sizes['box'] ) ) : ?>
                                    <span id="slidedeck-fullwidth-dimensions"<?php if( in_array( $slidedeck['options']['size'], array( "fullwidth", "box" ) ) ) echo ' class="selected"'; ?>>
                                        <label>Height: <input type="text" class="sd-height" name="options[height]" value="<?php echo $slidedeck['options']['height']; ?>" size="5" /> px</label>
                                    </span>
                                <?php endif; ?>
                            </li>
                            <li<?php if( $options_model['Setup']['total_slides']['type'] == "hidden" ) echo ' style="display:none;"'; ?>>
                                <?php slidedeck_html_input( "options[total_slides]", $slidedeck['options']['total_slides'], $options_model['Setup']['total_slides'] ); ?>
                            </li>
	                        <?php if($slidedeck['lens'] != 'pixel') : ?>
                            <li id="slidedeck-covers">
                            <?php else: ?>
                            <li id="slidedeck-covers" style="display:none;">
                            <?php endif; ?>

                                <span class="label"><?php _e( "Covers", $namespace ); ?> <span class="tooltip" title="<?php _e( "Covers let you add a title slide to your SlideDeck, and add a call-to-action to the last slide.", $namespace ); ?>"></span></span>
                                <span class="cover-option">
                                    <span class="cover-text"><?php _e( "Front Cover :", $namespace ); ?></span>
                                    <label for="options-show-front-cover-on" class="label">On
                                        <input type="radio" id="options-show-front-cover-on" name="options[show-front-cover]" class="fancy" value="1"<?php if( $slidedeck['options']['show-front-cover'] ) echo ' checked="checked"'; ?> />
                                    </label>
                                    <label for="options-show-front-cover-off" class="label">Off
                                        <input type="radio" id="options-show-front-cover-off" name="options[show-front-cover]" class="fancy" value=""<?php if( !$slidedeck['options']['show-front-cover'] ) echo ' checked="checked"'; ?> />
                                    </label>
                                </span>
                                <span class="cover-option">
                                    <span class="cover-text"><?php _e( "Back Cover :", $namespace ); ?></span>
                                    <label for="options-show-back-cover-on" class="label">On
                                        <input type="radio" id="options-show-back-cover-on" name="options[show-back-cover]" class="fancy" value="1"<?php if( $slidedeck['options']['show-back-cover'] ) echo ' checked="checked"'; ?> />
                                    </label>
                                    <label for="options-show-back-cover-off" class="label">Off
                                        <input type="radio" id="options-show-back-cover-off" name="options[show-back-cover]" class="fancy" value=""<?php if( !$slidedeck['options']['show-back-cover'] ) echo ' checked="checked"'; ?> />
                                    </label>
                                </span>
                                <span class="cover-option cover-option-edit">
                                    <a href="<?php echo admin_url( wp_nonce_url( 'admin-ajax.php?action=slidedeck_covers_modal&slidedeck=' . $slidedeck['id'], 'slidedeck-cover-modal' ) ); ?>" id="slidedeck-covers-modal-link" class="button"><?php _e( "Edit", $namespace ); ?></a>
                                </span>
                            </li>
                            <li>
                                <?php
                                    $overlay = $this->SlideDeck->options_model['Setup']['overlays'];
                                    $overlay['attr']['class'] = "fancy";
                                    slidedeck_html_input( 'options[overlays]', $slidedeck['options']['overlays'], $overlay );
                                ?>
                            </li>
                            <li>
                                <?php
                                    $overlay = $this->SlideDeck->options_model['Setup']['overlays_open'];
                                    $overlay['attr']['class'] = "fancy";
                                    slidedeck_html_input( 'options[overlays_open]', $slidedeck['options']['overlays_open'], $overlay );
                                ?>
                            </li>
			    <li>
                                <?php ?>
					<span class="label"><?php _e( "Select Overlays", $namespace ); ?> </span>
                                        <?php
                                        $overlay_enable;
					$overlay_options_key = array("facebook","twitter","googleplus","linkedin","pinterest");
					foreach($overlay_options_key as $key){
						if(isset($slidedeck['options']['overlay_'.$key]) && $slidedeck['options']['overlay_'.$key] == 1){
							$overlay_enable[$key] = 1;
						}
                                                else
						{
							$overlay_enable[$key] = 0;
						}
					}
?>
					<input type="checkbox" id="facebook" value='1' name="options[overlay_facebook]" <?php echo ($overlay_enable['facebook'] == '1') ? 'checked="checked"' : ''; ?> /><span><?php _e( "facebook", $namespace ); ?> </span>
					<input type="checkbox" id="twitter" value='1' name="options[overlay_twitter]" <?php echo ($overlay_enable['twitter'] == '1') ? 'checked="checked"' : ''; ?> /><span><?php _e( "Twitter", $namespace ); ?> </span>
					<input type="checkbox" id="googleplus" value='1' name="options[overlay_googleplus]" <?php echo ($overlay_enable['googleplus'] == '1') ? 'checked="checked"' : ''; ?> /><span><?php _e( "Google+", $namespace ); ?> </span>
					<input type="checkbox" id="linkedin" value='1' name="options[overlay_linkedin]" <?php echo ($overlay_enable['linkedin'] == '1') ? 'checked="checked"' : ''; ?> /><span><?php _e( "Linkedin", $namespace ); ?> </span>
					<input type="checkbox" id="pinterest" value='1' name="options[overlay_pinterest]" <?php echo ($overlay_enable['pinterest'] == '1') ? 'checked="checked"' : ''; ?> /><span><?php _e( "Pinterest", $namespace ); ?> </span>

				    	<?php
                                    //slidedeck_html_input( 'options[Select_overlays]', $slidedeck['options']['Select_overlays'], $overlay );
                                ?>
                            </li>
							<?php if( $slidedeck['lens'] !== 'prime' && $slidedeck['lens'] !== 'parfocal' ){ ?>
							<li>
                                <?php
                                    $auto_height = $this->SlideDeck->options_model['Setup']['auto_height'];
                                    $auto_height['attr']['class'] = "fancy";
                                    slidedeck_html_input( 'options[auto_height]', $slidedeck['options']['auto_height'], $auto_height );
                                ?>
                            </li>
							<?php } ?>
                            <li>
                                <?php
                                    $sd3_image_protection = $this->SlideDeck->options_model['Setup']['image_protection'];
                                   $sd3_image_protection['attr']['class'] = "fancy";
                                    slidedeck_html_input( 'options[image_protection]', $slidedeck['options']['image_protection'], $sd3_image_protection );
                                ?>
                            </li>

                            <?php do_action( "{$namespace}_setup_options_bottom", $slidedeck ); ?>

                        </ul>

                	</dd>

                    <?php
                    	$hidden_options = "";
                    	for( $i = 0; $i < count( $options_groups ); $i++ ):
                	?>

                        <?php
                    		$all_options_hidden = true;
                        	foreach( $options_model[$options_groups[$i]] as $name => $option ) {
                        		if( array_key_exists( 'type', $option ) ) {
                        			if( $option['type'] != 'hidden' )
    									$all_options_hidden = false;
                        		} else {
                        			foreach( $option as $sub_name => $sub_option ) {
    	                    			if( $sub_option['type'] != 'hidden' )
    										$all_options_hidden = false;
                        			}
                        		}
                        	}
    					?>

                        <?php if( !$all_options_hidden ): ?>
    	                    <dt><?php echo $options_groups[$i]; ?></dt>
    	                    <dd class="clearfix">

    	                        <ul class="options-list">
                    	<?php endif; ?>

                            <?php

                                foreach( $options_model[$options_groups[$i]] as $name => $option ) {
                                    $is_hidden = false;
									$is_visible = true;
                                    if( array_key_exists( 'type', $option ) ){
                                        if( $option['type'] == "hidden" )
                                            $is_hidden = true;
									}

									if( array_key_exists( 'visible', $option ) ){
										if( $option['visible'] == false )
                                            $is_visible = false;
									}

                                    $html = "";
                                                                        if(!isset($option["class"]))
         								{
										$option["class"] = "fancy";
									}
									if( $is_hidden !== true && $option["type"] != "button" && $option["class"] != "cimage-child" && $option["class"] != "cbutton-child"){
										$html .= $is_visible ? "<li>" : "<li style='display:none'>" ;
									}

								 if($slidedeck["options"]["cta-custom-opt"] === "cimage"){
									if( $is_hidden !== true && $option["type"] != "button" && isset($option['class']) && $option['class'] == "cimage-child" ){
										$html .= "<li class = 'cimage-parent'>";
									}
								        else if($is_hidden !== true && $option["type"] != "button" && isset($option['class']) && $option['class'] == "cbutton-child" ){
										$html .= "<li class = 'cbutton-parent' style = 'display:none;'>";
									}

								}
								else if($slidedeck["options"]["cta-custom-opt"] === "cbutton"){
									if($is_hidden !== true && $option["type"] != "button" && isset($option['class']) && $option['class'] == "cimage-child" ){
										$html .= "<li class = 'cimage-parent' style = 'display:none;'>";
									}
								        else if($is_hidden !== true && $option["type"] != "button" && isset($option['class']) && $option['class'] == "cbutton-child" ){
										$html .= "<li class = 'cbutton-parent' >";
									}

								}
    								$input_html = "";


				    if($option['type'] == "button" ){?>
					<?php if($slidedeck["options"]["cta-custom-opt"] === "cimage"){?>
						<li class = 'cimage-parent'><input type= "button" id= "<?php echo $option['id'];?>" class = "<?php echo $option['class'];?>" value = "<?php _e( $option['label'], $namespace ); ?>">
							<div id = "cta-preview" style="height:250px;">
								<?php  if(isset($slidedeck['options']['cta-custom-img-url']) && !empty($slidedeck['options']['cta-custom-img-url'])){ ?>
									<img src= "<?php echo $slidedeck['options']['cta-custom-img-url']; ?>" style="height:200px; width:200px;"/>
								<?php } ?>
							</div>
						</li>

						<?php }
                        else if($slidedeck["options"]["cta-custom-opt"] === "cbutton"){?>
							<li class = 'cimage-parent' style='display:none;' ><input type= "button" id= "<?php echo $option['id'];?>" class = "<?php echo $option['class'];?>" value = "<?php _e( $option['label'], $namespace ); ?>">
								<div id = "cta-preview"  style='height:auto' >
									<?php  if(isset($slidedeck['options']['cta-custom-img-url'])){ ?>
										<img src= "<?php echo $slidedeck['options']['cta-custom-img-url']; ?>" style="height:150px; width:150px;"/>
 								<?php } ?>
							</div>
						</li>
						<?php }?>

                               <?php wp_enqueue_media(); ?>
				     <?php }?>

					 <?php
					 		if($option['type'] == "bg_button" ){
								if($slidedeck["options"]["bg-custom-opt"] === "bgimage"){?>
									<li class = 'bgimage-parent'><input type= "button" id= "<?php echo $option['id'];?>" class = "<?php echo $option['class'];?>" value = "<?php _e( $option['label'], $namespace ); ?>">
										<div id = "bg-preview" style="height:100px;">
											<?php  if(isset($slidedeck['options']['bg-custom-img-url']) && !empty($slidedeck['options']['bg-custom-img-url'])){ ?>
                                                <?php if ( 'trifect' == $slidedeck['lens'] ) {?>
                                                    <span class='trifect-rimage' style="padding:3px 5px;border-color:rgb(216, 216, 216) rgb(209, 209, 209) rgb(186, 186, 186);border-radius:10%;border:1px solid;font-size:10px;">Remove Image</span><img  src= "<?php echo $slidedeck['options']['bg-custom-img-url']; ?>" style="height:50px; width:50px;padding:10px;"/>
                                                <?php }?>
                                                <?php if ( 'testimonial' == $slidedeck['lens'] ) { ?>
                                                    <span class='testimonial-rimage' style="padding:3px 5px;border-color:rgb(216, 216, 216) rgb(209, 209, 209) rgb(186, 186, 186);border-radius:10%;border:1px solid;font-size:10px;">Remove Image</span><img id="preview-image" src= "<?php echo $slidedeck['options']['bg-custom-img-url']; ?>" style="height:50px; width:50px;padding:10px;"/>
                                                <?php }?>
											<?php } ?>
										</div>
									</li>

									<?php }
								}
                                    if( array_key_exists( 'type', $option ) ) {
                                        if( !isset( $option['interface'] ) || empty( $option['interface'] ) ) {
                                            // Create attr property if it doesn't exist
                                            if( !isset( $option['attr'] ) ) $option['attr'] = array( 'class' => "" );
                                            // Create class attribute if it doesn't exist
                                            if( !isset( $option['attr']['class'] ) ) $option['attr']['class'] = "";
                                            $option['attr']['class'].= " fancy";
                                        }
                                        if(isset($slidedeck['options'][$name]))
                                            $input_html.= slidedeck_html_input( "options[$name]", $slidedeck['options'][$name], $option, false );
                                    } else {
                                        foreach( $option as $sub_name => $sub_option ) {
                                            if( !isset( $sub_option['interface'] ) || empty( $sub_option['interface'] ) ) {
                                                // Create attr property if it doesn't exist
                                                if( !isset( $sub_option['attr'] ) ) $sub_option['attr'] = array( 'class' => "" );
                                                // Create class attribute if it doesn't exist
                                                if( !isset( $sub_option['attr']['class'] ) ) $sub_option['attr']['class'] = "";
                                                $sub_option['attr']['class'].= " fancy";
                                            }
                                            $input_html.= slidedeck_html_input( 'options[' . $name . '][' . $sub_name . ']', $slidedeck['options'][$name][$sub_name], $sub_option, false );
                                        }
                                    }

    								if( array_key_exists( 'type', $option ) && $option['type'] == 'hidden' )
    									$hidden_options .= $input_html;
    								else
    									$html .= $input_html;

                                    if( $is_hidden !== true && $option["type"] != "button")
                                        $html .= "</li>";

                                	echo $html;
                                }
                            ?>

                        <?php if( !$all_options_hidden ): ?>
    	                        </ul>

    	                    </dd>
                        <?php endif; ?>

                    <?php endfor; ?>
                </dl>
            </dd>
        </dl>
        <?php echo $hidden_options; ?>
        <div id="slidedeck-options-groups-cap">
            <span class="left">&nbsp;</span>
            <span class="center">&nbsp;</span>
            <span class="right">&nbsp;</span>
        </div>
    </div>
    <?php do_action( "{$namespace}_options_group_wrapper_bottom", $slidedeck ); ?>
</div>
