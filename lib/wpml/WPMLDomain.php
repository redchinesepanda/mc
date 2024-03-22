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

		// $sitepress->set_setting( 'language_negotiation_type', $value, true );

        // $new_lang = get_field( self::COMPILATION[ 'lang' ], $id );

        // $switch_lang = ( !empty( $new_lang ) );

        // if ( $switch_lang ) {
        //     global $sitepress;

        //     $current_lang = $sitepress->get_current_language();

        //     $sitepress->switch_lang( $new_lang );
        // }

        // $posts = get_posts( self::get_args( $id ) );

        // if ( $switch_lang ) {
        //     $sitepress->switch_lang( $current_lang );
        // }

        // return $posts;
    }
}

?>