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

        // [legal-pros-cons]

        // add_shortcode( 'legal-pros-cons', [ $handler, 'render' ] );

        add_filter( 'the_content', [ $handler, 'get_content' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_pros' ] );
    }

	public static function get_content( $content )
	{
		$dom = self::get_dom( get_the_content() );

        $nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		$item = null;

		// $replace = null;

		$last = $nodes->length - 1;

        $args = [];

        $container = $dom->createElement( 'div' );

        $container->setAttribute( 'class', self::CSS_CLASS[ 'pros' ] );

		foreach ( $nodes as $id => $node ) {

			$class = $node->getAttribute( 'class' );

			$permission_title = (
                ( strpos( $class, self::CSS_CLASS[ 'title-pros' ] ) !== false ) ||

                ( strpos( $class, self::CSS_CLASS[ 'title-cons' ] ) !== false )
            );

			$permission_list = (
                ( strpos( $class, self::BONUS_CLASS[ 'list-pros' ] ) !== false ) ||

                ( strpos( $class, self::BONUS_CLASS[ 'list-cons' ] ) !== false )
            );

			$permission_first = ( $id == 0 );

			$permission_last = ( $id == $last );

			if ( $permission_first ) {
                $node->insertBefore( $container );
            }

			if ( !empty( $item ) && ( $permission_title || $permission_last ) ) {
				
				self::appendHTML( $item, self::render( $args ) );

                $container->appendChild( $item );

				// $node->parentNode->replaceChild( $item, $replace );
			}

			if ( $permission_title ) {

				$item = $dom->createElement( 'div' );

                $class = self::CSS_CLASS[ 'title-pros' ];

                if ( strpos( $node->getAttribute( 'class' ), self::CSS_CLASS[ 'title-cons' ] ) !== false ) {
                    $class = self::CSS_CLASS[ 'title-cons' ];
                }

				$item->setAttribute( 'class', self::CSS_CLASS[ 'pros-item' ] . ' ' . $class );

				$args = [];
				
				$args[ 'title' ] = ToolEncode::encode( $node->textContent );

				// $replace = $node;
			}

			if ( $permission_description ) {
				// $args[ 'description' ] = ToolEncode::encode( $node->textContent );

                $args[ 'description' ] = $dom->saveHTML( $node );
			}

            $node->parentNode->removeChild( $node );
		}

		return $dom->saveHTML();
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

		$nodes = $xpath->query( './/*[contains(@class, \'' . self::CSS_CLASS[ 'pros' ] . '\')]' );

		return $nodes;
	}

    // public static function get_pros()
    // {
    //     $dom = self::get_dom( get_the_content() );

    //     $nodes = self::get_nodes( $dom );

    //     return $nodes;
    // }

    // public static function get()
    // {
    //     // $repeater = get_field( self::FIELD );
        
    //     $args = [];

    //     $nodes = self::get_pros();

    //     $items = self::get_data( $nodes );

    //     // if( $repeater ) {
    //     //     foreach ( $repeater as $item ) {
    //     //         $args[] = [
    //     //             'type' => $item[ self::GROUP ][ self::ITEM_TYPE ],

    //     //             'title' => $item[ self::GROUP ][ self::ITEM_TITLE ],

    //     //             'description' => $item[ self::GROUP ][ self::ITEM_DESCRIPTION ],
    //     //         ];
    //     //     }
    //     // }

    //     return $args;
    // }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-pros-cons.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

	const CSS_CLASS = [
		'pros' => 'legal-pros-cons',

		'pros-item' => 'legal-pros-cons-item',

		'title-pros' => 'legal-title-pros',

		'title-cons' => 'legal-title-cons',

		'content' => 'legal-pros-cons-content',
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

						'classes' => self::CSS_CLASS[ 'pros' ] . ' ' . self::CSS_CLASS[ 'title-pros' ],
					],

					[
						'title' => 'Cons Title',
						
						'selector' => 'p',

						'classes' => self::CSS_CLASS[ 'pros' ] . ' ' . self::CSS_CLASS[ 'title-pros' ],
					],

					[
						'title' => 'Pros List',
						
						'selector' => 'ul',

						'classes' => self::CSS_CLASS[ 'pros' ] . ' ' . self::CSS_CLASS[ 'list-pros' ],
					],

					[
						'title' => 'Cons List',
						
						'selector' => 'ul',

						'classes' => self::CSS_CLASS[ 'pros' ] . ' ' . self::CSS_CLASS[ 'list-cons' ],
					],
				],
			],
		] );
	}
}

?>