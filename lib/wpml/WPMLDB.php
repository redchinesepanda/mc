<?php

class WPMLDB
{
	public static function multisite_trid_items_db_query( $wpdb, $trid )
	{
		return $wpdb->prepare(
			// "SELECT
			// 	wp_icl_translations.element_id,
			// 	wp_icl_translations.language_code
			// FROM
			// 	wp_icl_translations
			// WHERE
			// 	trid = %d
			// ",

			"SELECT
				wp_icl_translations.element_id,
				wp_icl_translations.language_code,
				wp_icl_languages.default_locale
			FROM
				wp_icl_translations
			LEFT JOIN
				wp_icl_languages
			ON
				wp_icl_languages.code = wp_icl_translations.language_code
			WHERE
				trid = %d
			",

			[
				$trid,
			]
		); 
	}

	public static function multisite_all_languages_query( $wpdb, $display_language_code )
    {
        return $wpdb->prepare(
            "SELECT wp_icl_languages.code,
			wp_icl_languages.id,
			-- wp_icl_languages.english_name AS native_name,
			-- wp_icl_languages_translations.name AS translated_name,
			wp_icl_languages.english_name AS translated_name,
			wp_icl_languages_translations.name AS native_name,
			wp_icl_languages.default_locale

            FROM wp_icl_languages

			INNER JOIN wp_icl_languages_translations ON wp_icl_languages.code = wp_icl_languages_translations.language_code

            WHERE wp_icl_languages.active = %d
				-- AND wp_icl_languages_translations.display_language_code = %s
				AND wp_icl_languages.code = wp_icl_languages_translations.display_language_code
			
			ORDER BY wp_icl_languages_translations.id DESC
			",

            [
				1,

                $display_language_code,
            ]
        ); 
    }

	const PATTERNS = [
		'url' => '%s/%s/',

		'url-path' => '%s/%s/%s/',

		'url-root' => '%s/',

		'url-root-path' => '%s/',

		'country_flag_url' => '%s/assets/img/multisite/flag/%s.svg',
	];

    public static function get_country_flag_url( $code )
	{
		// LegalMain::LEGAL_URL . '/assets/img/multisite/flag/' . $blog_language . '.svg'

		return sprintf( self::PATTERNS[ 'country_flag_url' ], LegalMain::LEGAL_URL, $code );
	}

    // public static function get_url( $siteurl, $code )
    
	public static function get_url( $siteurl, $code, $trid_items = [] )
	{
		$path = '';

		if ( ! empty( $trid_items[ $code ] ) )
		{
			$path = $trid_items[ $code ];
		}

		// LegalDebug::debug( [
		// 	'WPMLDB' => 'get_url-1',

		// 	'path' => $path,
		// ] );

		if ( $code == 'en' )
		{
			if ( !empty( $path ) )
			{
				return sprintf( self::PATTERNS[ 'url-root-path' ], $siteurl, $code, $path );
			}
			
			return sprintf( self::PATTERNS[ 'url-root' ], $siteurl );
		}

		if ( !empty( $path ) )
		{
			return sprintf( self::PATTERNS[ 'url-path' ], $siteurl, $code, $path );
		}

		return sprintf( self::PATTERNS[ 'url' ], $siteurl, $code );
	}

    public static function get_active( $language_code, $item_code )
	{
		// LegalDebug::debug( [
		// 	'WPMLDB' => 'get_active',

		// 	'language_code' => $language_code,

		// 	'item_code' => $item_code,
		// ] );

		if ( $item_code == $language_code )
		{
			return 1;
		}

		return 0;
	}

    // public static function parse_languages( $items, $language_code )
    
	public static function parse_languages( $items, $language_code, $trid_items = [] )
	{
		if ( $items )
		{
			$languages = [];

			$blog_id = 1;

			$domain = MultisiteBlog::get_domain();

			$domain_main_site = MultisiteBlog::get_domain_main_site( $domain );

			// LegalDebug::debug( [
			// 	'WPMLDB' =>'parse_languages',

			// 	'domain_main_site' => $domain_main_site,
			// ] );

			if ( !empty( $domain_main_site ) )
			{
				$blog_id = $domain_main_site->blog_id;
			}

			$siteurl = MultisiteBlog::get_siteurl( $blog_id );

			foreach ( $items as $item )
			{
				$active = self::get_active( $language_code, $item->code );

				// $active = 0;

				// if ( $item->code == $language_code )
				// {
				// 	$active = 1;
				// }

				// LegalDebug::debug( [
				// 	'WPMLDB' => 'parse_languages-1',

				// 	'url' => self::get_url( $siteurl, $item->code, $trid_items ),
				// ] );

				$languages[ $item->code ] = [
					'code' => $item->code,

					'id' => $item->id,

					'native_name' => $item->native_name,

					'active' => $active,

					'default_locale' => $item->default_locale,

					'translated_name' => $item->translated_name,

					// 'url' => self::get_url( $siteurl, $item->code ),
					
					'url' => self::get_url( $siteurl, $item->code, $trid_items ),

					'country_flag_url' => self::get_country_flag_url( $item->code ),

					'language_code' => $item->code,
				];
			}

			return $languages;
		}

		return [];
	}

    public static function check_not_page_on_front()
	{
		return ! self::check_page_on_front();
	}

    public static function check_page_on_front()
	{
		$post = get_post();

		if ( $post )
		{
			if ( $post->ID == get_option( 'page_on_front' ) )
			{
				return true;
			}
		}

		return false;
	}

    public static function set_post_uri( &$all_trid_items )
	{
		if ( ! empty( $all_trid_items ) )
		{
			$main_blog_id = MultisiteBlog::get_main_blog_id();

			$siteurl = MultisiteBlog::get_siteurl( $main_blog_id );

			MultisiteBlog::set_blog( $main_blog_id );

			$not_page_on_front = self::check_not_page_on_front();

			foreach( $all_trid_items as $key => $trid_item )
			{
				// $uri = ToolPermalink::get_post_uri( $trid_item->element_id );

				$uri_parts = [];

				$uri_parts[] = $siteurl;

				if ( $trid_item->language_code != 'en' )
				{
					$uri_parts[] = $trid_item->language_code;
				}

				if ( $not_page_on_front )
				{
					$uri_parts[] = ToolPermalink::get_post_uri( $trid_item->element_id );
				}

				$uri = implode( '/', $uri_parts );

				if ( !empty( $uri ) )
				{
					$all_trid_items[ $key ]->post_uri = $uri;
				}
			}

			MultisiteBlog::restore_blog();

			// LegalDebug::debug( [
			// 	'WPMLDB' => 'get_trid_items-1',
				
			// 	'all_trid_items-count' => count( $all_trid_items ),
				
			// 	// 'all_trid_items' => $all_trid_items,

			// 	'parsed_trid_items-count' => count( $parsed_trid_items ),

			// 	'parsed_trid_items' => $parsed_trid_items,
			// ] );
		}
		
		return [];
	}

    public static function parse_hreflang_items( $all_trid_items )
	{
		$parsed_trid_items = [];

		if ( ! empty( $all_trid_items ) )
		{
			self::set_post_uri( $all_trid_items );
		
			foreach( $all_trid_items as $trid_item )
			{
				$parsed_trid_items[] = [
					'hreflang' => WPMLMain::get_hreflang( $trid_item->default_locale ),

					'href' => $trid_item->post_uri,
				];
			}

			// LegalDebug::debug( [
			// 	'WPMLDB' => 'get_trid_items-1',
				
			// 	'all_trid_items-count' => count( $all_trid_items ),
				
			// 	// 'all_trid_items' => $all_trid_items,

			// 	'parsed_trid_items-count' => count( $parsed_trid_items ),

			// 	'parsed_trid_items' => $parsed_trid_items,
			// ] );
		}
		
		return $parsed_trid_items;
	}

	public static function get_hreflang()
	{
		global $wpdb;

		$trid_items_db = self::get_trid_items_db( $wpdb );

		if ( ! empty( $trid_items_db ) )
		{
			return self::parse_hreflang_items( $trid_items_db );
		}

		return [];
	}

    public static function parse_trid_items( $all_trid_items )
	{
		$parsed_trid_items = [];

		if ( ! empty( $all_trid_items ) )
		{
			self::set_post_uri( $all_trid_items );

			foreach( $all_trid_items as $trid_item )
			{
				$parsed_trid_items[ $trid_item->language_code ] = $trid_item->post_uri;
			}

			// $main_blog_id = MultisiteBlog::get_main_blog_id();

			// MultisiteBlog::set_blog( $main_blog_id );

			// foreach( $all_trid_items as $trid_item )
			// {
			// 	$uri = ToolPermalink::get_post_uri( $trid_item->element_id );

			// 	if ( !empty( $uri ) )
			// 	{
			// 		$parsed_trid_items[ $trid_item->language_code ] = $uri;
			// 	}
			// }

			// MultisiteBlog::restore_blog();

			// LegalDebug::debug( [
			// 	'WPMLDB' => 'get_trid_items-1',
				
			// 	'all_trid_items-count' => count( $all_trid_items ),
				
			// 	// 'all_trid_items' => $all_trid_items,

			// 	'parsed_trid_items-count' => count( $parsed_trid_items ),

			// 	'parsed_trid_items' => $parsed_trid_items,
			// ] );
		}

		return $parsed_trid_items;
	}

    public static function get_trid_items_db( $wpdb )
	{
		// $post = get_post();

		// if ( $post )
		// {
		// 	if ( $post->ID != get_option( 'page_on_front' ) )
		// 	{
				$translation_groups = WPMLTranslationGroups::get_translation_group( $post->ID );
	
				if ( ! empty( $translation_groups ) )
				{
					$trid = WPMLTranslationGroups::get_translation_group_trid( $translation_groups );
	
					$trid_items_db_query = self::multisite_trid_items_db_query( $wpdb, $trid );
		
					$trid_items_db = $wpdb->get_results( $trid_items_db_query );

					// LegalDebug::debug( [
					// 	'WPMLDB' => 'get_trid_items_db-1',

					// 	'trid_items_db_query' => $trid_items_db_query,

					// 	'trid_items_db' => $trid_items_db,
					// ] );

					if ( ! empty( $trid_items_db ) )
					{
						return $trid_items_db;
					}
		// 		}
		// 	}
		// }

		return [];
	}

    public static function get_trid_items( $wpdb )
	{
		$trid_items_db = self::get_trid_items_db( $wpdb );

		if ( ! empty( $trid_items_db ) )
		{
			return self::parse_trid_items( $trid_items_db );
		}

		return [];
	}

    public static function multisite_all_languages()
    {
		if ( MultisiteBlog::check_not_main_domain() )
		{
			return [];
		}

        global $wpdb;

        // $language_code = MultisiteSiteOptions::get_blog_language();
        
		$language_code = WPMLMain::current_language();

        $all_languages_query = self::multisite_all_languages_query( $wpdb, $language_code );

		// LegalDebug::debug( [
        //     'WPMLDB' => 'multisite_all_languages',

        //     'language_code' => $language_code,

        //     'all_languages_query' => $all_languages_query,
        // ] );
        
        $items = $wpdb->get_results( $all_languages_query );

		$trid_items = [];

		if ( MultisiteMain::check_multisite() )
		{
			if ( MultisiteBlog::check_main_domain() && MultisiteBlog::check_not_main_blog() )
			{
				$trid_items = self::get_trid_items( $wpdb );
			}
		}

		// $languages = self::parse_languages( $items, $language_code );
		
		$languages = self::parse_languages( $items, $language_code, $trid_items );

        // LegalDebug::debug( [
        //     'WPMLDB' => 'multisite_all_languages',

        //     'languages' => $languages,
        // ] );

		return $languages;
    }

	private function sort_by_id( $array_a, $array_b ) {

		return (int) $array_a['id'] > (int) $array_b['id'] ? - 1 : 1;
	}

	private function sort_by_name( $array_a, $array_b ) {

		return $array_a['translated_name'] > $array_b['translated_name'] ? 1 : - 1;
	}
}

?>