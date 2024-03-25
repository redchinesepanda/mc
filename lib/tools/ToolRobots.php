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

	public static function check_not_restricted()
	{
		return !ToolNotFound::check_domain();
	}

	public static function mc_robots_txt()
	{
		$robots = self::ROBOTS_DISALLOW_ALL;

		$sitemap = [];

		if ( self::check_not_restricted() )
		{
			$robots = self::ROBOTS;

			$sitemap = [
				'',
	
				// 'Sitemap: ' . $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER[ 'HTTP_HOST' ] . '/sitemap_index.xml',
				
				'Sitemap: ' . $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER[ 'HTTP_HOST' ] . '/wp-sitemap.xml',
			];
		}

		echo implode( "\n", array_merge( $robots, $sitemap ) );

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

		'Disallow: /football/',

		'Disallow: /*?swcfpc=1',

		'',

		'Allow: /odds/en/football/',

		'Allow: /wp-admin/admin-ajax.php',

		'',
	];
	const ROBOTS_DISALLOW_ALL = [
		'User-agent: *',

		'Disallow: /',
	];
}

?>