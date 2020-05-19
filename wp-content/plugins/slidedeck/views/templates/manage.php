<?php
/**
 * SlideDeck Administrative Options
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
<div class="" id="slidedeck_lens_management">

    <div class="slidedeck-header">
        <h1>SlideDeck Templates</h1>
            <a class="button" href="<?php echo slidedeck_action( '/templates&action=add' ); ?>">Upload Template</a>
        <a title="Help" href="https://docs.slidedeck.com/template-management?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link#installing-templates" target="_blank" class="help-icon" >
            <span class=""></span>
        </a>
    </div>

    <div id="slidedeck-lenses-wrapper">
        <!--<img src="<?php echo SLIDEDECK_URLPATH; ?>/images/slidedeck-coming-soon.png" width="928" height="300" />-->

			<div id="slidedeck-templates" class="lenses clearfix">

				<?php foreach ( $templates as &$template ): ?>

					<?php include( SLIDEDECK_DIRNAME . '/views/elements/_template.php' ); ?>

				<?php endforeach; ?>
                                <?php do_action( "{$this->namespace}_manage_templates_after_templates", $templates ); ?>
			</div>

    </div>

</div>
