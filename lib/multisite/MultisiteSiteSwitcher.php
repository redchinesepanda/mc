<?php

class MultisiteSiteSwitcher 
{
	const PATTERNS = [
		'siteurl' => '%s/',
	];

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
		// LegalDebug::debug( [
		// 	'MultisiteSiteswitcher' =>'get_combined_languages',

		// 	'languages-count' => count( $languages ),
			
		// 	// 'languages' => $languages,

		// 	'page_languages-count' => count( $page_languages ),
			
		// 	// 'page_languages' => $page_languages,
		// ] );

		$page_languages = array_intersect_key( $page_languages, $languages );

		// LegalDebug::debug( [
		// 	'MultisiteSiteswitcher' =>'get_combined_languages',

		// 	'page_languages' => count( $page_languages ),
		// ] );

		foreach ( $page_languages as $language_code => $page_language )
		{
			// LegalDebug::debug( [
			// 	'MultisiteSiteswitcher' =>'get_combined_languages',

			// 	'language' => $languages[ $language_code ],

			// 	'page_language' => $page_language,
			// ] );

			$languages[ $language_code ] = array_merge( $languages[ $language_code ], $page_language );

			// LegalDebug::debug( [
			// 	'MultisiteSiteswitcher' =>'get_combined_languages',

			// 	'language' => $languages[ $language_code ],
			// ] );
		}

		return $languages;
	}

	public static function get_languages()
	{
		$current_domain = MultisiteBlog::get_domain();
		
		$blogs = MultisiteBlog::get_all_sites( $current_domain );
		
		// $blogs = MultisiteBlog::get_other_sites( $current_domain );

		$languages = self::sites_to_languages( $blogs );

		LegalDebug::debug( [
			'MultisiteSiteswitcher' =>'get_languages-2',

			'languages-count' => count( $languages ),
		] );

		$language = WPMLMain::get_group_language();

		$languages = WPMLMain::filter_language( $languages, $language );

		$page_languages = MultisiteHreflang::prepare_languages();

		$combined_languages = self::get_combined_languages( $languages, $page_languages );

		LegalDebug::debug( [
			'MultisiteSiteswitcher' =>'get_languages-1',

			'blogs-count' => count( $blogs ),

			'languages-count' => count( $languages ),
			
			// 'languages' => $languages,

			'page_languages-count' => count( $page_languages ),
			
			// 'page_languages' => $page_languages,

			'combined_languages-count' => count( $combined_languages ),
		] );

		// $lang = WPMLMain::get_group_language();

		// $combined_languages = WPMLMain::filter_language( $combined_languages, $lang );

		// LegalDebug::debug( [
		// 	'MultisiteSiteswitcher' =>'get_languages-2',

		// 	'combined_languages-count' => count( $combined_languages ),
		// ] );

		return $combined_languages;

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

	public static function get_siteurl( $siteurl )
	{
		return sprintf( self::PATTERNS[ 'siteurl' ], $siteurl );
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

		// LegalDebug::debug( [
		// 	'MultisiteSiteswitcher' =>'site_to_language-1',

		// 	'siteurl' => $site->siteurl,

		// 	'path' => $site->path,

		// 	'pattern' => sprintf( self::PATTERNS[ 'siteurl' ], $site->siteurl ),

		// 	'site' => $site,
		// ] );

		return [
			'id' => $site->blog_id,

			// 'native_name' => $site->blogname,
			
			'native_name' => self::get_native_name( $site ),

			'translated_name' => $site->blogname,

			// 'url' => $site->siteurl,
			
			'url' => self::get_siteurl( $site->siteurl ),

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