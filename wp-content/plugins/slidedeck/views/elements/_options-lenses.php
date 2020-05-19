<?php do_action( "{$this->namespace}_lens_selection_before_lenses", $lenses, $slidedeck ); ?>

<?php foreach( $lenses as &$lens ): ?>
    <label class="lens<?php if( $lens['slug'] == $slidedeck['lens'] ) echo ' selected'; ?>">
        <span class="thumbnail"><img src="<?php echo $lens['thumbnail']; ?>" alt="<?php echo $lens['meta']['name']; ?>" /></span>
        <span class="shadow">&nbsp;</span>
        <span class="title"><?php echo $lens['meta']['name']; ?><a style="text-decoration:none;cursor:pointer;" title="Help" href="https://docs.slidedeck.com/?utm_source=sd5_documentation&utm_campaign=sd5_lite&utm_medium=link<?php echo $lens['slug'];?>" target="_blank" class="help-icon">
                <span class=""></span>
            </a></span>

        <input type="radio" name="lens" value="<?php echo $lens['slug']; ?>"<?php if( $lens['slug'] == $slidedeck['lens'] ) echo ' checked="checked"'; ?> />
    </label >
<?php endforeach; ?>

<?php // do_action( "{$this->namespace}_lens_selection_after_lenses", $lenses, $slidedeck ); ?>

<input type="hidden" name="_wpnonce_update_available_lenses" value="<?php echo wp_create_nonce( 'slidedeck-update-available-lenses' ); ?>" />
