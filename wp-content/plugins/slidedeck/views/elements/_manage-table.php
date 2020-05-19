<?php 
/**
 * SlideDeck Manage Table
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
<?php if( !empty( $slidedecks ) ): ?>
<div class="inner">
    <ul>
    <?php foreach( (array) $slidedecks as $slidedeck ): ?>
        <li class="slidedeck-row<?php if( $slidedeck == end( $slidedecks ) ) echo ' last '; ?>">
            <?php if( in_array( 'custom', $slidedeck['source'] ) ): ?>
                <img src="<?php slidedeck_source_icon_url( "custom" ); ?>" alt="" class="icon" />
            <?php else: ?>
                <?php if( count($slidedeck['source']) > 1 ): ?>
                	<div class="multisource-icon">
                    	<?php $count = 0; foreach( $slidedeck['source'] as $source ): ?>
                        	<?php if( $count < 4 ): ?>
                            	<img src="<?php slidedeck_source_chicklet_url( $source ); ?>" alt="" class="chicklet" />
                        	<?php endif; ?>
                    	<?php $count++; endforeach; ?>
                	</div>
                <?php else: ?>
                    <img src="<?php slidedeck_source_icon_url( $slidedeck['source'][0] ); ?>" alt="" class="icon" />
                <?php endif; ?>
            <?php endif; ?>
            
            <a href="<?php echo slidedeck_action( "&action=edit&slidedeck={$slidedeck['id']}" ); ?>" data-slider-name="<?php echo $slidedeck['title']; ?>" class="slidedeck-title">
                <?php echo $slidedeck['title']; ?>
                <span class="slidedeck-modified">Modified <?php echo date( "m-d-Y", strtotime( $slidedeck['updated_at'] ) + ( get_option( 'gmt_offset' ) * 3600 ) ); ?></span>
                <?php if( in_array( 'twitter', $slidedeck['source'] ) ): ?>
                <span class="deprecated-warning">(contains deprecated source)</span>
                <?php endif; ?>
            </a>
            <div class="slidedeck-actions">
                <div class="slidedeck-delete tooltip" title="<?php _e( "Delete", $namespace ); ?>">
                    <form action="" method="post" class="delete-slidedeck">
                        <?php wp_nonce_field( "{$namespace}-delete-slidedeck" ); ?>
                        <input type="hidden" name="slidedeck" value="<?php echo $slidedeck['id']; ?>" />
                        <input type="submit" value="Delete" class="delete-slidedeck" />
                    </form>
                </div>
                <div class="slidedeck-duplicate tooltip" title="<?php _e( "Duplicate", $namespace ); ?>">
                    <form action="" method="post" class="duplicate-slidedeck">
                        <?php wp_nonce_field( "{$namespace}-duplicate-slidedeck" ); ?>
                        <input type="hidden" name="slidedeck" value="<?php echo $slidedeck['id']; ?>" />
                        <input type="submit" value="Duplicate" class="duplicate-slidedeck" />
                    </form>
                </div>
                <div class="slidedeck-preview tooltip" title="<?php _e( "Preview", $namespace ); ?>">
                    <a class="slidedeck-preview-link" onclick="return false;" href="<?php echo $this->get_iframe_url( $slidedeck['id'] ); ?>" data-for="slidedeck-preview-<?php echo $slidedeck['id']; ?>">Preview</a>
                </div>
                <div class="slidedeck-getcode tooltip" title="<?php _e( "Use This SlideDeck", $namespace ); ?>">
                    <a class="slidedeck-getcode-link" onclick="return false;" href="<?php echo admin_url( "admin-ajax.php?action={$namespace}_getcode_dialog&slidedeck={$slidedeck['id']}" ); ?>">Get Code</a>
                </div>
                <span class="slidedeck-id">id: <?php echo $slidedeck['id']; ?></span>
            </div>
        </li>
        <div class="slidedeck-preview-wrapper">
            <iframe src="" frameborder="0" id="slidedeck-preview-<?php echo $slidedeck['id']; ?>"></iframe>
        </div>
    <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<?php if( isset( $_REQUEST['slidedeck-search'] ) && '' != $_REQUEST['slidedeck-search'] ) { ?>
    <div id="no-decks-placeholder"<?php echo ( !empty( $slidedecks ) ) ? ' style="display:none;"' : ''; ?>>
        <h1>Getting Started</h1>
        <div class="feature-section clearfix">
            <div class="content feature-section-item">
                <h3>STEP 1: Create a new slidedeck</h3>
                <p>Now that you've installed and activated SlideDeck, let's get started with creating your first slidedeck. You have two options. You can either choose to create the slider using lenses and dynamic sources, or a template. Go ahead and choose from above.</p>
            </div>
            <div class="content feature-section-item last-feature">
                <img src="<?php echo SLIDEDECK_URLPATH; ?>/images/step-1.png">
            </div>
        </div>
        <div class="feature-section clearfix">
            <div class="content feature-section-item multi-level-gif">
                <img src="<?php echo SLIDEDECK_URLPATH; ?>/images/step-2.png">
            </div>
            <div class="content feature-section-item last-feature">
                <h3>STEP 2: Choose slidedeck type</h3>
                <p>You can choose whether you want to create an image or a video slider. Accordingly, you'll need to upload the content and related additional information.</p>
            </div>
        </div>
        <div class="feature-section clearfix">
            <div class="content feature-section-item add-content">
                <h3>STEP 3: Add additional content</h3>
                <p>Once you've decided what type of slider you want to create, go ahead and choose the content you want to display. Upload images/videos, add a title, description, and other necessary information.</p>
            </div>
            <div class="content feature-section-item last-feature">
                <img src="<?php echo SLIDEDECK_URLPATH; ?>/images/step-3.png">
            </div>
        </div>
        <div class="feature-section clearfix">
            <div class="content feature-section-item display-options">
                <img src="<?php echo SLIDEDECK_URLPATH; ?>/images/step-4.png">
            </div>
            <div class="content feature-section-item last-feature">
                <h3>STEP 4: Customize your slidedeck</h3>
                <p>This is the best part. You can configure your SlideDeck using the tons of customization options available. Changing the lenses, and type of button to changing the body font, there’s a lot that you can do. You can change the look and feel of the slider in just few clicks.</p>
            </div>
        </div>
        <!--
        <h4><?php _e( "Currently, you have", $namespace ); ?></h4>
        <div id="zero-slidedecks-created"><img src="<?php echo SLIDEDECK_URLPATH; ?>/images/zero-slidedecks-created.png" alt="<?php _e( "Zero SlideDecks Created", $namespace ); ?>" /></div>
        <h4 class="sources prompt"><?php _e( "With ", $namespace ); echo '"'. $_REQUEST['slidedeck-search'] .'"'; _e( " name.", $namespace ); ?></h4>
        -->
    </div>
<?php }else { ?>
<div id="no-decks-placeholder"<?php echo ( !empty( $slidedecks ) ) ? ' style="display:none;"' : ''; ?>>
    <h1>Getting Started</h1>
    <div class="feature-section clearfix">
        <div class="content feature-section-item">
            <h3>STEP 1: Create a new slidedeck</h3>
            <p>Now that you've installed and activated SlideDeck, let's get started with creating your first slidedeck. You have two options. You can either choose to create the slider using lenses and dynamic sources, or a template. Go ahead and choose from above.</p>
        </div>
        <div class="content feature-section-item last-feature">
            <img src="<?php echo SLIDEDECK_URLPATH; ?>/images/step-1.png">
        </div>
    </div>
    <div class="feature-section clearfix">
        <div class="content feature-section-item multi-level-gif">
            <img src="<?php echo SLIDEDECK_URLPATH; ?>/images/step-2.png">
        </div>
        <div class="content feature-section-item last-feature">
            <h3>STEP 2: Choose slidedeck type</h3>
            <p>You can choose whether you want to create an image or a video slider. Accordingly, you'll need to upload the content and related additional information.</p>
        </div>
    </div>
    <div class="feature-section clearfix">
        <div class="content feature-section-item add-content">
            <h3>STEP 3: Add additional content</h3>
            <p>Once you've decided what type of slider you want to create, go ahead and choose the content you want to display. Upload images/videos, add a title, description, and other necessary information.</p>
        </div>
        <div class="content feature-section-item last-feature">
            <img src="<?php echo SLIDEDECK_URLPATH; ?>/images/step-3.png">
        </div>
    </div>
    <div class="feature-section clearfix">
        <div class="content feature-section-item display-options">
            <img src="<?php echo SLIDEDECK_URLPATH; ?>/images/step-4.png">
        </div>
        <div class="content feature-section-item last-feature">
            <h3>STEP 4: Customize your slidedeck</h3>
            <p>This is the best part. You can configure your SlideDeck using the tons of customization options available. Changing the lenses, and type of button to changing the body font, there’s a lot that you can do. You can change the look and feel of the slider in just few clicks.</p>
        </div>
    </div>
    <!-- <h4><?php _e( "Currently, you have", $namespace ); ?></h4>
    <div id="zero-slidedecks-created"><img src="<?php echo SLIDEDECK_URLPATH; ?>/images/zero-slidedecks-created.png" alt="<?php _e( "Zero SlideDecks Created", $namespace ); ?>" /></div>
    <h4 class="sources prompt"><?php _e( "Let's fix that. Click the create button above and choose a content source to start.", $namespace ); ?></h4>
    -->
</div>
<?php } ?>