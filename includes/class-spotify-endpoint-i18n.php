<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://localhost
 * @since      1.0.0
 *
 * @package    Spotify_Endpoint
 * @subpackage Spotify_Endpoint/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Spotify_Endpoint
 * @subpackage Spotify_Endpoint/includes
 * @author     Pievi <asd@asdsad.com>
 */
class Spotify_Endpoint_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'spotify-endpoint',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
