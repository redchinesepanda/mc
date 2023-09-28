<?php

class YoastOG
{
	public static function register()
    {
        $handler = new self();

		add_filter( 'wpseo_twitter_image', [ $handler, 'current_image' ] );

		add_filter( 'wpseo_opengraph_image', [ $handler, 'current_image' ] );
		
		// add_action( 'wpseo_add_opengraph_images', [ $handler, 'default_opengraph_images' ] );

		add_filter( 'wpseo_frontend_presenters', [ $handler, 'add_my_custom_presenter' ] );
    }

	public static function current_image()
	{
		// LegalDebug::debug( [
		// 	'current_image' => LegalMain::LEGAL_URL . '/assets/img/yoast/preview-' . WPMLMain::current_language() . '.webp',
		// ] );

		$language = WPMLMain::current_language();

		if ( !file_exists( LegalMain::LEGAL_PATH . '/assets/img/yoast/preview-' . $language . '.webp' ) ) {
			$language = 'default';
		}

		return LegalMain::LEGAL_URL . '/assets/img/yoast/preview-' . $language . '.webp';
	}

	// function default_opengraph_images( $object )
	// {
	// 	$object->add_image( self::current_image() );
	// }

	function add_my_custom_presenter( $presenters )
	{
		// $presenters[] = new My_Custom_Presenter();

		foreach ( $presenters as $presenter )
		{
			LegalDebug::debug( [
				$presenter->present(),
			] );
		}
	
		return $presenters;
	}
}

?>