<?php

class YoastOG
{
	public static function register_functions()
    {
        $handler = new self();

		add_filter( 'wpseo_opengraph_image', [ $handler, 'current_image_og' ] );

		add_filter( 'wpseo_twitter_image', [ $handler, 'current_image_twitter' ] );
    }

	public static function current_image_twitter( $image )
	{
		LegalDebug::debug( [
			'YoastOG' => 'current_image_twitter',
		] );

		return self::current_image( $image );
	}

	public static function current_image_og( $image )
	{
		LegalDebug::debug( [
			'YoastOG' => 'current_image_og',
		] );

		return self::current_image( $image );
	}

	public static function current_image( $image )
	{
		$language = WPMLMain::current_language();

		// if ( empty( $language ) )
		// {
		// 	$language = 'default';
		// }

		if ( empty( $language ) || ! file_exists( LegalMain::LEGAL_PATH . '/assets/img/yoast/preview-' . $language . '.webp' ) )
		{
			$language = 'default';
		}

		$url = LegalMain::LEGAL_URL . '/assets/img/yoast/preview-' . $language . '.webp';

		LegalDebug::debug( [
			'YoastOG' => 'current_image',

			'image' => $image,

			'language' => $language,

			'url' => $url,
		] );

		return $url;
	}

	public static function register()
    {
        $handler = new self();

		add_filter( 'wpseo_opengraph_image', [ $handler, 'current_image_og' ] );
	
		// add_filter( 'wpseo_locale', [ $handler, 'yst_wpseo_change_og_locale' ] );
    }

	// function yst_wpseo_change_og_locale( $locale )
	// {
	// 	LegalDebug::debug( [
	// 		'YoastOG' => 'yst_wpseo_change_og_locale',

	// 		'locale' => $locale,
	// 	] );

	// 	if ( MiltisiteMain::check_multisite() )
	// 	{
	// 		if ( $locale_multisite = MultisiteSiteOptions::get_blog_locale() )
	// 		{
	// 			LegalDebug::debug( [
	// 				'YoastOG' => 'yst_wpseo_change_og_locale',
		
	// 				'locale_multisite' => $locale_multisite,
	// 			] );
	// 		}
	// 	}

	// 	return $locale;
	// }
}

?>