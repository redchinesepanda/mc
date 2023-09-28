<?php

class YoastOG
{
	public static function register()
    {
        $handler = new self();

		add_filter( 'wpseo_twitter_image', [ $handler, 'current_image' ] );

		add_filter( 'wpseo_opengraph_image', [ $handler, 'current_image' ] );

		// add_filter( 'wpseo_og_article:published_time' , [ $handler, 'opengraph_html' ] );
		
		add_filter( 'wpseo_og_article_publisher' , [ $handler, 'opengraph_html' ] );
		
		// add_action( 'wpseo_add_opengraph_images', [ $handler, 'default_opengraph_images' ] );
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

	public static function opengraph_html( $article_publisher = 'article_publisher', $presentation = 'presentation' )
	{
		LegalDebug::debug( [
			'article_publisher' => $article_publisher,

			'presentation' => $presentation,
		] );

		return $article_publisher;
	}

	// function default_opengraph_images( $object )
	// {
	// 	$object->add_image( self::current_image() );
	// }

	
}

?>