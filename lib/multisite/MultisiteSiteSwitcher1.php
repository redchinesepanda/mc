<?php

class MultisiteSiteSwitcher 
{
	public static function register_functions_debug()
	{
		// LegalDebug::debug( [
		// 	'MultisiteSiteswitcher' =>'register_functions_debug',

		// 	'get_sites_list' => self::get_sites_list(),
		// ] );
	}

	public static function get_path( $site )
	{
		if ( $site->path != '/' )
		{
			return $site->path;
		}

		return 'en';
	}

	public static function parse_site( $site )
	{
		// LegalDebug::debug( [
		// 	'MultisiteSiteswitcher' =>'parse_site',

		// 	'site' => $site,

		// 	// 'get_blog_details' => get_blog_details( $site->blog_id, true ),
		// ] );

		return [
			'id' => $site->blog_id,

			'title' => $site->blogname,

			'href' => $site->siteurl,

			'src' => LegalMain::LEGAL_URL . '/assets/img/multisite/flag/' . self::get_path( $site ) . '.svg',

			'alt' => $site->blogname,
		];
	}

	public static function get_sites_list()
	{
		$active = self::parse_site( MultisiteBlog::get_current_site() );

		$avaible = [];

		$sites = MultisiteBlog::get_other_sites();

		foreach ( $sites as $site )
		{
			$avaible[] = self::parse_site( $site );
		}

		return [
			'active' => $active,

			'languages' => $avaible,
		];

		// return [];
	}
}

?>