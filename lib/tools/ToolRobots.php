<?php

class ToolRobots
{
	public static function register()
	{
		$handler = new self();

		add_action( 'do_robotstxt', [ $handler, 'mc_robots_txt' ] );

		// add_action( 'robots_txt', [ $handler, 'mc_robots_txt_append' ], 10, 2 );
	}

	public static function mc_robots_txt_append( $output )
	{
		LegalDebug::debug( [
			'ToolRobots' => 'mc_robots_txt_append',

			'$output' => $output,
		] );

		// $str = '
		// Disallow: /cgi-bin             # Стандартная папка на хостинге.
		// Disallow: /?                   # Все параметры запроса на главной.
		// Disallow: *?s=                 # Поиск.
		// Disallow: *&s=                 # Поиск.
		// Disallow: /search              # Поиск.
		// Disallow: /author/             # Архив автора.
		// Disallow: */embed              # Все встраивания.
		// Disallow: */page/              # Все виды пагинации.
		// Disallow: */xmlrpc.php         # Файл WordPress API
		// Disallow: *utm*=               # Ссылки с utm-метками
		// Disallow: *openstat=           # Ссылки с метками openstat
		// ';
	
		// $str = trim( $str );
		// $str = preg_replace( '/^[\t ]+(?!#)/mU', '', $str );
		// $output .= "$str\n";
	
		// return $output;
		
		return '';
	}

	public static function mc_robots_txt()
	{
		$sitemap = [
			'',

			// 'Sitemap: ' . $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER[ 'HTTP_HOST' ] . '/sitemap_index.xml',
			
			'Sitemap: ' . $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER[ 'HTTP_HOST' ] . '/wp-sitemap.xml',
		];

		echo implode( "\n", array_merge( self::ROBOTS, $sitemap ) );

		die();
	}

	const ROBOTS = [
		'User-agent: AhrefsSiteAudit',

		'Allow: /',

		'',

		'User-agent: AhrefsBot',

		'Allow: /',

		'',

		'User-agent: dotbot',

		'Disallow: /',

		'',

		'User-Agent: trendictionbot',

		'Disallow: /',

		'',

		'User-agent: SemrushBot',

		'Disallow: /',

		'',

		'User-agent: SemrushBot-SA',

		'Disallow: /',

		'',

		'User-agent: MJ12bot',

		'Disallow: /',

		'',

		'User-agent: *',

		'Disallow: /wp-admin/',

		'Disallow: /wp-includes/',

		'Disallow: /wp-json/',

		'',

		'Allow: /wp-admin/admin-ajax.php',
	];
}

?>