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
	    
	    
	        <span class="thumbnail-inner" style="background-image:url(<?php echo $source['thumbnail-large']; ?>);"></span>
	        
	    
	        </span>
	    
	    
	    <h4><?php echo $source['meta']['name']; ?>
            <a title="Help" href="https://docs.slidedeck.com/source-management?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link" target="_blank" class="help-icon" >
                <span class=""></span>
            </a>
        </h4>
	    <p><?php echo $source['meta']['description']; ?></p>
	    <p class="variations">&nbsp;</p>
            <p>&nbsp;</p>

             
    </div>
    
    <div class="actions">
        <form action="" method="post">
            
                
            <?php if( !$source['is_protected'] ): ?>
            
            	<?php wp_nonce_field( "{$namespace}-delete-sources" ); ?>
            	<input type="hidden" name="lens" value="<?php echo $source['slug']; ?>" />
            	<input type="submit" value="<?php _e( 'Delete', $namespace ); ?>" class="delete-lens" />
            
            <?php endif; ?>
        </form>
    </div>
           
</div>