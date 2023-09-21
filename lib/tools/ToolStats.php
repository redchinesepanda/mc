<?php

class ToolStats
{
	public static function register()
	{
		$handler = new self();

		add_action( 'af_link_before_redirect', [ $handler, 'af_redirect' ], 10, 3 );
	}

	public static function af_redirect( $post_id, $target_url, $redirect_type )
	{
		$url_path = get_post_permalink( $post_id );

		$url_ref_click = get_field( self::FIELD[ 'bonus-affilate-primary' ], $post_id );

		LegalDebug::die( [
			'function' => 'ToolStats::af_redirect',

			'post_id' => $post_id,

			'url_path' => $url_path,

			'url_ref_click' => $url_ref_click,

			'target_url' => $target_url,

			'redirect_type' => $redirect_type,
		] );
	}

	const SETTINGS = [
		'host' => '',

		'port' => '',

		'dbname' => 'mc_analytics',

		'user' => '',

		'password' => '',
	];

	const TABLES = [
		'stats' => 'ref_clicks',
	];

	const STATS =  [
		// SERIAL PRIMARY KEY
		// 'id' => 0,

		// text
		'url_path' => '/',

		// text
		'url_ref_click' => '/',

		// timestamp
		'date' => 0,

		// inet
		'user_ip' => '0.0.0.0',

		// text
		'user_agent' => '-',
	];

	public static function get_connection()
	{
		$connection_string = http_build_query( self::SETTINGS, '', ' ' );

		$flags = PGSQL_CONNECT_ASYNC;

		return pg_connect( $connection_string, $flags );
	}

	public static function insert( $values = [] )
	{
		$connection = self::get_connection();

		if ( empty( $connection ) )
		{
			LegalDebug::die( [
				'function' => 'ToolStats::insert',

				'pg_last_error' => pg_last_error( $connection ),
			] );
		}

		$values = shortcode_atts( self::STATS, $values );

		if ( !empty( $values ) )
		{
			$result = pg_insert( $connection, self::TABLES[ 'stats' ], $values, PGSQL_DML_ESCAPE );
	
			if ( !$result ) {
				LegalDebug::die( [
					'function' => 'ToolStats::insert',

					'pg_last_error' => pg_last_error( $connection ),
				] );
			}
		}
	}
}

?>