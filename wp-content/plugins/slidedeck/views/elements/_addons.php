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
		<span class="thumbnail">
			<span class="thumbnail-inner" style="background-image:url(<?php echo $addon['thumbnail-large']; ?>);"></span>
		</span>
		<h4><?php echo $addon['meta']['name']; ?>
            <a title="Help" href="https://docs.slidedeck.com/add-ons-management?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link" target="_blank" class="help-icon" >
                <span class=""></span>
            </a>
        </h4>
                <p class="variations">&nbsp;</p>
                <p class="variations">&nbsp;</p>
                <p class="variations">&nbsp;</p>
            <p>&nbsp;</p>
        <!--
            <a title="Help" href="https://www.slidedeck.com/documentation/?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link#add-ons-management" target="_blank" class="help-icon" >
                        <span class=""></span>
                    </a>
                    -->
                <!--
		<p class="author">
			<?php echo get_avatar( $addon['meta']['author'], 15 ); ?>
			<?php if ( !empty( $addon['meta']['author_uri'] ) ): ?>
				<a href="<?php echo $addon['meta']['author_uri']; ?>" target="_blank">
				<?php endif; ?>
				<?php echo $addon['meta']['author']; ?>
				<?php if ( !empty( $addon['meta']['author_uri'] ) ): ?>
				</a>
			<?php endif; ?>
		</p>
                -->
    </div>

    <div class="actions">
        <form action="" method="post">
            <?php
            $addon_slug = ""; $is_addon_activated = false;
            if( "slidedeck_scheduler" == $addon['slug'] ) {
                $addon_slug = "scheduler";
                $is_addon_activated = get_option( "slidedeck_addon_activate", false );
            } else {
                $addon_slug = str_replace( "-", "_", $addon['slug'] );
                $is_addon_activated = get_option( "slidedeck_" . $addon_slug . "_addon_activate", false );
            }
			
			if ( $is_addon_activated ) {
				?>
				<a href="<?php echo slidedeck_action( "/addons&action=deactivate&slidedeck-addon=". $addon_slug ); ?>" class="deactivate-addon">Deactivate</a>
			<?php
			} else { ?>
				<a href="<?php echo slidedeck_action( "/addons&action=activate&slidedeck-addon=". $addon_slug ); ?>" class="deactivate-addon">Activate</a>
			<?php }
			?>
				<?php wp_nonce_field( "{$namespace}-delete-addon" ); ?>
				<input type="hidden" name="lens" value="<?php echo $addon['slug']; ?>" />
				<input type="submit" value="<?php _e( 'Delete', $namespace ); ?>" class="delete-lens" />
        </form>
    </div>

</div>