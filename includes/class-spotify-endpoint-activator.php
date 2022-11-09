<?php

/**
 * Fired during plugin activation
 *
 * @link       https://localhost
 * @since      1.0.0
 *
 * @package    Spotify_Endpoint
 * @subpackage Spotify_Endpoint/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Spotify_Endpoint
 * @subpackage Spotify_Endpoint/includes
 * @author     Pievi <asd@asdsad.com>
 */
class Spotify_Endpoint_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$create_table_query = "
			CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}spotify_settings` (
				`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				`k` text NOT NULL,
				`v` text NOT NULL
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
		";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $create_table_query );

		$data = "
			INSERT INTO `{$wpdb->prefix}spotify_settings` (`k`, `v`)
			VALUES ('refreshToken', '1');
		";

		dbDelta( $data );

		
		$data = "
			INSERT INTO `{$wpdb->prefix}spotify_settings` (`k`, `v`)
			VALUES ('accessToken', '1');
		";

		dbDelta( $data );
	}

}
