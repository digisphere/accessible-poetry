<?php

// Register Skiplinks Navigations
function acp_register_skiplinks_menu() {
	
	$options = get_option( 'accessible_poetry' );
	
	register_nav_menu( 'skiplinks', __( 'Skiplinks', 'acp' ) );
	if( isset($options['skiplinks_home']) ) {
		register_nav_menu( 'skiplinks-home', __( 'Homepage Skiplinks', 'acp' ) );
	}
}

// Skiplinks output
function acp_skiplinks() {
	
	$options = get_option( 'accessible_poetry' );
		
	if( isset($options['skiplinks_home']) ) {
		if( $options['skiplinks_home'] == 1 )
			$menu_name = ( is_home() || is_front_page() )  ? 'skiplinks-home' : 'skiplinks';
	}
	else {
		$menu_name = 'skiplinks';
	}

    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		$menu_list = '<nav><ul id="acp_skiplinks" role="navigation">';

		foreach ( (array) $menu_items as $key => $menu_item ) {
	    	$title = $menu_item->title;
			$url = $menu_item->url;
			$menu_list .= '<li><a href="' . $url . '" class="skiplinks">' . $title . '</a></li>';
		}
		$menu_list .= '</ul></nav>';
    }
    if( isset($options['skiplinks_activate']) ) {
    	echo $menu_list;
    }
}

// skiplinks essets
function acp_skiplinks_assets() {
	wp_register_style( 'skiplinks', plugins_url( 'accessible-poetry/assets/css/acp-skiplinks.css' ) );
	wp_enqueue_style( 'skiplinks' );
	wp_enqueue_script( 'skiplinks-js', plugins_url( 'accessible-poetry/inc/js/skiplinks.js' ), array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'acp_skiplinks_assets' );
add_action( 'after_setup_theme', 'acp_register_skiplinks_menu' );
