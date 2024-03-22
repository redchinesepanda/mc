<?php

class WPMLDomain
{
	public static function register()
	{
		// $handler = new self();

		// add_action( 'init', [ $handler,'change_language_negotiation_type' ] );

		self::change_language_negotiation_type();
	}

	public static function change_language_negotiation_type()
    {
		global $sitepress;

		LegalDebug::debug( [
			'WPMLDomain' => 'get_posts',

			'default_language' => $sitepress->get_setting( 'default_language' ),

			'urls' => $sitepress->get_setting( 'urls' ),

			'language_negotiation_type' => $sitepress->get_setting( 'language_negotiation_type' ),

			'WPML_LANGUAGE_NEGOTIATION_TYPE_DIRECTORY' => WPML_LANGUAGE_NEGOTIATION_TYPE_DIRECTORY,
		] );

		if ( self::check_default_language() )
		{
			$sitepress->set_setting( 'default_language', 'pl', true );
		}
    }
	
	public static function check_default_language()
	{
		return ToolNotFound::check_one_restricted_language();
	}
}

?>