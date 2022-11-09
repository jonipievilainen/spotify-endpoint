<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://localhost
 * @since             1.0.0
 * @package           Spotify_Endpoint
 *
 * @wordpress-plugin
 * Plugin Name:       Spotify Endpoint
 * Plugin URI:        https://localhost
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Pievi
 * Author URI:        https://localhost
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       spotify-endpoint
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SPOTIFY_ENDPOINT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-spotify-endpoint-activator.php
 */
function activate_spotify_endpoint() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spotify-endpoint-activator.php';
	Spotify_Endpoint_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-spotify-endpoint-deactivator.php
 */
function deactivate_spotify_endpoint() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spotify-endpoint-deactivator.php';
	Spotify_Endpoint_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_spotify_endpoint' );
register_deactivation_hook( __FILE__, 'deactivate_spotify_endpoint' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-spotify-endpoint.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_spotify_endpoint() {

	$plugin = new Spotify_Endpoint();
	$plugin->run();

}
run_spotify_endpoint();
