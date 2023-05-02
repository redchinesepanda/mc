<?php

class ReviewProsCons
{
    const CSS = [
        'review-pros-cons' => LegalMain::LEGAL_URL . '/assets/css/review/review-pros-cons.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_filter( 'the_content', [ $handler, 'get_content' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_pros' ] );
    }

	public static function get_content( $content )
	{
        if ( !ReviewMain::is_front() ) {
			return $content;
		}

		$dom = self::get_dom( get_the_content() );

        $nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		$item = null;

		$last = $nodes->length - 1;

        $args = [];

        // $container = $dom->createElement( 'div' );

        // $container->setAttribute( 'class', self::CSS_CLASS[ 'container' ] );

		// foreach ( $nodes as $id => $node ) {
        //     $class = explode( ' ', $node->getAttribute( 'class' ) );

		// 	$permission_title = ( in_array( self::CSS_CLASS[ 'title' ], $class ) );

		// 	$permission_content = ( in_array( self::CSS_CLASS[ 'content' ], $class ) );

		// 	$permission_last = ( $id == $last );

		// 	if ( $permission_content ) {
		// 		$node->removeAttribute( 'class' );

        //         $args[ 'content' ] = $dom->saveHTML( $node );
		// 	}

		// 	if ( !empty( $item ) && ( $permission_title || $permission_last ) ) {
				
		// 		self::appendHTML( $item, self::render( $args ) );

        //         $container->appendChild( $item );

        //         $item = null;
		// 	}

        //     if ( $permission_last ) {
        //         // $node->parentNode->replaceChild( $container, $node );
        //     } else {
        //         // $node->parentNode->removeChild( $node );
        //     }

		// 	if ( $permission_title ) {

		// 		$item = $dom->createElement( 'div' );

        //         $class = self::CSS_CLASS[ 'pros' ];

        //         if ( strpos( $node->getAttribute( 'class' ), self::CSS_CLASS[ 'cons' ] ) !== false ) {
        //             $class = self::CSS_CLASS[ 'cons' ];
        //         }

		// 		$item->setAttribute( 'class', self::CSS_CLASS[ 'pros-item' ] . ' ' . $class );

		// 		$args = [];
				
		// 		$args[ 'title' ] = ToolEncode::encode( $node->textContent );
		// 	}
		// }

		return $dom->saveHTML();

        // return $content;
	}

	public static function appendHTML( DOMNode $parent, $source ) {
		$tmpDoc = new DOMDocument();

		$tmpDoc->loadHTML( $source, LIBXML_NOERROR );

		foreach ( $tmpDoc->getElementsByTagName( 'body' )->item( 0 )->childNodes as $node ) {
			$node = $parent->ownerDocument->importNode( $node, true );

			$parent->appendChild( $node );
		}
	}

    public static function get_dom( $content )
	{
		$dom = new DOMDocument();

		$dom->loadHTML( $content, LIBXML_NOERROR );

		return $dom;
	}

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( './/*[contains(@class, \'' . self::CSS_CLASS[ 'container' ] . '\')]' );

		return $nodes;
	}

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-pros-cons.php';

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE, false, $args );

        $output = ob_get_clean();

        return $output;
    }

	const CSS_CLASS = [
		'container' => 'legal-pros-cons',

		'pros-item' => 'pros-cons-item',

		'pros' => 'legal-pros',

		'cons' => 'legal-cons',

		'title' => 'legal-title',

		'content' => 'legal-content',
	];

    public static function style_formats_pros( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Pros & Cons',

				'items' => [
					[
						'title' => 'Pros Title',
						
						'selector' => 'p',

						'classes' => self::CSS_CLASS[ 'container' ] . ' ' . self::CSS_CLASS[ 'title' ] . ' ' . self::CSS_CLASS[ 'pros' ],
					],

					[
						'title' => 'Cons Title',
						
						'selector' => 'p',

						'classes' => self::CSS_CLASS[ 'container' ] . ' ' . self::CSS_CLASS[ 'title' ] . ' ' . self::CSS_CLASS[ 'cons' ],
					],

					[
						'title' => 'Pros & Cons Content',
						
						'selector' => 'ul',

						'classes' => self::CSS_CLASS[ 'container' ] . ' ' . self::CSS_CLASS[ 'content' ],
					],
				],
			],
		] );
	}
}

?>