<?php
/**
 * SlideDeck Add Lens Page
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

<div class="wrap">
    <div class="icon32" id="icon-update-slidedeck2"><br></div><h2>Install an addon in .zip format</h2>
    
    <p class="install-help">If you have an addon in a .zip format, you may install it by uploading it here.</p>
    
    <form action="<?php echo admin_url( 'update.php?action=upload-slidedeck-addon' ); ?>" method="post" enctype="multipart/form-data">
        <?php wp_nonce_field( "{$namespace}-upload-addon" ); ?>
        <input type="file" name="slidedeckaddonzip" />
        <input type="submit" value="Install Now" class="button" />
    </form>
</div>
