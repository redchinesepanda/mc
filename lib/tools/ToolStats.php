<?php

class ToolStats
{
	public static function register()
	{
		$handler = new self();

		add_action( 'af_link_before_redirect', [ $handler, 'af_redirect' ], 10, 3 );
	}

	public static function check()
    {
        $permission_admin = !is_admin();

        $permission_not_logged_in = !is_user_logged_in();
        
        return $permission_admin && $permission_not_logged_in;
    }

	public static function af_redirect( $post_id, $target_url, $redirect_type )
	{
		// if ( self::check() )
		// {
		
		$current = new DateTime( 'now', new DateTimeZone( 'Europe/Moscow' ) );

		$url_path = 'direct';

		if ( !empty( $_SERVER[ 'HTTP_REFERER' ] ) )
		{
			$url_path = $_SERVER[ 'HTTP_REFERER' ];
		}

		$data = [
			'url_path' => $url_path,

			'url_ref_click' => get_post_permalink( $post_id ),

			'date' => $current->format('Y-m-d H:i:s'),

			'user_ip' => $_SERVER[ 'HTTP_CF_CONNECTING_IP' ],

			'user_agent' => $_SERVER[ 'HTTP_USER_AGENT' ],
		];

		try
		{
			$result_insert = ToolPDO::insert( $data );

			// $result_select = ToolPDO::select();

			// LegalDebug::debug( [
			// 	'function' => 'ToolStats::af_redirect',

			// 	// 'result_insert' => $result_insert,

			// 	'result_select' => $result_select,
			// ] );
		}
		catch ( \PDOException $e )
		{
			LegalDebug::debug( [
				'function' => 'ToolStats::af_redirect',
	
				'getMessage' => $e->getMessage(),
			] );
		}

		// LegalDebug::die( [
		// 	'function' => 'ToolStats::af_redirect',

		// 	'data' => $data,
		// ] );

		// }
	}
}

?>