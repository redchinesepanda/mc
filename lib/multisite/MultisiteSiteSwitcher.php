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

	public static function get_combined_languages( $languages, $page_languages )
	{
		$page_languages = array_intersect_key( $page_languages, $languages );

		foreach ( $page_languages as $language_code => $page_language )
		{
			$languages[ $language_code ] = array_merge( $languages[ $language_code ], $page_language );
		}

		return $languages;
	}

	public static function get_languages()
	{
		$current_domain = MultisiteBlog::get_domain();
		
		$blogs = MultisiteBlog::get_all_sites( $current_domain );

		$languages = self::sites_to_languages( $blogs );

		$page_languages = MultisiteHreflang::prepare_languages();

		return self::get_combined_languages( $languages, $page_languages );

		// return self::sites_to_languages( $blogs );

		// return self::sites_to_languages( MultisiteBlog::get_sites() );
	}

	public static function sites_to_languages( $sites )
	{
		$languages = [];

		foreach ( $sites as $site )
		{
			$language = self::site_to_language( $site );

            $languages[ $language[ 'code' ] ] = $language;
        }

		return $languages;
	}

	public static function get_native_name( $site )
	{
		$blog_label = MultisiteBlog::get_blog_option( $site->blog_id, MultisiteSiteOptions::OPTIONS[ 'blog-label' ] );

		if ( ! empty( $blog_label ) )
		{
			return $blog_label;
		}

		return $site->blogname;
	}

	public static function site_to_language( $site )
	{
		$blog_language = MultisiteBlog::get_blog_option( $site->blog_id, MultisiteSiteOptions::OPTIONS[ 'blog-language' ] );

		$blog_locale = MultisiteBlog::get_blog_option( $site->blog_id, MultisiteSiteOptions::OPTIONS[ 'blog-locale' ] );

		$active = 0;

		if ( MultisiteBlog::get_current_blog_id() == $site->blog_id )
		{
			$active = 1;
		}

		return [
			'id' => $site->blog_id,

			// 'native_name' => $site->blogname,
			
			'native_name' => self::get_native_name( $site ),

			'translated_name' => $site->blogname,

			'url' => $site->siteurl,

			'code' => $blog_language,

			'language_code' => $blog_language,

			'default_locale' => $blog_locale,

			'country_flag_url' => LegalMain::LEGAL_URL . '/assets/img/multisite/flag/' . $blog_language . '.svg',

			'active' => $active,
		];
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

		$current_domain = MultisiteBlog::get_domain();
		
		$sites = MultisiteBlog::get_other_sites( $current_domain );

		// $sites = MultisiteBlog::get_other_sites();

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