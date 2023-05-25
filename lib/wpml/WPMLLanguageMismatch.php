<?php

class WPMLLanguageMismatch
{
	public static function register()
	{
		$handler = new self();

		add_filter( 'permalink_manager_detected_post_id', [ $handler, 'fix_language_mismatch' ], 9, 3 );
	}

	function fix_language_mismatch( $item_id, $uri_parts, $is_term = false )
	{
		$exceptions = [
			'sportsbet',
			// 'bonos',
		];

		foreach ( $exceptions as $exception ) {
			if ( strpos( $exception, $uri_parts[ 'uri' ] ) !== false ) {
				return 0;
			}

		}

		return $item_id;
	}
}


?>