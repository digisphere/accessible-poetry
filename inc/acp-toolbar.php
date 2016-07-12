<?php
function acp_get_toolbar() {
	$options = get_option( 'accessible_poetry' );
?>
<nav id="acp-toolbar-wrap" data-fontsizer-include="<?php echo $options['fontsizer_include']; ?>" data-fontsizer-exclude="<?php echo $options['fontsizer_exclude']; ?>">
	<button id="acp-toggle-toolbar" aria-label="<?php _e('Toggle accessibility toolbar', 'acp');?>"><i class="material-icons md-32">accessibility</i></button>
	<div id="acp-toolbar">
		<button id="acp-toolbar-close" aria-label="<?php _e('Close the accessibility toolbar', 'acp'); ?>"><i class="material-icons">highlight_off</i></button>
		<h3 id="acp-toolbar-title"><?php _e('Accessibilily Toolbar', 'acp'); ?></h3>
		<?php
			// Font size
			if( isset($options['hide_fontsizer']) != 1 ) :
		?>
		<label class="acp-toolbar-label"><?php _e('Font Size', 'acp');?></label>
		<div id="acp-toolbar-textsize" class="acp-toolbar-btn-group">
			<button id="acp-text-down" class="acp-toolbar-btn"><span><i class="material-icons">zoom_out</i></span><?php _e('Decrease font size', 'acp'); ?></button>
			<button id="acp-text-up" class="acp-toolbar-btn"><span><i class="material-icons">zoom_in</i></span><?php _e('Increase font size', 'acp'); ?></button>
			<button id="acp-text-reset" class="acp-toolbar-btn acp-btn-reset"><span><i class="material-icons">autorenew</i></span><?php _e('Back to original', 'acp'); ?></button>
		</div>
		<?php endif; ?>
		<?php
			// Contrast
			if( isset($options['hide_contrast']) != 1 ) :
		?>
		<label class="acp-toolbar-label"><?php _e('Color contrast', 'acp');?></label>
		<div id="acp-toolbar-contrast" class="acp-toolbar-btn-group">
			<button id="acp-contrast-dark" class="acp-toolbar-btn"><span><i class="material-icons">brightness_low</i></span><?php _e('Dark contrast', 'acp'); ?></button>
			<button id="acp-contrast-bright" class="acp-toolbar-btn"><span><i class="material-icons">brightness_high</i></span><?php _e('Bright contrast', 'acp'); ?></button>
			<button id="acp-contrast-reset" class="acp-toolbar-btn acp-btn-reset"><span><i class="material-icons">autorenew</i></span><?php _e('Back to original', 'acp'); ?></button>
		</div>
		<?php endif; ?>
		<?php 
			// links
			if( isset($options['hide_underline']) != 1 || isset($options['hide_linkmark']) != 1 ) :
		?>
		<label class="acp-toolbar-label"><?php _e('Links', 'acp');?></label>
		<div id="acp-toolbar-links" class="acp-toolbar-btn-group">
			<?php if( isset($options['hide_underline']) != 1 ) : ?>
			<button id="acp-links-marklinks" class="acp-toolbar-btn"><span><i class="material-icons">format_paint</i></span><?php _e('Highlight Links', 'acp'); ?></button>
			<?php endif; ?>
			<?php if( isset($options['hide_linkmark']) != 1 ) : ?>
			<button id="acp-links-underline" class="acp-toolbar-btn"><span><i class="material-icons">format_underlined</i></span><?php _e('Links Underline', 'acp'); ?></button>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<?php 
			// fonts
			if( isset($options['hide_readable']) != 1 ) :
		?>
		<label class="acp-toolbar-label"><?php _e('Fonts', 'acp');?></label>
		<div id="acp-toolbar-font" class="acp-toolbar-btn-group">
			<button id="acp-font-readable" class="acp-toolbar-btn"><span><i class="material-icons">text_format</i></span><?php _e('Readable Font', 'acp'); ?></button>
		</div>
		<?php endif; ?>
		
		<?php 
			// animation
			if( isset($options['hide_animation']) != 1 ) :
		?>
		<label class="acp-toolbar-label"><?php _e('Animations', 'acp');?></label>
		<div id="acp-toolbar-animation" class="acp-toolbar-btn-group">
			<button id="acp-animation" class="acp-toolbar-btn"><span><i class="material-icons">local_movies</i></span><?php _e('Disable Animations', 'acp'); ?></button>
		</div>
		<?php endif; ?>
		
		<?php 
			// extra buttons
			if( $options['contact'] == 1 || $options['declaration'] == 1 ) :
		?>
		<div id="acp-toolbar-extra">
			<?php if( isset($options['declaration']) == 1 && $options['declaration_link'] != '' ) : ?>
			<a href="<?php echo $options['declaration_link']; ?>"><span><i class="material-icons">accessibility</i></span><?php _e('Accessibility Declaration', 'acp'); ?></a>
			<?php endif; ?>
			<?php if( $options['contact'] == 1 && $options['contact_link'] != '' ) : ?>
			<a href="<?php echo $options['contact_link']; ?>"><span><i class="material-icons">mail_outline</i></span><?php _e('Contact Us', 'acp');?></a>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="acp-author">
			<a href="http://www.amitmoreno.com/" aria-label="Go to the accessibility plugin author website - this link will open in a new window" target="_blank">Accessibe Poetry by Amit Moreno</a>
		</div>
	</div>
</nav>
<?php
}

function acp_toolbar() {
	
	$options = get_option( 'accessible_poetry' );
	
	if( isset($options['disable_mobile_toolbar']) ) {
		if( !wp_is_mobile() )
			acp_get_toolbar();
	}
	else {
		acp_get_toolbar();
	}
}

function acp_toolbar_assets() {
	wp_enqueue_script( 'acp-toolbar', plugins_url('accessible-poetry/assets/js/acp-toolbar.js' ), array( 'jquery', 'acp-scripts' ) );
}
add_action( 'wp_enqueue_scripts', 'acp_toolbar_assets' );

