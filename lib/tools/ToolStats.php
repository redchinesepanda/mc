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
		$current = new DateTime();

		$values = [
			'url_path' => $_SERVER[ 'HTTP_REFERER' ],

			'url_ref_click' => get_post_permalink( $post_id ),

			'date' => $current->format('Y-m-d H:i:s'),

			'user_ip' => $_SERVER[ 'HTTP_CF_CONNECTING_IP' ],

			'user_agent' => $_SERVER[ 'HTTP_USER_AGENT' ],
		];

		try
		{
			$pdo = ToolPDO::get();

			LegalDebug::die( [
				'function' => 'ToolStats::af_redirect',

				'pdo' => $pdo,
	
				'message' => 'A connection to the PostgreSQL database sever has been established successfully.',
			] );
		}
		catch ( \PDOException $e )
		{
			LegalDebug::die( [
				'function' => 'ToolStats::af_redirect',
	
				'getMessage' => $e->getMessage(),
			] );
		}

		LegalDebug::die( [
			'function' => 'ToolStats::af_redirect',

			'values' => $values,
		] );
	}

	const SETTINGS = [
		'host' => '46.101.248.55',

		'port' => '5432',

		'dbname' => 'mc_analytics',

		'user' => 'match_center',

		'password' => 'qak7qda6ZPG_hmr!veh',
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

				'message' => 'connection errors',
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

	public static function select()
	{
		$connection = self::get_connection();

		if ( empty( $connection ) )
		{
			LegalDebug::die( [
				'function' => 'ToolStats::select',

				'message' => 'connection errors',
			] );
		}
		
		$result = pg_select( $connection, self::TABLES[ 'stats' ], [], PG_DML_ESCAPE);
	
		if ( !$result ) {
			LegalDebug::die( [
				'function' => 'ToolStats::insert',

				'pg_last_error' => pg_last_error( $connection ),
			] );
		}

		LegalDebug::die( [
			'function' => 'ToolStats::insert',

			'result' => $result,
		] );
	}
}

?>