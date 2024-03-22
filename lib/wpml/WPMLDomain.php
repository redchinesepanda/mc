<?php

class WPMLDomain
{
	public static function register_fuinctions()
	{
		$handler = new self();

		// add_action( 'update_option_icl_sitepress_settings', [ $handler,'prevent_update_option' ], 10, 3 );
		
		// add_action( 'update_option_' . self::OPTIONS[ 'icl-sitepress-settings' ], [ $handler,'prevent_update_option' ], 10, 3 );

		// add_action( 'update_option_' . self::OPTIONS[ 'wplang' ], [ $handler,'prevent_update_option' ], 10, 3 );

		// add_action( 'update_option', [ $handler,'prevent_update_option' ], 10, 3 );

		add_filter( 'option_' . self::OPTIONS[ 'icl-sitepress-settings' ], [ $handler, 'wp_kama_option_filter' ], 10, 2 );
	}
	
	function wp_kama_option_filter( $value, $option )
	{

		if ( $option == self::OPTIONS[ 'icl-sitepress-settings' ] )
		{
			$default_language = ToolNotFound::get_default_language();

			// LegalDebug::debug( [
			// 	'WPMLDomain' => 'wp_kama_option_filter',

			// 	'default_language' => $default_language,

			// 	'option' => $option,

			// 	'value' => $value,
			// ] );

			$value[ 'default_language' ] = $default_language;
		}

		return $value;
	}

	public static function register()
	{
		// $handler = new self();

		// add_action( 'init', [ $handler,'change_language_negotiation_type' ] );

		self::change_language_negotiation_type();
	}

	const OPTIONS = [
		'icl-sitepress-settings' => 'icl_sitepress_settings',

		'wplang' => 'WPLANG',
	];

	function prevent_update_option( $old_value, $value, $option )
	{
		// if ( $option === self::OPTIONS[ 'wpml-settings' ] )
		// {
			// LegalDebug::die( [
			// 	'WPMLDomain' => 'prevent_update_option',
	
			// 	'old_value' => $old_value,
	
			// 	'value' => $value,
	
			// 	'option' => $option,
			// ] );

			// return $old_value;
		// }

		return $value;
	}

	const SETTINGS = [
		'default-language' => 'default_language',
	];

	public static function change_language_negotiation_type()
    {
		global $sitepress;

		$default_language = ToolNotFound::get_default_language();

		$sitepress_default_language = $sitepress->get_setting( self::SETTINGS[ 'default-language' ] );

		$option_default_language = get_option( self::SETTINGS[ 'default-language' ] );

		LegalDebug::debug( [
			'WPMLDomain' => 'change_language_negotiation_type',

			'check_change_default_language' => self::check_change_default_language(),
			
			'default_language' => $default_language,

			'sitepress_default_language' => $sitepress_default_language,

			'option_default_language' => $option_default_language,

			// 'urls' => $sitepress->get_setting( 'urls' ),

			// 'language_negotiation_type' => $sitepress->get_setting( 'language_negotiation_type' ),

			// 'WPML_LANGUAGE_NEGOTIATION_TYPE_DIRECTORY' => WPML_LANGUAGE_NEGOTIATION_TYPE_DIRECTORY,

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