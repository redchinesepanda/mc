<?php

class WPMLLanguageMismatch
{
	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'permalink_manager_detected_post_id', [ $handler, 'fix_language_mismatch' ], 9, 3 );

		// LegalDebug::debug( [
		// 	'WPMLLanguageMismatch' => 'register_functions',
		// ] );
	}

	public static function register()
	{
		// $handler = new self();

		// add_filter( 'permalink_manager_detected_post_id', [ $handler, 'fix_language_mismatch' ], 9, 3 );

		// LegalDebug::debug( [
		// 	'WPMLLanguageMismatch' => 'register',
		// ] );
	}

	public static function fix_language_mismatch( $item_id, $uri_parts, $is_term = false )
	{
		LegalDebug::debug( [
			'WPMLLanguageMismatch' => 'fix_language_mismatch',

			'item_id' => $item_id,

            'uri_parts' => $uri_parts,

            'is_term' => $is_term,
		] );

		if ( !empty( $uri_parts[ 'uri' ] ) )
		{
			if ( $uri_parts[ 'uri' ] != 'sitemap' )
			{
				// return 0;

				return $item_id;
			}
		}

		$post = get_post( $item_id );

		if ( $post )
		{
			$url = get_post_permalink( $post->ID );

			LegalDebug::debug( [
				'WPMLLanguageMismatch' => 'fix_language_mismatch',
	
				'url' => $url,
			] );
		}

		// return $item_id;

		return 0;
	}

	// {
	// 	$exceptions = [
	// 		'ke' => [
	// 			'world-sports-betting',

	// 			'hollywoodbets',
	// 		],

	// 		'mx' => [
	// 			'bonos',
	// 		],

	// 		'ro' => [
	// 			'sportsbet',

	// 			'hollywoodbets',
	
	// 			'world-sports-betting',

	// 			'888sport',
	// 		],
	// 	];

	// 	foreach ( $exceptions as $lang => $items )
	// 	{
	// 		if ( !empty( $uri_parts[ 'lang' ] ) )
	// 		{
	// 			if ( strpos( $lang, $uri_parts[ 'lang' ] ) !== false )
	// 			{
	// 				foreach ( $items as $item )
	// 				{
	// 					if ( strpos( $item, $uri_parts[ 'uri' ] ) !== false )
	// 					{
	// 						return 0;
	// 					}
	// 				}
	// 			}
	// 		}
			
	// 	}

	// 	return $item_id;
	// }
}


?>