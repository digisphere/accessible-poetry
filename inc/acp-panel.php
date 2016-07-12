<?php
class Accessible_Poetry {
	
    private $options;

    public function __construct() {
        
        // enqueue admin assets
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
        
        // register plugin settings page
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }
	
	// register plugin assets
	public function admin_assets($hook) {
		wp_enqueue_style( 'acp-admin-style', plugins_url('accessible-poetry/assets/css/acp-admin-style.css') );
	}
	
	// register plugin settings page
    public function add_plugin_page() {
	    add_menu_page(
		    'custom menu title',
			'Accessible Poetry',
			'manage_options',
			'accessible-poetry',
			array( $this, 'create_admin_page' ),
			'dashicons-yes',
			72
	    );
    }
	
	// create plugin settings page
    public function create_admin_page() {
		
		// get plugin options
        $this->options = get_option( 'accessible_poetry' );

?>
<div id="accessible-poetry-panel" class="wrap">
    <h1>Accessible Poetry</h1>
    <p>This plugin is provided by <a href="http://amitmoreno.com/">Amit Moreno</a> under GPL license. please feel free to:</p> 
    <a href="https://wordpress.org/support/view/plugin-reviews/accessible-poetry" target="_blank" class="page-title-action">Rate Us</a>
    <a href="https://www.facebook.com/WPAccessiblePoetry/" class="page-title-action" target="_blank">Join our community</a>
             
    <form method="post" action="options.php">
    <?php
        settings_fields( 'acp_group' );   
        do_settings_sections( 'accessible-poetry' );
        submit_button(); 
    ?>
    </form>
</div>
<p><?php _e('For support please visit the ', 'acp'); ?><a href="https://wordpress.org/support/plugin/accessible-poetry" target="_blank"><?php _e('plugin support forum', 'acp');?></a>. <?php _e('to contact the author email to', 'acp');?>: <a href="mailto:a@codenroll.co.il">a@codenroll.co.il</a>.</p>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#declaration").parent().parent().next().hide();
	
	$('#declaration').click(function() {
  		$("#declaration").parent().parent().next().fadeToggle(400);
	});
	if ($('#declaration:checked').val() !== undefined) {
		$("#declaration").parent().parent().next().show();
	}
	
	$("#contact").parent().parent().next().hide();
	
	$('#contact').click(function() {
  		$("#contact").parent().parent().next().fadeToggle(400);
	});
	if ($('#contact:checked').val() !== undefined) {
		$("#contact").parent().parent().next().show();
	}
});
</script>
        <?php
    }

    public function page_init() {        
        register_setting(
            'acp_group',
            'accessible_poetry',
            array( $this, 'sanitize' )
        );
		
		// sections
		
        add_settings_section(
            'acp_lauguage',
            __('Language', 'acp'),
            array( $this, 'html_lang_section_info' ),
            'accessible-poetry'
        );  
        
        add_settings_section(
            'acp_images',
            __('Images', 'acp'),
            array( $this, 'image_alt_section_info' ),
            'accessible-poetry'
        );
        
        add_settings_section(
            'acp_links',
            __('Links', 'acp'),
            array( $this, 'print_section_info' ),
            'accessible-poetry'
        );
        
        add_settings_section(
            'acp_titles',
            __('Titles', 'acp'),
            array( $this, 'acp_titles_section_info' ),
            'accessible-poetry'
        );
        
        add_settings_section(
            'acp_toolbar',
            __('Toolbar', 'acp'),
            array( $this, 'print_toolbar_info' ),
            'accessible-poetry'
        );
        
        add_settings_section(
            'acp_toolbar_additional',
            __('Toolbar Additional Buttons', 'acp'),
            array( $this, 'print_section_info' ),
            'accessible-poetry'
        );
        
        add_settings_section(
            'acp_fontsizer',
            __('Font Sizer', 'acp'),
            array( $this, 'print_section_info' ),
            'accessible-poetry'
        );
        
        add_settings_section(
            'acp_skiplinks',
            __('Skiplinks', 'acp'),
            array( $this, 'print_skiplinks_info' ),
            'accessible-poetry'
        );
		
		// fields
		
        add_settings_field(
            'html_lang',
            __('Add Language Attribute to the <html> tag', 'acp'),
            array( $this, 'html_lang_callback' ),
            'accessible-poetry',
            'acp_lauguage'           
        );      

        add_settings_field(
            'image_alt',
            __('Add empty Alt attribute to images without Alt', 'acp'),
            array( $this, 'image_alt_callback' ), 
            'accessible-poetry', 
            'acp_images'
        ); 
        
        add_settings_field(
            'aria_label',
            __('Replace all title attributes to aria-label on links', 'acp'),
            array( $this, 'aria_label_callback' ), 
            'accessible-poetry', 
            'acp_links'
        ); 
        
        add_settings_field(
            'link_underline',
            __('Add underline to all links', 'acp'),
            array( $this, 'link_underline_callback' ), 
            'accessible-poetry', 
            'acp_links'
        );
        
        add_settings_field(
            'link_outline',
            __('Add outline to all links & buttons', 'acp'),
            array( $this, 'link_outline_callback' ), 
            'accessible-poetry', 
            'acp_links'
        );
        
        add_settings_field(
            'low_titles',
            __('Replace all low title tags (h4, h5, h6) with h3 title tag', 'acp'),
            array( $this, 'low_titles_callback' ), 
            'accessible-poetry', 
            'acp_titles'
        );
        
        add_settings_field(
            'disable_toolbar',
            __('Check this if you\'re not using the toolbar', 'acp'),
            array( $this, 'disable_toolbar_callback' ), 
            'accessible-poetry', 
            'acp_toolbar'
        );
        add_settings_field(
            'disable_mobile_toolbar',
            __('Disable toolbar for mobile', 'acp'),
            array( $this, 'disable_mobile_toolbar_callback' ), 
            'accessible-poetry', 
            'acp_toolbar'
        );
        
        
        add_settings_field(
            'hide_fontsizer',
            __('Hide the buttons that change the font size', 'acp'),
            array( $this, 'hide_fontsizer_callback' ), 
            'accessible-poetry', 
            'acp_toolbar'
        );
        
        add_settings_field(
            'hide_contrast',
            __('Hide the buttons that change the contrast', 'acp'),
            array( $this, 'hide_contrast_callback' ), 
            'accessible-poetry', 
            'acp_toolbar'
        );
        
        add_settings_field(
            'hide_underline',
            __('Hide the button that add underline to links', 'acp'),
            array( $this, 'hide_underline_callback' ), 
            'accessible-poetry', 
            'acp_toolbar'
        );
        
        add_settings_field(
            'hide_linkmark',
            __('Hide the button that mark the links', 'acp'),
            array( $this, 'hide_linkmark_callback' ), 
            'accessible-poetry', 
            'acp_toolbar'
        );
        
        add_settings_field(
            'hide_readable',
            __('Hide the button that change the font to readable', 'acp'),
            array( $this, 'hide_readable_callback' ), 
            'accessible-poetry', 
            'acp_toolbar'
        );
        
        add_settings_field(
            'hide_animation',
            __('Hide the button that disable the animations', 'acp'),
            array( $this, 'hide_animation_callback' ), 
            'accessible-poetry', 
            'acp_toolbar'
        );
        
        add_settings_field(
            'declaration',
            __('Add Accessibility Declaration Button', 'acp'),
            array( $this, 'declaration_callback' ), 
            'accessible-poetry', 
            'acp_toolbar_additional'
        );
        add_settings_field(
            'declaration_link',
            __('Add the link for the Accessibility Declaration', 'acp'),
            array( $this, 'declaration_link_callback' ), 
            'accessible-poetry', 
            'acp_toolbar_additional'
        );
        
        add_settings_field(
            'contact',
            __('Add Contact Button', 'acp'),
            array( $this, 'contact_callback' ), 
            'accessible-poetry', 
            'acp_toolbar_additional'
        );
        
        add_settings_field(
            'contact_link',
            __('Add the link for the Contact Button', 'acp'),
            array( $this, 'contact_link_callback' ), 
            'accessible-poetry', 
            'acp_toolbar_additional'
        );
        
        add_settings_field(
            'skiplinks_activate',
            __('Activate skiplinks', 'acp'),
            array( $this, 'skiplinks_callback' ), 
            'accessible-poetry', 
            'acp_skiplinks'
        );
        
        add_settings_field(
            'skiplinks_home',
            __('Activate different skiplinks for home page', 'acp'),
            array( $this, 'skiplinks_home_callback' ), 
            'accessible-poetry', 
            'acp_skiplinks'
        );
        
        add_settings_field(
            'fontsizer_include',
            __('Include additional tags, classes & id\'s with the font-size changer (separate with a comma)', 'acp'),
            array( $this, 'fontsizer_include_callback' ), 
            'accessible-poetry', 
            'acp_fontsizer'
        );
        
        add_settings_field(
            'fontsizer_exclude',
            __('Exclude additional tags, classes & id\'s with the font-size changer (separate with a comma)', 'acp'),
            array( $this, 'fontsizer_exclude_callback' ), 
            'accessible-poetry', 
            'acp_fontsizer'
        );
            
    }

    public function sanitize( $input ) {
        $new_input = array();
        
        if( isset( $input['html_lang'] ) )
            $new_input['html_lang'] = absint( $input['html_lang'] );

        if( isset( $input['image_alt'] ) )
            $new_input['image_alt'] = absint( $input['image_alt'] );
            
        if( isset( $input['aria_label'] ) )
            $new_input['aria_label'] = sanitize_text_field( $input['aria_label'] );

        if( isset( $input['link_underline'] ) )
            $new_input['link_underline'] = absint( $input['link_underline'] );
            
        if( isset( $input['link_outline'] ) )
            $new_input['link_outline'] = sanitize_text_field( $input['link_outline'] );
            
        if( isset( $input['low_titles'] ) )
            $new_input['low_titles'] = absint( $input['low_titles'] );
            
        if( isset( $input['disable_toolbar'] ) )
            $new_input['disable_toolbar'] = absint( $input['disable_toolbar'] );
            
        if( isset( $input['disable_mobile_toolbar'] ) )
            $new_input['disable_mobile_toolbar'] = absint( $input['disable_mobile_toolbar'] );
            
        if( isset( $input['hide_fontsizer'] ) )
            $new_input['hide_fontsizer'] = absint( $input['hide_fontsizer'] );
            
        if( isset( $input['hide_contrast'] ) )
            $new_input['hide_contrast'] = absint( $input['hide_contrast'] );
            
        if( isset( $input['hide_underline'] ) )
            $new_input['hide_underline'] = absint( $input['hide_underline'] );
            
        if( isset( $input['hide_linkmark'] ) )
            $new_input['hide_linkmark'] = absint( $input['hide_linkmark'] );
            
        if( isset( $input['hide_readable'] ) )
            $new_input['hide_readable'] = absint( $input['hide_readable'] );
            
        if( isset( $input['hide_animation'] ) )
            $new_input['hide_animation'] = absint( $input['hide_animation'] );
            
        if( isset( $input['skiplinks_activate'] ) )
            $new_input['skiplinks_activate'] = absint( $input['skiplinks_activate'] );
            
        if( isset( $input['skiplinks_home'] ) )
            $new_input['skiplinks_home'] = absint( $input['skiplinks_home'] );
            
        if( isset( $input['declaration'] ) )
            $new_input['declaration'] = absint( $input['declaration'] );
            
        if( isset( $input['declaration_link'] ) )
           	$new_input['declaration_link'] = sanitize_text_field( $input['declaration_link'] );
            
        if( isset( $input['contact'] ) )
            $new_input['contact'] = absint( $input['contact'] );
            
        if( isset( $input['contact_link'] ) )
           	$new_input['contact_link'] = sanitize_text_field( $input['contact_link'] );
           	
        if( isset( $input['fontsizer_include'] ) )
           	$new_input['fontsizer_include'] = sanitize_text_field( $input['fontsizer_include'] );
           	
        if( isset( $input['fontsizer_exclude'] ) )
           	$new_input['fontsizer_exclude'] = sanitize_text_field( $input['fontsizer_exclude'] );


        return $new_input;
    }
    
    public function print_section_info(){}
	
	// language section
	
    public function html_lang_section_info() {
        print '<p class="acp-info">' . __('Adds language attribute the first html tag in the document with the current language code. before you activate this option you should check if your theme is already have those language attribute.', 'acp') . '</p>';
    }
    public function html_lang_callback() {
        printf(
            '<input type="checkbox" id="html_lang" name="accessible_poetry[html_lang]" value="1" ' . checked( '1', isset( $this->options['html_lang'] ), false ) . ' />',
            isset( $this->options['html_lang'] ) ? esc_attr( $this->options['html_lang']) : ''
        );
    }
    
    // images section
    
    public function image_alt_section_info() {
        print '<p class="acp-info">' . __('Very recommended! Adds empty ALT attribute to images with no ALT attribute.', 'acp') . '</p>';
    }
    public function image_alt_callback() {
        printf(
             '<input type="checkbox" id="image_alt" name="accessible_poetry[image_alt]" value="1" ' . checked( '1', isset( $this->options['image_alt'] ), false ) . ' />',
            isset( $this->options['image_alt'] ) ? esc_attr( $this->options['image_alt']) : ''
        );
    }
    
    // links section
    
    public function aria_label_callback() {
	    $none = ''; $instead = ''; $with = '';
	    if( isset($this->options['aria_label']) == 'none' ) {
		    $none = 'checked';	$instead = '';			$with = '';
	    }
	    elseif( isset($this->options['aria_label']) == 'instead' ) {
		    $none = '';			$instead = 'checked';	$with = '';
	    }
	    elseif( isset($this->options['aria_label']) == 'with' ) {
		    $none = '';			$instead = '';			$with = 'checked';
	    }
		
        printf(
            '<input type="radio" id="aria_label" name="accessible_poetry[aria_label]" value="none" ' . $none . ' />' . __('-- None --', 'acp') . '<br>' . '
             <input type="radio" id="aria_label" name="accessible_poetry[aria_label]" value="instead" ' . $instead . ' />' . __('Instead of the title attribute', 'acp') . '<br>' . '
             <input type="radio" id="aria_label" name="accessible_poetry[aria_label]" value="with" ' . $with . ' />' . __('With the title attribute', 'acp') . '<br>',
            isset( $this->options['aria_label'] ) ? esc_attr( $this->options['aria_label']) : ''
        );
    }
    public function link_underline_callback() {
        printf(
             '<input type="checkbox" id="link_underline" name="accessible_poetry[link_underline]" value="1" ' . checked( '1', isset( $this->options['link_underline'] ), false ) . ' />',
            isset( $this->options['link_underline'] ) ? esc_attr( $this->options['link_underline']) : ''
        );
    }
    public function link_outline_callback() {
	    $none = ''; $red = ''; $blue = '';
	    if( isset($this->options['link_outline']) == 'none' ) {
		    $none = 'checked';	$red = '';			$blue = '';
	    }
	    elseif( isset($this->options['link_outline']) == 'red' ) {
		    $none = '';			$red = 'checked';	$blue = '';
	    }
	    elseif( isset($this->options['link_outline']) == 'blue' ) {
		    $none = '';			$red = '';			$blue = 'checked';
	    }
		
        printf(
            '<input type="radio" id="link_outline" name="accessible_poetry[link_outline]" value="none" ' . $none . ' />' . __('-- None --', 'acp') . '<br>' . '
             <input type="radio" id="link_outline" name="accessible_poetry[link_outline]" value="red" ' . $red . ' />' . __('Red', 'acp') . '<br>' . '
             <input type="radio" id="link_outline" name="accessible_poetry[link_outline]" value="blue" ' . $blue . ' />' . __('Blue', 'acp') . '<br>',
            isset( $this->options['link_outline'] ) ? esc_attr( $this->options['link_outline']) : ''
        );
    }
    
    // title section
    
    public function acp_titles_section_info() {
	    print '<p class="acp-info">' . __('Use the option below only if you sure that the titles is not hierarchical.', 'acp') . '</p>';
    }
    public function low_titles_callback() {
        printf(
             '<input type="checkbox" id="low_titles" name="accessible_poetry[low_titles]" value="1" ' . checked( '1', isset( $this->options['low_titles'] ), false ) . ' />',
            isset( $this->options['low_titles'] ) ? esc_attr( $this->options['low_titles']) : ''
        );
    }
    
    // toolbar section
    
    public function print_toolbar_info() {
        print '<p class="acp-info">' . __('To display the toolbar add the next code right after the opening of the body tag in your header.php file: ', 'acp') . '<br><code>&lt;?php if(function_exists(\'acp_toolbar\') ) { acp_toolbar(); }?&gt;</code></p>';
    }
    public function disable_toolbar_callback() {
        printf(
             '<input type="checkbox" id="disable_toolbar" name="accessible_poetry[disable_toolbar]" value="1" ' . checked( '1', isset( $this->options['disable_toolbar'] ), false ) . ' />',
            isset( $this->options['disable_toolbar'] ) ? esc_attr( $this->options['disable_toolbar']) : ''
        );
    }
    public function disable_mobile_toolbar_callback() {
        printf(
             '<input type="checkbox" id="disable_mobile_toolbar" name="accessible_poetry[disable_mobile_toolbar]" value="1" ' . checked( '1', isset( $this->options['disable_mobile_toolbar'] ), false ) . ' />',
            isset( $this->options['disable_mobile_toolbar'] ) ? esc_attr( $this->options['disable_mobile_toolbar']) : ''
        );
    }
    
    public function hide_fontsizer_callback() {
        printf(
             '<input type="checkbox" id="hide_fontsizer" name="accessible_poetry[hide_fontsizer]" value="1" ' . checked( '1', isset( $this->options['hide_fontsizer'] ), false ) . ' />',
            isset( $this->options['hide_fontsizer'] ) ? esc_attr( $this->options['hide_fontsizer']) : ''
        );
    }
    
    public function hide_contrast_callback() {
        printf(
             '<input type="checkbox" id="hide_contrast" name="accessible_poetry[hide_contrast]" value="1" ' . checked( '1', isset( $this->options['hide_contrast'] ), false ) . ' />',
            isset( $this->options['hide_contrast'] ) ? esc_attr( $this->options['hide_contrast']) : ''
        );
    }
    
    public function hide_underline_callback() {
        printf(
             '<input type="checkbox" id="hide_underline" name="accessible_poetry[hide_underline]" value="1" ' . checked( '1', isset( $this->options['hide_underline'] ), false ) . ' />',
            isset( $this->options['hide_underline'] ) ? esc_attr( $this->options['hide_underline']) : ''
        );
    }
    
    public function hide_linkmark_callback() {
        printf(
             '<input type="checkbox" id="hide_linkmark" name="accessible_poetry[hide_linkmark]" value="1" ' . checked( '1', isset( $this->options['hide_linkmark'] ), false ) . ' />',
            isset( $this->options['hide_linkmark'] ) ? esc_attr( $this->options['hide_linkmark']) : ''
        );
    }
    
    public function hide_readable_callback() {
        printf(
             '<input type="checkbox" id="hide_readable" name="accessible_poetry[hide_readable]" value="1" ' . checked( '1', isset( $this->options['hide_readable'] ), false ) . ' />',
            isset( $this->options['hide_readable'] ) ? esc_attr( $this->options['hide_readable']) : ''
        );
    }
    public function hide_animation_callback() {
        printf(
             '<input type="checkbox" id="hide_animation" name="accessible_poetry[hide_animation]" value="1" ' . checked( '1', isset( $this->options['hide_animation'] ), false ) . ' />',
            isset( $this->options['hide_animation'] ) ? esc_attr( $this->options['hide_animation']) : ''
        );
    }
    
    public function declaration_callback() {
        printf(
             '<input type="checkbox" id="declaration" name="accessible_poetry[declaration]" value="1" ' . checked( '1', isset( $this->options['declaration'] ), false ) . ' />',
            isset( $this->options['declaration'] ) ? esc_attr( $this->options['declaration']) : ''
        );
    }
    
    public function declaration_link_callback() {
        printf(
             '<input type="text" id="declaration_link" name="accessible_poetry[declaration_link]" value="%s" />',
            isset( $this->options['declaration_link'] ) ? esc_attr( $this->options['declaration_link']) : ''
        );
    }
    
    public function contact_callback() {
        printf(
             '<input type="checkbox" id="contact" name="accessible_poetry[contact]" value="1" ' . checked( '1', isset( $this->options['contact'] ), false ) . ' />',
            isset( $this->options['contact'] ) ? esc_attr( $this->options['contact']) : ''
        );
    }
    
    public function contact_link_callback() {
        printf(
             '<input type="text" id="contact_link" name="accessible_poetry[contact_link]" value="%s" />',
            isset( $this->options['contact_link'] ) ? esc_attr( $this->options['contact_link']) : ''
        );
    }
    
    public function fontsizer_include_callback() {
	    printf(
             '<input type="text" id="fontsizer_include" name="accessible_poetry[fontsizer_include]" value="%s" />',
            isset( $this->options['fontsizer_include'] ) ? esc_attr( $this->options['fontsizer_include']) : ''
        );
    }
    
    public function fontsizer_exclude_callback() {
	    printf(
             '<input type="text" id="fontsizer_exclude" name="accessible_poetry[fontsizer_exclude]" value="%s" />',
            isset( $this->options['fontsizer_exclude'] ) ? esc_attr( $this->options['fontsizer_exclude']) : ''
        );
    }
    
    // skiplinks section
    
    public function print_skiplinks_info() {
        print '<p class="acp-info">' . __('To display the skiplinks first activate it via the option below, this will add a new menu to your WP menus. after the menu created add your skiplinks anchors to it, and finally display the new skiplinks menu by adding the next code right after the opening of the body tag (the skiplinks is visible only with keyboard navigation): ', 'acp') . '<br><code>&lt;?php if(function_exists(\'acp_skiplinks\') ) { acp_skiplinks(); }?&gt;</code></p>';
    }
    
    public function skiplinks_callback() {
        printf(
             '<input type="checkbox" id="skiplinks_activate" name="accessible_poetry[skiplinks_activate]" value="1" ' . checked( '1', isset( $this->options['skiplinks_activate'] ), false ) . ' />',
            isset( $this->options['skiplinks_activate'] ) ? esc_attr( $this->options['skiplinks_activate']) : ''
        );
    }
    public function skiplinks_home_callback() {
        printf(
             '<input type="checkbox" id="skiplinks_home" name="accessible_poetry[skiplinks_home]" value="1" ' . checked( '1', isset( $this->options['skiplinks_home'] ), false ) . ' />',
            isset( $this->options['skiplinks_home'] ) ? esc_attr( $this->options['skiplinks_home']) : ''
        );
    }
    
}

if( is_admin() )
    $accessible_poetry = new Accessible_Poetry();