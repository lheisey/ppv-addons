<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/lheisey/ppv-addons/
 * @since             1.0.0
 * @package           Ppv_Addons
 *
 * @wordpress-plugin
 * Plugin Name:       Picturesque Photo Views Addons
 * Plugin URI:        https://github.com/lheisey/ppv-addons/
 * Description:       Provides shortcodes and other functions for use in your WordPress theme.
 * Version:           2.3.5
 * Author:            Loren Heisey
 * Author URI:        https://github.com/lheisey/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ppv-addons
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PPV_ADDONS_VERSION', '2.3.5' );

/**
 * Setup plugin constants.
 * Relative to plugin root directory.
 */
// Plugin Folder Path.
if ( ! defined( 'PPV_ADDONS_PLUGIN_DIR' ) ) {
    define( 'PPV_ADDONS_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}
// Plugin Folder URL.
if ( ! defined( 'PPV_ADDONS_PLUGIN_URL' ) ) {
    define( 'PPV_ADDONS_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
}
// Plugin Root File.
if ( ! defined( 'PPV_ADDONS_PLUGIN_FILE' ) ) {
    define( 'PPV_ADDONS_PLUGIN_FILE', trailingslashit( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ppv-addons-activator.php
 */
function activate_ppv_addons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ppv-addons-activator.php';
	Ppv_Addons_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ppv-addons-deactivator.php
 */
function deactivate_ppv_addons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ppv-addons-deactivator.php';
	Ppv_Addons_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ppv_addons' );
register_deactivation_hook( __FILE__, 'deactivate_ppv_addons' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ppv-addons.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ppv_addons() {

	$plugin = new Ppv_Addons();
	$plugin->run();

}
run_ppv_addons();
