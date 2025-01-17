<?php

class ReviewList
{
    const CSS = [
        'review-list' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-list.css',

            'ver' => '1.2.8',
        ],
    ];

    const CSS_NEW = [
        'review-list' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-list-new.css',

            'ver' => '1.0.4',
        ],
    ];

    const CSS_LIST_ICONS = [
        'review-list-icons' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-list-icons.css',

            'ver' => '1.0.2',
        ],

        'legal-template-font-mc-icons-sports' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons-sports.css',

			'ver' => '1.0.2',
		],
    ];

    const SELCTORS = [
		'list' => '<li',
	];

    public static function check_contains_list()
    {
        return self::check_contains_list_default()
        
            || ReviewListHowTo::check_contains_list_howto();
    }

    public static function check_contains_list_default()
    {
        return LegalComponents::check_contains( self::SELCTORS[ 'list' ] );
    }

    public static function check_contains_list_icons()
    {
        return LegalComponents::check_contains( self::CLASSES[ 'base' ] );
    }

    public static function register_style()
    {
        if ( TemplateMain::check_new() ) 
        {
            if ( self::check_contains_list() )
            {
                ReviewMain::register_style( self::CSS_NEW );
            }

            if ( self::check_contains_list_icons() )
            {
                ReviewMain::register_style( self::CSS_LIST_ICONS );
            }
        }
        else
        {
            ReviewMain::register_style( self::CSS );
        }
    }

    public static function register_inline_style()
    {
        ReviewMain::register_inline_style( self::CLASSES[ 'base' ], self::inline_style() );
    }

    public static function register_functions()
	{
		$handler = new self();

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_list' ] );
	}

    public static function register()
    {
        if ( self::check_contains_list() )
        {
            $handler = new self();
    
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    
            if ( !TemplateMain::check_new() )
            {
                add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
            }
    
            add_filter( 'the_content', [ $handler, 'get_content' ] );
        }
    }

    public static function inline_style()
    {
        if ( !ReviewMain::check() ) {
            return '';
        }

		$style = [];

		$nodes = self::get_lists();

		if ( empty( $nodes ) )
        {
			return '';
		}

		foreach ( $nodes as $node_id => $node )
        {
            $node_class = '.' . self::CLASSES[ 'base' ] . '-' . $node_id;

            $elements = self::get_data( $node );

            foreach ( $elements as $element_id => $element )
            {
                $element_class = '.' . self::CLASSES[ 'item' ] . '-' . $element_id;
                
                $style[] = $node_class . ' ' . $element_class . '::before { background-image: url( \'' . LegalMain::LEGAL_URL . '/assets/img/review/list/list-' . $element[ 'label' ] . '.svg\' ); }';
            }
		}

		return implode( ' ', $style );
	}

    public static function get_label( $node )
    {
        $label = strtolower( $node->textContent );

        // $label = ToolLoco::__( $label, ToolLoco::TEXTDOMAIN, 'en' );
        
        $label = ToolLoco::translate_locale( $label, 'en' );

        return str_replace( [ ' ', '/' ], '-', $label );
    }

    public static function get_data( $node )
    {
        $items = [];

        $elements = $node->getElementsByTagName( 'li' );
        
        if ( $elements->length != 0 )
        {
            foreach ( $elements as $element )
            {
                // $label = strtolower( $element->textContent );

                // $label = ToolLoco::__( $label, ToolLoco::TEXTDOMAIN, 'en' );

                // $label = str_replace( [ ' ', '/' ], '-', $label );

                // $items[] = [
                //     'label' => $label,
                // ];

                $items[] = [
                    'label' => self::get_label( $element ),
                ];
            }
        }

        return $items;
    }

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

        // return $xpath->query( './/ul[contains(@class, \'' . self::CLASSES[ 'base' ] . '\')]' );
        
        return $xpath->query( '//ul[contains(@class, \'' . self::CLASSES[ 'base' ] . '\')]' );
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
		};

		$dom = LegalDOM::get_dom( $content );

        $nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		foreach ( $nodes as $node_id => $node )
        {
            // $node_class = $node->getAttribute( 'class' ) . ' ' . self::CLASSES[ 'base' ] . '-' . $node_id;

            $node_class = implode(
                ' ',

                [
                    $node->getAttribute( 'class' ),

                    self::CLASSES[ 'base' ] . '-' . $node_id,
                ]
            );

            $node->setAttribute( 'class', $node_class );

            $elements = $node->getElementsByTagName( 'li' );
        
            if ( $elements->length != 0 )
            {
                foreach ( $elements as $element_id => $element )
                {
                    // $element_class = self::CLASSES[ 'item' ] . '-' . $element_id;

                    $element_class = implode(
                        ' ',
        
                        [
                            self::CLASSES[ 'item' ] . '-' . $element_id,
        
                            'icon-' . self::get_label( $element ),
                        ]
                    );

                    $element->setAttribute( 'class', $element_class );
                } 
            }
		}

		return $dom->saveHTML( $dom );
	}

    const CLASSES = [
        'list-2' => 'legal-list-2',

        'list-3' => 'legal-list-3',

        'list-4' => 'legal-list-4',

        'base' => 'legal-list-image',

        'item' => 'list-image-item',

        'pros' => 'legal-list-pros',

        'cons' => 'legal-list-cons',
    ];

    public static function style_formats_list( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'List',

				'items' => [
					[
						'title' => 'List 2 Columns',
						
						'selector' => 'ul,ol',

						'classes' => self::CLASSES[ 'list-2' ],
					],

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

					[
						'title' => 'List Pros',
						
						'selector' => 'ul',

						'classes' => self::CLASSES[ 'pros' ],
					],

					[
						'title' => 'List Cons',
						
						'selector' => 'ul',

						'classes' => self::CLASSES[ 'cons' ],
					],
				],
			],
		] );
	}
}

?>