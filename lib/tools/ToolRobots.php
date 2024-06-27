<?php

class ToolRobots
{
	public static function check_robots_txt()
	{
		return is_robots();
	}

	public static function register()
	{
		$handler = new self();

		add_action( 'do_robotstxt', [ $handler, 'mc_robots_txt' ], 10, 2 );
	}

	public static function get_scheme()
	{
		return $_SERVER[ 'REQUEST_SCHEME' ];
	}

	public static function get_host()
	{
		return $_SERVER[ 'HTTP_HOST' ];
	}

	public static function get_url()
	{
		return self::get_scheme(). '://'. self::get_host();
	}

	// public static function check_not_restricted()
	// {
	// 	return !ToolRestricted::check_domain();
	// }
	
	public static function check_robots_full()
	{
		return LegalHosts::check_host_production();
	}

	public static function get_sitemaps()
	{
		if ( MiltisiteMain::check_multisite() )
		{
			if ( MultisiteBlog::check_not_main_domain() )
			{
				$current_domain = MultisiteBlog::get_domain();

				$sites = MultisiteBlog::get_all_sites( $current_domain );

				$sitemaps = [];

				foreach ( $sites as $site )
				{
					MultisiteBlog::set_blog( $site->blog_id );

					$sitemaps[] = get_sitemap_url( 'index' );
				}

				MultisiteBlog::restore_blog();

				LegalDebug::debug( [
					'ToolRobots' => 'get_sitemaps',

					'current_domain' => $current_domain,

					'sites' => $sites,

					'sitemaps' => $sitemaps,
				] );
			}
		}
	}

	public static function mc_robots_txt()
	{
		$robots = self::ROBOTS_DISALLOW_ALL;

		$sitemap = [];

		// if ( self::check_not_restricted() )
		
		if ( self::check_robots_full() )
		{
			$robots = self::ROBOTS;

			self::get_sitemaps();

			$sitemap = [
				'',
	
				// 'Sitemap: ' . $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER[ 'HTTP_HOST' ] . '/sitemap_index.xml',
				
				// 'Sitemap: ' . $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER[ 'HTTP_HOST' ] . '/wp-sitemap.xml',

				// WP Sitemap XML
				
				'Sitemap: ' . self::get_url() . '/wp-sitemap.xml',

				// Yoast SEO Sitemap XML
				
				// 'Sitemap: ' . self::get_url() . '/sitemap_index.xml',
			];
		}

		// LegalDebug::debug( [
		// 	'ToolRobots' =>'mc_robots_txt',

		// 	'get_host' => self::get_host(),

		// 	'check_not_restricted' => self::check_not_restricted(),

		// 	'robots' => $robots,

		// 	'sitemap' => $sitemap,
		// ] );

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