<?php

class MultisiteSiteswitcher
{
	public static function register_functions_debug()
	{
		// LegalDebug::debug( [
		// 	'MultisiteSiteswitcher' =>'register_functions_debug',

		// 	'get_sites_list' => self::get_sites_list(),
		// ] );
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