<?php

class WPMLDomain
{
	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'wpml_active_languages', [ $handler, 'wpml_get_active_languages_filter' ], 10, 2 );

		// add_action( 'update_option_icl_sitepress_settings', [ $handler,'prevent_update_option' ], 10, 3 );
		
		// add_action( 'update_option_' . self::OPTIONS[ 'icl-sitepress-settings' ], [ $handler,'prevent_update_option' ], 10, 3 );

		// add_action( 'update_option_' . self::OPTIONS[ 'wplang' ], [ $handler,'prevent_update_option' ], 10, 3 );

		// add_action( 'update_option', [ $handler,'prevent_update_option' ], 10, 3 );
		
		// add_action( 'wpml_before_startup', [ $handler, 'filter_settings' ], 10, 3 );

		// add_filter( 'option_' . self::OPTIONS[ 'icl-sitepress-settings' ], [ $handler, 'wp_kama_option_filter' ], 10, 2 );

		// add_filter( 'pre_option_' . self::OPTIONS[ 'icl-sitepress-settings' ], [ $handler, 'wp_kama_pre_option_filter'], 10, 3 );
	}

	public static function wpml_get_active_languages_filter( $languages, $args = '' )
	{
		// global $sitepress;
	
		// $args = wp_parse_args( $args );

		// $ls_languages = $sitepress->get_ls_languages( $args );

		LegalDebug::debug( [
			'WPMLDomain' => 'wpml_get_active_languages_filter',

			// 'languages' => $languages,

			// 'args' => $args,

			// 'ls_languages' => $ls_languages,
		] );

		// return $ls_languages;

		if ( ToolNotFound::check_domain_restricted() )
		{
			$current_host = $_SERVER[ 'HTTP_HOST' ];

			$main_host = LegalMain::get_main_host();

			$restricted_languages = ToolNotFound::get_restricted_languages();

			LegalDebug::debug( [
				'WPMLDomain' => 'wpml_get_active_languages_filter',
	
				'current_host' => $current_host,

				'main_host' => $main_host,

				'restricted_languages' => $restricted_languages,
			] );

			// foreach( $languages as $language )
			// {
			// 	if ( !array_key_exists( $language, $restricted_languages ) )
			// 	{
			// 		$languages[ $language ][ 'url' ] = str_replace( $current_host, $main_host, $languages[ $language ][ 'url' ] );
			// 	}
			// }
		}
		else
		{
			$current_host = $_SERVER[ 'HTTP_HOST' ];

			$main_host = LegalMain::get_main_host();

			$restricted_languages = ToolNotFound::get_restricted_languages();

			LegalDebug::debug( [
				'WPMLDomain' => 'wpml_get_active_languages_filter',
	
				'current_host' => $current_host,

				'main_host' => $main_host,

				'restricted_languages' => $restricted_languages,
			] );

			// foreach( $restricted_languages as $language )
			// {
			// 	if ( array_key_exists( $language, $languages ) )
			// 	{
			// 		$languages[ $language ][ 'url' ] = str_replace( $current_host, $main_host, $languages[ $language ][ 'url' ] );
			// 	}
			// }
		}

		return $empty_value;
	}

	public static function wp_kama_pre_option_filter( $pre_option, $option, $default_value )
	{
		LegalDebug::debug( [
			'WPMLDomain' => 'wp_kama_pre_option_filter',
		] );

		return $pre_option;
	}

	public static function filter_settings()
	{
		LegalDebug::debug( [
			'WPMLDomain' => 'filter_settings',
		] );

		$handler = new self();

		add_filter( 'option_' . self::OPTIONS[ 'icl-sitepress-settings' ], [ $handler, 'wp_kama_option_filter' ], 10, 2 );
	}

	public static function  wp_kama_option_filter( $value, $option )
	{
		// LegalDebug::debug( [
		// 	'WPMLDomain' => 'wp_kama_option_filter',

		// 	'option' => $option,
		// ] );

		if ( $option === self::OPTIONS[ 'icl-sitepress-settings' ] )
		{
			$default_language = ToolNotFound::get_default_language();

			LegalDebug::debug( [
				'WPMLDomain' => 'wp_kama_option_filter',

				'default_language' => $default_language,

				'option' => $option,

				'value_default_language' => $value[ 'default_language' ],

				'admin_default_language' => $value[ 'admin_default_language' ],

				// 'value' => $value,
			] );

			$value[ 'default_language' ] = $default_language;

			$value[ 'admin_default_language' ] = $default_language;

			LegalDebug::debug( [
				'WPMLDomain' => 'wp_kama_option_filter',

				'value_default_language' => $value[ 'default_language' ],

				'admin_default_language' => $value[ 'admin_default_language' ],
			] );
		}

		return $value;
	}

	public static function register()
	{
		// $handler = new self();

		// add_action( 'init', [ $handler,'change_language_negotiation_type' ] );

		// self::change_language_negotiation_type();

		// add_action( 'switch_blog', [ $handler, 'change_language_negotiation_type' ], 10, 1 );
	}

	const OPTIONS = [
		'icl-sitepress-settings' => 'icl_sitepress_settings',

		'wplang' => 'WPLANG',
	];

	const SETTINGS = [
		'default-language' => 'default_language',
	];

	// https://developer.wordpress.org/advanced-administration/plugins/mu-plugins/

	public static function change_language_negotiation_type()
    {
		global $sitepress;

		$default_language = ToolNotFound::get_default_language();

		// $option_icl_sitepress_settings = get_option( self::OPTIONS[ 'icl-sitepress-settings' ] );

		// $option_default_language = 'unset';

		// if ( !empty( $option_icl_sitepress_settings[ self::SETTINGS[ 'default-language' ] ] ) )
		// {
		// 	$option_default_language = $option_icl_sitepress_settings[ self::SETTINGS[ 'default-language' ] ];
		// }

		$sitepress_default_language = $sitepress->get_setting( self::SETTINGS[ 'default-language' ] );

		LegalDebug::debug( [
			'WPMLDomain' => 'change_language_negotiation_type',

			'home' => get_option( 'home' ),

			'is_current_request_root' => WPML_Root_Page::is_current_request_root(),
			
			'default_language' => $default_language,

			// 'option_default_language' => $option_default_language,

			'sitepress_default_language' => $sitepress_default_language,

			'getOrAttemptRecovery' => WPML\LIB\WP\Option::getOrAttemptRecovery( 'icl_sitepress_settings', [] ),

			// 'language_negotiation_type' => $sitepress->get_setting( 'language_negotiation_type' ),

			// 'WPML_LANGUAGE_NEGOTIATION_TYPE_DIRECTORY' => WPML_LANGUAGE_NEGOTIATION_TYPE_DIRECTORY,

			// 'WPML_LANGUAGE_NEGOTIATION_TYPE_DOMAIN' => WPML_LANGUAGE_NEGOTIATION_TYPE_DOMAIN,

			// 'WPML_LANGUAGE_NEGOTIATION_TYPE_PARAMETER' => WPML_LANGUAGE_NEGOTIATION_TYPE_PARAMETER,

			// 'option_icl_sitepress_settings' => $option_icl_sitepress_settings,

			// 'BLOG_ID_CURRENT_SITE' => BLOG_ID_CURRENT_SITE,

			// 'check_change_default_language' => self::check_change_default_language(),

			// 'urls' => $sitepress->get_setting( 'urls' ),

			// 'current_language' => WPMLMain::current_language(),
		] );

		// $sitepress->set_default_language( $default_language );

		// if ( self::check_change_default_language() )
		// {
			// $sitepress->set_setting
			// (
			// 	self::SETTINGS[ 'default-language' ],

			// 	$default_language,
				
			// 	true
			// );

			// $sitepress->save_settings();
		// }
		// else
		// {
		// 	$sitepress->set_setting
		// 	(
		// 		self::SETTINGS[ 'default-language' ],
				
		// 		$default_language,
				
		// 		true
		// 	);

		// 	// $sitepress->save_settings();
		// }
    }
	
	public static function check_change_default_language()
	{
		return ToolNotFound::check_domain();
	}
}

?>