<?php

// Exit if this file is accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Name:       Simple Shipping Labels for WooCommerce
 * Description:       This plugin adds a column of buttons in WooCommerce orders page, to generate a single or bulk of shipping labels for printing.
 * Version:           1.0.7
 * Tested up to:      6.4.3
 * WC tested up to:   8.5.2
 * Author:            Dima Pavlenko
 * Author URI:        https://dimapavlenko.com
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */


/**
 *** How this plugin works and what it does:
 * 1) The plugin has an OOP structure so it's easier to maintain (no stupid prefixing to prevent name clashing).
 * 2) Adds a settings page to the WooCommerce submenu in WordPress admin dashboard.
 * 2) Adds a column of buttons in WooCommerce orders page.
 * 3) Clicking a button makes an AJAX call to the plugin registered AJAX function generate_shipping_labels_page_html()
 *    to generate the shipping labels php page. Then JavaScript creates new browser tab and sets its content to the response.
 *    The user can then edit the generated labels and print the page.
 */

// This plugin is for site administrators only, so we load the plugin only in admin mode.
if ( is_admin() ) {
    
    // Load plugin class code.
    require_once __DIR__ . '/admin/admin.php';
    
    // Declare this extension is compatibility with WooCommerce HPOS ("High Performance Order Storage").
    // See more info in the plugin release notes in: readme.txt > Changelog > 1.0.7
    add_action( 'before_woocommerce_init', function() {
        if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
        }
    } );

    // Create plugin class instance.
    // Provide the plugin basename to the constructor for adding plugin actions to the plugins page table (like a link to the plugin Settings page).
    $simpleShippingLabels = new dimap_SimpleShippingLabels( plugin_basename(__FILE__) );
}