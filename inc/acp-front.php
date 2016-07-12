<?php
/**
 * Load the plugin front assets
**/
function acp_front_assets() {
    wp_enqueue_style( 'acp-toolbar', plugins_url('accessible-poetry/assets/css/acp-toolbar.css') , false, false );
    wp_enqueue_script( 'acp-scripts', plugins_url( 'accessible-poetry/assets/js/accessible-poetry.js' ), array('jquery'), false, false );
}
add_action( 'wp_enqueue_scripts', 'acp_front_assets' );

/**
 * Accessible Poetry front class
**/
class Accessible_Poetry_Front {
	
	private $options;
	
	public function __construct() {
		
		$this->options = get_option( 'accessible_poetry' );
				
		if( isset($this->options['html_lang']) )
			add_filter( 'wp_footer', array( $this, 'html_lang' ) );
		
		if( isset($this->options['low_titles']) )
			add_filter( 'wp_footer', array( $this, 'low_titles' ) );
			
		if( isset($this->options['titles_tabindex']) )
			add_filter( 'wp_footer', array( $this, 'titles_tabindex' ) );
		
		if( isset($this->options['aria_label']) )
			add_filter( 'wp_footer', array( $this, 'aria_label' ) );
			
		if( isset($this->options['image_alt']) )
			add_filter( 'wp_footer', array( $this, 'image_alt' ) );
			
		if( isset($this->options['link_underline']) ) {
			add_filter( 'body_class', function ( $classes ) {
				$classes[] = 'acp-underline';
				return $classes;
			} );
		}
		if( isset($this->options['link_outline']) ) {
			if( $this->options['link_outline'] && $this->options['link_outline'] != 'none' ) {
				add_filter( 'body_class', function ( $classes ) {
					$classes[] = 'acp-focus-' . $this->options['link_outline'];
					return $classes;
				} );
			}
		}
		
		
		
	}
	
	public function html_lang() {
		$curLang = substr(get_bloginfo( 'language' ), 0, 2);
		?><script>jQuery(window).load(function(){jQuery("html").attr("lang","<?php echo $curLang; ?>")});</script><?php
	}
	
	public function low_titles() {
		?><script>jQuery(document).ready(function($){var replacementTag = 'h3';$('h4,h5,h6').each(function(){var outer = this.outerHTML;var regex = new RegExp('<' + this.tagName, 'i');var newTag = outer.replace(regex, '<' + replacementTag);regex = new RegExp('</' + this.tagName, 'i');newTag = newTag.replace(regex, '</' + replacementTag);$(this).replaceWith(newTag);});});</script><?php
	}
	
	public function titles_tabindex() {
		?><script>jQuery(document).ready(function($){$('h1,h2,h3,h4,h5,h6').each(function(){if(!$(this).attr("tabindex")) $(this).attr("tabindex","0");});});</script><?php
	}
	
	public function aria_label() {
		?><script>jQuery(document).ready(function(t){t("a[title]").each(function(){var e=t(this);e.attr("aria-label",e.attr("title")).removeAttr("title")})});</script><?php
	}
	
	public function image_alt() {
		?><script>jQuery(document).ready(function($){$("img").each(function(){if(!$(this).attr("alt")){$(this).attr("alt", "");}});});</script><?php
	}
}
$acp_front = new Accessible_Poetry_Front();
