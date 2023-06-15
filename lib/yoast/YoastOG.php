<?php

class YoastOG
{
	public static function register()
    {
        $handler = new self();

		// add_action( 'wpseo_add_opengraph_images', [ $handler, 'default_opengraph_images' ] );

		add_filter( 'wpseo_twitter_image', [ $handler, 'current_image' ] );

		add_filter( 'wpseo_opengraph_image', [ $handler, 'current_image' ] );
    }

	function current_image()
	{
		// LegalDebug::debug( [
		// 	'current_image' => LegalMain::LEGAL_URL . '/assets/img/yoast/preview-' . WPMLMain::current_language() . '.webp',
		// ] );

		return LegalMain::LEGAL_URL . '/assets/img/yoast/preview-' . WPMLMain::current_language() . '.webp';
	}

	// function default_opengraph_images( $object )
	// {
	// 	$object->add_image( self::current_image() );
	// }
}

?>