<?php

class ReviewGoogle
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'getGoogleDoc' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'getGoogleDoc' ], 11, 4 );
	}

	const META_FIELD = [
		'content' => 'google_post_content',
	];

	public static function getGoogleDoc( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( self::META_FIELD[ 'content' ] == $meta_key )
		{
			$content = getUrl( 'https://docs.google.com/document/pub?id=' . $meta_value );
		
			// $start = strpos( $content,'<div id="contents">' );
	
			// $end = strpos( $content,'<div id="footer">' );	
		
			// $content = substr( $content, $start, ( $end - $start ) );
	
			// $content = str_replace( 'src="', 'src="https://docs.google.com/document/', $content );

			LegalDebug::die( [
				'function' => 'ReviewGoogle::getGoogleDoc',

				'content' => $content,
			] );
		}
	}
}

?>