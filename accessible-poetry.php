<?php
/**
 * Plugin Name: Accessible Poetry
 * Plugin URI: http://www.amitmoreno.com/acp/
 * Description: Enriches your WordPress with better accessibility options, such as nicely Skiplinks, Font-Sizer, Constrast changer, Custom Toolbar & and many other options.
 * Version: 2.0.2
 * Author: Amit Moreno
 * Author URI: http://www.amitmoreno.com/
 * Text Domain: acp
 * Domain Path: /lang
 * License: GPL2
 */

// Include the admin panel
require_once('inc/acp-panel.php');

// Include the Toolbar
require_once('inc/acp-toolbar.php');

// Include the missing alt's panel
require_once('inc/acp_imagealt.php');

// Include the skiplinks
require_once('inc/acp_skiplinks.php');

// include front class
require_once 'inc/acp-front.php';

/**
 * Load the plugin localization files
**/
function acp_localization() {
   load_plugin_textdomain( 'acp', false, plugin_basename( dirname( __FILE__ ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'acp_localization' );