<?php

class WPMLDB
{
	public static function multisite_all_languages_query( $wpdb, $display_language_code )
    {
        return $wpdb->prepare(
            "SELECT wp_icl_languages.code,
			wp_icl_languages.id,
			wp_icl_languages_translations.name AS native_name,
			wp_icl_languages.default_locale

            FROM wp_icl_languages

			INNER JOIN wp_icl_languages_translations ON wp_icl_languages.code = wp_icl_languages_translations.language_code

            WHERE wp_icl_languages.active = %d
				AND wp_icl_languages_translations.display_language_code = %s
			",

            [
				1,

                $display_language_code,
            ]
        );
    }

	const PATTERNS = [
		'url' => '%s/%s/',

		'url-root' => '%s/',

		'country_flag_url' => '%s/assets/img/multisite/flag/%s.svg',
	];

    public static function get_country_flag_url( $code )
	{
		// LegalMain::LEGAL_URL . '/assets/img/multisite/flag/' . $blog_language . '.svg'

		return sprintf( self::PATTERNS[ 'country_flag_url' ], LegalMain::LEGAL_URL, $code );
	}

    public static function get_url( $siteurl, $code )
	{
		if ( $code == 'en' )
		{
			return sprintf( self::PATTERNS[ 'url-root' ], $siteurl );
		}

		return sprintf( self::PATTERNS[ 'url' ], $siteurl, $code );
	}

    public static function get_active( $language_code, $item_code )
	{
		if ( $item_code == $language_code )
		{
			return 1;
		}

		return 0;
	}

    public static function parse_languages( $items, $language_code )
	{
		if ( $items )
		{
			$languages = [];

			$blog_id = 1;

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

				$languages[ $item->code ] = [
					'code' => $item->code,

					'id' => $item->id,

					'native_name' => $item->native_name,

					'active' => $active,

					'default_locale' => $item->default_locale,

					'url' => self::get_url( $domain, $item->code ),

					'country_flag_url' => self::get_country_flag_url( $item->code ),

					'language_code' => $item->code,
				];
			}

			return $languages;
		}

		return [];
	}

    public static function multisite_all_languages()
    {
        // LegalDebug::debug( [
        //     'WPMLMain' => 'multisite_all_languages',

        //     'data' => $data,

        //     'element' => $element,
        // ] );

        global $wpdb;

        $language_code = MultisiteSiteOptions::get_blog_language();

        $all_languages_query = self::multisite_all_languages_query( $wpdb, $language_code );

		LegalDebug::debug( [
            'WPMLMain' => 'multisite_all_languages',

            'language_code' => $language_code,

            'all_languages_query' => $all_languages_query,
        ] );

        // LegalDebug::debug( [
        //     'WPMLMain' => 'multisite_all_languages',

        //     'all_languages_query' => $all_languages_query,
        // ] );
        
        $items = $wpdb->get_results( $all_languages_query );

		$languages = self::parse_languages( $items, $language_code );

        // $language_code = $wpdb->get_var( $all_languages_query );

        LegalDebug::debug( [
            'WPMLMain' => 'multisite_all_languages',

            'languages' => $languages,
        ] );

        // if ( $language_code != 'en' )
        // {
        //     return $language_code;
        // }

        // return '';

        // return $language_code;
        
        // return $wpdb->get_var( $language_code_query );
    }
}

?>