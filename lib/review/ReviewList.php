<?php

class ReviewList
{
    const CSS = [
        'review-list' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-list.css',

            'ver' => '1.0.4',
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
    }

    public static function inline_style()
    {
		$style = [];

		$nodes = self::get_lists();

		if ( empty( $nodes ) )
        {
			return '';
		}

        // LegalDebug::debug( [
        //     'nodes' => $nodes,
        // ] );

		foreach ( $nodes as $node )
        {
            $items = self::get_data( $node );

            LegalDebug::debug( [
                'items' => $items,
            ] );

            foreach ( $items as $id => $item )
            {
                // url( '../../img/review/review-ul.svg' )
                $style[] = '.' . self::CLASSES[ 'base' ] . ' li:nth-child( ' . ( $id + 1 ) . ' ) { background-image: url( \'' . LegalMain::LEGAL_URL . 'assets/img/review/list/list-' . $item[ 'label' ] . '.svg\' ); }';
            }
		}

		return implode( ' ', $style );
	}

    public static function get_data( $node )
    {
        $items = [];

        $elements = $node->getElementsByTagName( 'li' );
        
        if ( $elements->length != 0 )
        // if ( $node->hasChildNodes() )
        {
            foreach ( $elements as $element )
            {
                // LegalDebug::debug( [
                //     'element' => $element,
                // ] );

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