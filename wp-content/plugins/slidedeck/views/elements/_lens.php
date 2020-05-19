<?php
/**
 * SlideDeck Lens Management Page Lens Entry
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
<div class="lens">

    <div class="inner">
	    <?php if( !$lens['is_protected'] && $can_edit_lenses ): ?>
	        <a href="<?php echo slidedeck_action( "/lenses&action=edit&slidedeck-lens={$lens['slug']}" ); ?>" class="thumbnail">
	    <?php else: ?>
	        <span class="thumbnail">
	    <?php endif; ?>

	        <span class="thumbnail-inner" style="background-image:url(<?php echo $lens['thumbnail-large']; ?>);"></span>

	    <?php if( !$lens['is_protected'] && $can_edit_lenses ): ?>
	        </a>
	    <?php else: ?>
	        </span>
	    <?php endif; ?>

	    <h4><?php echo $lens['meta']['name']; ?>
            <a title="Help" href="https://docs.slidedeck.com/lens-management?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link#<?php echo $lens['slug']; ?>" target="_blank" class="help-icon" >
                <span class=""></span>
            </a>
        </h4>
	    <!--
	    <p class="author">
	    	<?php echo get_avatar( $lens['meta']['author'], 15 ); ?>
	        <?php if( !empty( $lens['meta']['author_uri'] ) ): ?>
	            <a href="<?php echo $lens['meta']['author_uri']; ?>" target="_blank">
	        <?php endif; ?>
	        <?php echo $lens['meta']['author']; ?>
	        <?php if( !empty( $lens['meta']['author_uri'] ) ): ?>
	            </a>
	        <?php endif; ?>
	    </p>
	    -->
	    <div class="content-sources"><strong>Content Source(s):</strong>
	    	<?php foreach( $lens['meta']['sources'] as $source ): ?>
	    		<?php if( $source == 'twitter' ) { continue; } ?>
	    	    <?php if( isset( $sources[$source] ) ): ?>
                    <img src="<?php echo slidedeck_source_chicklet_url( $source ); ?>" class="source" alt="<?php echo $sources[$source]->label; ?>" />
	    		<?php endif; ?>
			<?php endforeach; ?>
	    </div>
	    <p class="variations"><strong>Variations:</strong>
	    <?php if( !empty( $lens['meta']['variations'] ) ): ?>

	            <?php
	                $sep = "";
	                foreach( $lens['meta']['variations'] as $variation ):
	            ?>
	                <?php
	                    echo $sep . '<span class="variation">' . ucwords( str_replace( "-", " ", $variation ) ) . '</span>';
	                    $sep = ", ";
	                ?>
	            <?php endforeach; ?>
	        </p>
	    <?php else:
            echo __( 'None', $this->namespace );
            endif; ?>
        <!--
                <a title="Help" href="https://www.slidedeck.com/documentation/?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link#<?php echo $lens['slug']; ?>" target="_blank" class="help-icon" >
                        <span class=""></span>
                    </a>
        -->
    </div>

    <div class="actions<?php if( $is_writable->valid !== true ) echo ' disabled' ?>">
        <form action="" method="post">
            <?php do_action( "{$namespace}_lens_manage_entry_actions", $lens, $is_writable ); ?>

            <?php if( !$lens['is_protected'] ): ?>

            	<?php wp_nonce_field( "{$namespace}-delete-lens" ); ?>
            	<input type="hidden" name="lens" value="<?php echo $lens['slug']; ?>" />
            	<input type="submit" value="<?php _e( 'Delete', $namespace ); ?>" class="delete-lens" />

            <?php endif; ?>
        </form>
    </div>

</div>
