<?php

class Spotify_Endpoint_Api {

	private $client_id = SPOTIFY_CLIENT_ID;
	private $client_secure = SPOTIFY_CLIENT_SECURE;

	private $table = 'wp_spotify_settings';
	protected $session;
	protected $api;

	public function api_routes() {
		register_rest_route('spotify/v1', 'cron', [
			'methods'  => 'GET',
			'callback' => [ $this, 'cron']
		]);

		register_rest_route('spotify/v1', 'code', [
			'methods'  => 'GET',
			'callback' => [ $this, 'code']
		]);

		register_rest_route('spotify/v1', 'auth', [
			'methods'  => 'GET',
			'callback' => [ $this, 'auth']
		]);

		register_rest_route('spotify/v1', 'search', [
			'methods'  => 'GET',
			'callback' => [ $this, 'search']
		]);

		register_rest_route('spotify/v1', 'add', [
			'methods'  => 'GET',
			'callback' => [ $this, 'add']
		]);
	}

	private function init_session() {
		 $client_auth_url = get_rest_url() . 'spotify/v1/code';

		$this->session = new SpotifyWebAPI\Session(
			$this->client_id,
			$this->client_secure,
			$client_auth_url
		);
	}

	private function init_api() {
		$this->api = new SpotifyWebAPI\SpotifyWebAPI();
	}

	private function selectRefreshToken() {
		global $wpdb;
		return $wpdb->get_var ( "SELECT v FROM $this->table WHERE k='refreshToken'" );
	}
	
	private function selectAccessToken() {
		global $wpdb;
		return $wpdb->get_var ( "SELECT v FROM $this->table WHERE k='accessToken'" );
	}

	private function updateRefreshToken( $token ) {
		global $wpdb;
		return $wpdb->update($this->table, array('v'=>$token), array('k'=>'refreshToken'));
	}
	
	private function updateAccessToken( $token ) {
		global $wpdb;
		return $wpdb->update($this->table, array('v'=>$token), array('k'=>'accessToken'));
	}

	public function cron()
	{
		$this->init_session();

		$t = $this->selectRefreshToken();
		$this->session->refreshAccessToken($t);
		
		wp_reset_postdata();
	 
		return [
			$this->updateAccessToken( $this->session->getAccessToken() ),
    		$this->updateRefreshToken( $this->session->getRefreshToken() )
		];
	}

	public function code($data) {

		$this->init_session();
		$this->init_api();

		$code = $data->get_param( 'code' );

		$this->session->requestAccessToken($code);
		$this->api->setAccessToken($this->session->getAccessToken());

		$this->updateAccessToken( $this->session->getAccessToken() );
		$this->updateRefreshToken( $this->session->getRefreshToken() );

		wp_reset_postdata();

		return [
			$code,
			$this->api->me(),
			$this->session->getAccessToken(),
			$this->session->getRefreshToken(),
		];
	}

	public function auth() {
		$this->init_session();

		$options = [
			'scope' => [
				'user-read-email',
				'user-modify-playback-state',
			],
		];
	
		header('Location: ' . $this->session->getAuthorizeUrl($options));
	}

	public function search($data) {
		$value = $data->get_param( 'value' );

		$token = $this->selectAccessToken();

		$args = [
			'headers'     => [
				'Authorization' => 'Bearer ' . $token,
				'Accept'        => 'application/json',
			],
		];

		$response = wp_remote_get( 'https://api.spotify.com/v1/search?q=' . $value . '&type=track', $args );

		$body     = wp_remote_retrieve_body( $response );

		wp_reset_postdata();

		return json_decode($body);
	}

	public function add($data) {
		$uri = $data->get_param( 'uri' );
		
		$token = $this->selectAccessToken();
		
		$args = [
			'headers'     => [
				'Authorization' => 'Bearer ' . $token,
				'Accept'        => 'application/json',
			],
		];
		
		$response = wp_remote_post( 'https://api.spotify.com/v1/me/player/queue?uri=' . $uri, $args );
		
		$body     = wp_remote_retrieve_body( $response );
		
		wp_reset_postdata();
		
		return ['response' => json_decode($body)];
	}

}