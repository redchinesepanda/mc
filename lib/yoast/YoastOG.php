<?php

class YoastOG
{
	public static function register_functions()
    {
        $handler = new self();

		add_filter( 'wpseo_twitter_image', [ $handler, 'current_image' ] );

		add_filter( 'wpseo_opengraph_image', [ $handler, 'current_image' ] );
    }

	public static function register()
    {
        // $handler = new self();
	
		// add_filter( 'wpseo_locale', [ $handler, 'yst_wpseo_change_og_locale' ] );
    }

	function yst_wpseo_change_og_locale( $locale )
	{
		LegalDebug::debug( [
			'YoastOG' => 'yst_wpseo_change_og_locale',

			'locale' => $locale,
		] );

		if ( MiltisiteMain::check_multisite() )
		{
			if ( $locale_multisite = MultisiteSiteOptions::get_blog_locale() )
			{
				LegalDebug::debug( [
					'YoastOG' => 'yst_wpseo_change_og_locale',
		
					'locale_multisite' => $locale_multisite,
				] );
			}
		}

		return $locale;
	}

	public static function current_image()
	{
		$language = WPMLMain::current_language();

		if ( !file_exists( LegalMain::LEGAL_PATH . '/assets/img/yoast/preview-' . $language . '.webp' ) ) {
			$language = 'default';
		}

		return LegalMain::LEGAL_URL . '/assets/img/yoast/preview-' . $language . '.webp';
	}
}

?>