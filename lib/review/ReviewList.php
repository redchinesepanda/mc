<?php

class ReviewList
{
    const CSS = [
        'review-list' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-list.css',

            'ver' => '1.0.5',
        ],
    ];

    public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    }

    public static function register_inline_style()
    {
		if ( ReviewMain::check() ) {
			ToolEnqueue::register_inline_style( self::CLASSES[ 'base' ], self::inline_style() );
		}
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_list' ] );

        add_filter( 'the_content', [ $handler, 'get_content' ] );
    }

    public static function inline_style()
    {
		$style = [];

		$nodes = self::get_lists();

		if ( empty( $nodes ) )
        {
			return '';
		}

        LegalDebug::debug( [
            '$nodes' => $nodes,
        ] );

		foreach ( $nodes as $node_id => $node )
        {
            $items = self::get_data( $node );

            foreach ( $items as $item_id => $item )
            {
                $style[] = '.' . self::CLASSES[ 'base' ] . ':nth-of-type( ' . ( $node_id + 1 ) . ' ) li:nth-child( ' . ( $item_id + 1 ) . ' )::before { background-image: url( \'' . LegalMain::LEGAL_URL . '/assets/img/review/list/list-' . $item[ 'label' ] . '.svg\' ); }';
            }
		}

		return implode( ' ', $style );
	}

    public static function get_data( $node )
    {
        $items = [];

        $elements = $node->getElementsByTagName( 'li' );
        
        if ( $elements->length != 0 )
        {
            foreach ( $elements as $element )
            {
                $label = strtolower( $element->textContent );

                $label = ToolLoco::__( $label, ToolLoco::TEXTDOMAIN, 'en' );

                $label = str_replace( ' ', '-', $label );

                $items[] = [
                    'label' => $label,
                ];
            }
        }

        return $items;
    }

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

        return $xpath->query( './/ul[contains(@class, \'' . self::CLASSES[ 'base' ] . '\')]' );
	}

    public static function get_lists()
    {
        $post = get_post();

		if ( empty( $post ) ) {
			return [];
		}

		$dom = LegalDOM::get_dom( $post->post_content );

        return self::get_nodes( $dom );
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

		// $item = null;

		// $last = $nodes->length - 1;

        // $args = [];

        // $container = $dom->createElement( 'div' );

        // $container->setAttribute( 'class', self::CSS_CLASS[ 'container' ] );

		foreach ( $nodes as $node_id => $node )
        {
            $elements = $node->getElementsByTagName( 'li' );
        
            if ( $elements->length != 0 )
            {
                foreach ( $elements as $element_id => $element )
                {
                    $class = self::CSS_CLASS[ 'base' ] . '-' . $node_id . '-' . $element_id;

                    $element->setAttribute( 'class', $class );

                    // $label = strtolower( $element->textContent );
    
                    // $label = ToolLoco::__( $label, ToolLoco::TEXTDOMAIN, 'en' );
    
                    // $label = str_replace( ' ', '-', $label );
    
                    // $items[] = [
                    //     'label' => $label,
                    // ];
                }
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

    const CLASSES = [
        'list-3' => 'legal-list-3',

        'list-4' => 'legal-list-4',

        'base' => 'legal-list-image',
    ];

    public static function style_formats_list( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'List',

				'items' => [
					[
						'title' => 'List 3 Columns',
						
						'selector' => 'ul,ol',

						'classes' => self::CLASSES[ 'list-3' ],
					],
					[
						'title' => 'List 4 Columns',
						
						'selector' => 'ul,ol',

						'classes' => self::CLASSES[ 'list-4' ],
					],
					[
						'title' => 'List With Image',
						
						'selector' => 'ul',

						'classes' => self::CLASSES[ 'base' ],
					],
				],
			],
		] );
	}
}

?>