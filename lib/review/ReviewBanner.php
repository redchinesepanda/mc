<?php

class ReviewBanner
{
	const CSS = [
        'review-banner' => LegalMain::LEGAL_URL . '/assets/css/review/review-banner.css',
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
    }

	const CSS_CLASS = [
		'container' => 'legal-banner',
	];

	public static function style_formats_banner( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Banner',
				
				'block' => 'img',

				'classes' => self::CSS_CLASS[ 'container' ],
			],
		] );
	}

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( './/*[contains(@class, \'' . self::CSS_CLASS[ 'container' ] . '\')]' );

		return $nodes;
	}

	const FIELD = [
        'title' => 'media-banner-title',

        'description' => 'media-banner-description',
        
		'referal' => 'media-banner-referal',
    ];

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

		// $item = null;

		// $last = $nodes->length - 1;

        // $args = [];

        // $container = $dom->createElement( 'div' );

        // $container->setAttribute( 'class', self::CSS_CLASS[ 'container' ] );

		foreach ( $nodes as $id => $node ) {
			$src = $node->getAttribute( 'src' );

			$attachment_id = attachment_url_to_postid( $src );

			if ( $attachment_id != 0 ) {
				LegalDebug::debug( [
					'title' => get_field( self::FIELD[ 'title' ], $attachment_id ),
					
					'description' => get_field( self::FIELD[ 'description' ], $attachment_id ),
					
					'referal' => get_field( self::FIELD[ 'referal' ], $attachment_id ),

					'src' => $src,
				] );
			}

            // $class = explode( ' ', $node->getAttribute( 'class' ) );

			// $permission_title = ( in_array( self::CSS_CLASS[ 'title' ], $class ) );

			// $permission_content = ( in_array( self::CSS_CLASS[ 'content' ], $class ) );

			// $permission_last = ( $id == $last );

			// if ( $permission_content ) {
			// 	$node->removeAttribute( 'class' );

            //     $args[ 'content' ] = ToolEncode::encode( $dom->saveHTML( $node ) );
			// }

			// if ( !empty( $item ) && ( $permission_title || $permission_last ) ) {
				
			// 	LegalDOM::appendHTML( $item, self::render( $args ) );

            //     $container->appendChild( $item );

            //     $item = null;
			// }

            // if ( $permission_last ) {
            //     $node->parentNode->replaceChild( $container, $node );
            // } else {
            //     $node->parentNode->removeChild( $node );
            // }

			// if ( $permission_title ) {

			// 	$item = $dom->createElement( 'div' );

            //     $class = self::CSS_CLASS[ 'pros' ];

            //     if ( strpos( $node->getAttribute( 'class' ), self::CSS_CLASS[ 'cons' ] ) !== false ) {
            //         $class = self::CSS_CLASS[ 'cons' ];
            //     }

			// 	$item->setAttribute( 'class', self::CSS_CLASS[ 'pros-item' ] . ' ' . $class );

			// 	$args = [];
				
			// 	$args[ 'title' ] = ToolEncode::encode( $node->textContent );
			// }
		}

		return $dom->saveHTML();
	}

	const TEMPLATE = [
		'review-banner' => LegalMain::LEGAL_PATH . '/template-parts/review/review-banner.php',
	];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'review-banner' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>