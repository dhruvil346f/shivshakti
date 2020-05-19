<div class="backbutton">
    <p><a href="<?php echo slidedeck_action(); ?>" id="back-to-manage"><?php _e( "Back to Manage Screen", '' ); ?></a></p>
<div id="create-dynamic-slidedeck" class="create-slidedeck">

  <div class="slidedeck-inner">
	    <h4>Dynamic Source<a style="text-decoration:none;cursor:pointer;" title="Help" href="https://docs.slidedeck.com/content-sources?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link#dynamic-content-type" target="_blank" class="help-icon">
                <span class=""></span>
            </a></h4>
	    <p>Create a slider that updates automatically with your favorite sources.</p>
	    <p><a href="<?php echo admin_url( "admin-ajax.php?action=slidedeck_source_modal&_wpnonce_source_modal=" ) . wp_create_nonce( 'slidedeck-source-modal' ); ?>" class="button create-button slidedeck-source-modal" onclick="return false;"><span><?php _e( "Create SlideDeck", $this->namespace ) ?></span></a></p>
	</div>

</div>

