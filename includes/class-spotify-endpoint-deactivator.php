<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://localhost
 * @since      1.0.0
 *
 * @package    Spotify_Endpoint
 * @subpackage Spotify_Endpoint/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Spotify_Endpoint
 * @subpackage Spotify_Endpoint/includes
 * @author     Pievi <asd@asdsad.com>
 */
class Spotify_Endpoint_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		
		$wpdb->query( "DROP TABLE IF EXISTS `{$wpdb->prefix}spotify_settings`" );
	}

}
