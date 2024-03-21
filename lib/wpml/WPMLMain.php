<?php

require_once( 'WPMLLangSwitcher.php' );

require_once( 'WPMLTrid.php' );

require_once( 'WPMLLanguageMismatch.php' );

// require_once( 'WPMLHreflang.php' );

require_once( 'WPMLChooseYourCountry.php' );

class WPMLMain
{
    public static function get_all_languages() {
        $languages = apply_filters(
            'wpml_active_languages',

            NULL,
            [
                'skip_missing' => 0,

                'orderby' => 'id',

                'order' => 'asc',
            ]
        );

        return $languages;
    }

    const EXCLUDE = [
        'pt_GB',

        'pt_ES',

        'sr_SR',

        'se_SE',

        'cs_CS',

        'en',

        'es',
        
        'ru',
        
        'dk_DA',

        'da',

        'pt',

        'sv',
    ];

    public static function exclude( $args , $exclude = [] )
    {
        $default_locale = array_column( $args, 'default_locale', 'code' );

        $default_locale_exclude = self::EXCLUDE;

        if ( !empty( $exclude ) )
        {
            $default_locale_exclude = $exclude;
        }

        // LegalDebug::debug( [
        //     'function' => 'WPMLMain::exclude',

		// 	'default_locale' => $default_locale,

		// 	'default_locale_exclude' => $default_locale_exclude,
		// ] );

        $keys = [];

        foreach ( $default_locale_exclude as $exclude_item ) {
            $key = array_search( $exclude_item, $default_locale );

            // LegalDebug::debug( [
            //     'function' => 'WPMLMain::exclude',
    
            //     'exclude_item' => $exclude_item,
    
            //     'key' => $key,
            // ] );

            if ( $key !== false ) {
                $keys[] = $key;
            }
        }

        foreach ( $keys as $key ) {
            unset( $args[$key] );
        }

        // LegalDebug::debug( [
        //     'function' => 'WPMLMain::exclude',

		// 	'default_locale' => $default_locale,

		// 	'default_locale_exclude' => $default_locale_exclude,
		// ] );

        return $args;
    }

    public static function search_language()
	{
		$lang = self::get_group_language();
		
        $languages = self::exclude( self::get_all_languages() );

        // LegalDebug::debug( [
		// 	'lang' => $lang,

		// 	'languages' => $languages,
		// ] );

		return self::filter_language( $languages, $lang );
	}

    public static function get_group_language()
	{
		$locale = self::get_locale();
		
        return substr( $locale, 0, 2 );
	}

    public static function filter_language( $items, $value )
	{
        // LegalDebug::debug( [
        //     'HOME' => LegalBreadcrumbsMain::HOME,
        // ] );

		return array_filter( $items, function( $item ) use ( $value ) {
            // LegalDebug::debug( [
            //     'default_locale' => $item[ 'default_locale' ],

            //     'value' => $value,

            //     'code' => $item[ 'code' ],
            // ] );

			// return (
			// 	strpos( $item[ 'default_locale' ], $value ) !== false
			// 	&& !array_key_exists( $item[ 'code' ], LegalBreadcrumbsMain::HOME )
			// );

			return strpos( $item[ 'default_locale' ], $value ) !== false;

            // return strpos( $item[ 'default_locale' ], $value ) !== false
            //     && !in_array( $item[ 'code' ], BaseHeader::EXCLUDE );
		} );
	}

    public static function get_post_language_details( $id = null )
	{
        if ( !empty( $id ) )
        {
            return apply_filters( 'wpml_post_language_details', NULL, $id );
        }
        
        return apply_filters( 'wpml_post_language_details', NULL );
	}

    public static function get_locale()
	{
        return get_locale();
	}

    public static function translated_menu_id( $id, $type = 'nav_menu' )
	{
		return apply_filters( 'wpml_object_id', $id, $type );
	}

    public static function current_language()
    {
        return apply_filters( 'wpml_current_language', NULL );
    }

    public static function locale_permalink( $url, $locale )
    {
        return apply_filters( 'wpml_permalink', $url, $locale, true );
    }

    public static function get_element_type( $id = null )
    {
        // LegalDebug::debug( [
        //     'function' => 'WPMLMain::get_element_type',

        //     'id' => $id,

        //     'get_post_type' => get_post_type( $id ),

        //     'wpml_element_type' => apply_filters( 'wpml_element_type', get_post_type( $id ) ),
        // ] );

        return apply_filters( 'wpml_element_type', get_post_type( $id ) );
    }

    public static function get_language_code( $id = null )
    {
        return apply_filters(
            'wpml_element_language_code',

            null,

            [
                'element_id' => $id,
                
                'element_type' => get_post_type( $id ),
            ]
        );
    }

    public static function get_language_details( $id = null )
    {
        return apply_filters(
            'wpml_element_language_details',

            null,

            [
                'element_id' => $id,
                
                'element_type' => self::get_element_type( $id ),
            ]
        );
    }

    public static function register()
    {
        $handler = new self();

        WPMLLangSwitcher::register();

        WPMLTrid::register();

        WPMLLanguageMismatch::register();

        // WPMLHreflang::register();

        WPMLChooseYourCountry::register();

        add_filter( 'wpml_hreflangs', [ $handler, 'change_page_hreflang' ] );

        // add_filter( 'language_attributes', [ $handler, 'legal_language_attributes' ], 10, 2 );
        
        // add_filter( 'pre_determine_locale', [ $handler, 'legal_determine_locale' ], 10, 2 );

        // add_filter( 'locale', [ $handler, 'legal_locale' ] );
    }

    public static function language_attributes()
    {
        echo 'lang="' . esc_attr( self::get_hreflang() ) . '"';
    }

    public static function get_hreflang()
    {
        return str_replace( '_', '-', self::get_locale() );
    }

    // public static function legal_determine_locale ( $locale )
    // {
    //     if ( $post = get_post() )
    //     {
    //         LegalDebug::debug( [
    //             'WPMLMain' => 'legal_determine_locale',
                
    //             'get_language_details' => self::get_language_details( $post->ID ),
    //         ] );
    //     }

    //     return $locale;
    // }

    // public static function legal_locale ( $locale )
    // {
    //     LegalDebug::debug( [
    //         'function' => 'change_page_hreflang',

    //         'locale' => $locale,
    //     ] );
        
    //     return $locale;
    // }

    public static function legal_language_attributes ( $output, $doctype )
    {
        LegalDebug::debug( [
            'WPMLMain' => 'legal_language_attributes',

            'output' => $output,

            'doctype' => $doctype,
            
            'get_bloginfo' => get_bloginfo( 'language' ),
        ] );

        return $output;
    }
  
    public static function change_page_hreflang( $hreflang_items )
    {
        // $output = __( 'html_lang_attribute' );

        // LegalDebug::debug(
        //     [
        //         'function' => 'change_page_hreflang',

        //         '__(output' => $output,

        //         'html_lang_attribute' => 'html_lang_attribute' === $output ? 'true' : 'false',

        //         'preg_match' => preg_match( '/[^a-zA-Z0-9-]/', $output ) ? 'true' : 'false',

        //         'determine_locale' => determine_locale(),
        //     ]
        // );

        // if ( 'html_lang_attribute' === $output || preg_match( '/[^a-zA-Z0-9-]/', $output ) )
        // {
        //     $output = determine_locale();

        //     $output = str_replace( '_', '-', $output );
        // }

        // LegalDebug::debug(
        //     [
        //         'function' => 'change_page_hreflang',

        //         'get_bloginfo' => get_bloginfo( 'language' ),

        //         'output' => $output,
        //     ]
        // );

        $hreflang = [];

        if ( !empty( $hreflang_items ) )
        {
            foreach ( $hreflang_items as $hreflang_code => $hreflang_url )
            {
                $hreflang[] = '<link rel="alternate" hreflang="' . esc_attr( $hreflang_code ) . '" href="' . esc_url( $hreflang_url ) . '">' . PHP_EOL;
            }
    
            echo apply_filters( 'wpml_hreflangs_html', implode( '', $hreflang ) );
        }
            
        return false;
    }
}

?>