<?php

class ReviewBanner
{
	const CSS = [
        'review-banner' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-banner.css',

			'ver' => '1.0.1',
		],
    ];

    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        add_filter( 'the_content', [ $handler, 'get_content' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_banner' ] );

		add_filter( 'disable_captions', [ $handler, 'disable_captions' ] );
    }

	public static function disable_captions( $bool ){
		return true;
	}

	const CSS_CLASS = [
		'container' => 'legal-banner',
	];

	public static function style_formats_banner( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Banner',
				
				// 'block' => 'p',

				'selector' => 'img',

				'classes' => self::CSS_CLASS[ 'container' ],
			],
		] );
	}

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		// $nodes = $xpath->query( './/img[contains(@class, \'' . self::CSS_CLASS[ 'container' ] . '\')]' );
		
		$nodes = $xpath->query( '//img[contains(@class, \'' . self::CSS_CLASS[ 'container' ] . '\')]' );

		return $nodes;
	}

	const FIELD = [
        'title' => 'media-banner-title',

        'description' => 'media-banner-description',
        
		'referal' => 'media-banner-referal',
    ];

	public static function get_img_id( $node )
	{
		$classes = explode( ' ', $node->getAttribute( 'class' ) );

		foreach ( $classes as $class ) {
			if ( strpos( $class, 'wp-image-' ) !== false ) {
				$parts = explode( '-', $class );
				return end( $parts );
			}
		}

		return 0;
	}

	public static function get_content( $content )
	{
        if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

        $nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		// $body = $dom->getElementsByTagName( 'body' )->item(0);

		foreach ( $nodes as $node ) {
			
			$attachment_id = self::get_img_id( $node );

			if ( $attachment_id != 0 ) {
				// $data = wp_get_attachment_image_src( $attachment_id, 'full' );

				$caption = wp_get_attachment_caption( $attachment_id );

				$item = $dom->createElement( 'div' );

				$item->setAttribute( 'class', self::CSS_CLASS[ 'container' ] );

				$node->removeAttribute( 'class' );

				$node->removeAttribute( 'srcset' );

				$node->removeAttribute( 'sizes' );

				LegalDOM::appendHTML( $item, self::render( [
					'image' => $dom->saveHTML( $node ),

					'caption' => ( $caption ? $caption : '' ),
				] ) );
				
				$replace = $node->parentNode;

				// try {
				// 	$body->replaceChild( $item, $replace );
				// } catch ( DOMException $e ) {
				// 	LegalDebug::debug( [
				// 		'ReviewBanner::get_content > replaceChild DOMException',
				// 	] );
				// }

				try
				{
					$replace->parentNode->replaceChild( $item, $replace );
				}
				catch ( DOMException $e )
				{
					LegalDebug::debug( [
						'class' => 'ReviewBanner',

						'function' => 'get_content,replaceChild',

						'node' => substr( $node->textContent, 0, 30 ),

						'message' => $e->getMessage(),
					] );
				}
			}
		}

		return $dom->saveHTML();
	}

	const TEMPLATE = [
		'review-banner' => LegalMain::LEGAL_PATH . '/template-parts/review/review-banner.php',
	];

    public static function render( $args )
    {
		if ( !ReviewMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'review-banner' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>