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

	public static function getUrl($url, $expires = 5)
	{
		$cache_file = __DIR__ . '/cache/' . preg_replace('~\W+~', '-', $url) . '.txt';

		if( ! is_dir(__DIR__ . '/cache') AND ! mkdir(__DIR__ . '/cache')) {
			die('Please create /cache directory');
		}

		if (file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * $expires ))) {
			return file_get_contents($cache_file);
		}

		/*
		$options = array(
			'http'=>array(
				'method'=> "GET",
				'header'=>
						"Accept-language: en\r\nUser-Agent: Just A Simple Request-er :)\r\n" // i.e. An iPad 
						/*
						//"Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
						"User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad 
						*
			)
		);
		$file = file_get_contents($url, false, stream_context_create($options));
		*/
		$file = file_get_contents($url);

		// Our cache is out-of-date, so load the data from our remote server,
		// and also save it over our cache for next time.
		$file = file_get_contents($url);
		file_put_contents($cache_file, $file, LOCK_EX);
		return $file;
	}

	public static function getGoogleDoc( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( self::META_FIELD[ 'content' ] == $meta_key )
		{
			// $content = getUrl( 'https://docs.google.com/document/pub?id=' . $meta_value );

			$content = file_get_contents( $meta_key );
		
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