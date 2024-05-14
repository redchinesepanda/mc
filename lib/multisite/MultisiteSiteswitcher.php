<?php

class MultisiteSiteswitcher
{
	// LegalDebug::debug: Array
	// (
	// 	[MultisiteSiteswitcher] => register_functions_debug
	// 	[get_sites_list] => Array
	// 		(
	// 			[active] => WP_Site Object
	// 				(
	// 					[blog_id] => 1
	// 					[domain] => test.match.center
	// 					[path] => /
	// 					[site_id] => 1
	// 					[registered] => 2024-03-29 08:58:00
	// 					[last_updated] => 2024-05-02 15:38:14
	// 					[public] => 1
	// 					[archived] => 0
	// 					[mature] => 0
	// 					[spam] => 0
	// 					[deleted] => 0
	// 					[lang_id] => 0
	// 				)
	
	// 			[languages] => Array
	// 				(
	// 					[0] => WP_Site Object
	// 						(
	// 							[blog_id] => 2
	// 							[domain] => testkz.match.center
	// 							[path] => /
	// 							[site_id] => 1
	// 							[registered] => 2024-03-29 06:19:27
	// 							[last_updated] => 2024-05-02 08:51:57
	// 							[public] => 1
	// 							[archived] => 0
	// 							[mature] => 0
	// 							[spam] => 0
	// 							[deleted] => 0
	// 							[lang_id] => 0
	// 						)
	
	// 				)
	
	// 		)
	
	// )
	

	public static function register_functions_debug()
	{
		LegalDebug::debug( [
			'MultisiteSiteswitcher' =>'register_functions_debug',

			'get_sites_list' => self::get_sites_list(),
		] );
	}

	public static function parse_site( $site )
	{
		return [
			'id' => $site->blog_id,

			'title' => $site->blogname,

			'href' => $site->domain . $site->path,

			'src' => $site->id,

			'alt' => $site->blogname,
		];
	}

	public static function get_sites_list()
	{
		return [
			'active' => MultisiteBlog::get_current_site(),

			'languages' => MultisiteBlog::get_other_sites(),
		];

		// return [];
	}
}

?>