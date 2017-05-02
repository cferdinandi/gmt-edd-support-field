<?php

/**
 * Plugin Name: GMT EDD Support Field
 * Plugin URI: https://github.com/cferdinandi/gmt-edd-support-field/
 * GitHub Plugin URI: https://github.com/cferdinandi/gmt-edd-support-field/
 * Description: Adds a custom field if a specific download is in the cart.
 * Version: 1.0.0
 * Author: Chris Ferdinandi
 * Author URI: http://gomakethings.com
 * Text Domain: edd_support
 * License: GPLv3
 */


// Define constants
define( 'GMT_EDD_SUPPORT_FIELD_VERSION', '1.0.0' );


// Includes
require_once( plugin_dir_path( __FILE__ ) . 'includes/settings.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/field.php' );


/**
 * Check the plugin version and make updates if needed
 */
function gmt_edd_support_field_check_version() {

	// Get plugin data
	$old_version = get_site_option( 'gmt_edd_support_field_version' );

	// Update plugin to current version number
	if ( empty( $old_version ) || version_compare( $old_version, GMT_EDD_SUPPORT_FIELD_VERSION, '<' ) ) {
		update_site_option( 'gmt_support_field_version', GMT_EDD_SUPPORT_FIELD_VERSION );
	}

}
add_action( 'plugins_loaded', 'gmt_edd_support_field_check_version' );