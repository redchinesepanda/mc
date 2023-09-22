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

		$data = [
			'url_path' => $_SERVER[ 'HTTP_REFERER' ],

			'url_ref_click' => get_post_permalink( $post_id ),

			'date' => $current->format('Y-m-d H:i:s'),

			'user_ip' => $_SERVER[ 'HTTP_CF_CONNECTING_IP' ],

			'user_agent' => $_SERVER[ 'HTTP_USER_AGENT' ],
		];

		try
		{
			$result_insert = ToolPDO::insert( $data );

			$result_select = ToolPDO::select();

			LegalDebug::debug( [
				'function' => 'ToolStats::af_redirect',

				'result_insert' => $result_insert,

				'result_select' => $result_select,
			] );
		}
		catch ( \PDOException $e )
		{
			LegalDebug::debug( [
				'function' => 'ToolStats::af_redirect',
	
				'getMessage' => $e->getMessage(),
			] );
		}
	}
}

?>