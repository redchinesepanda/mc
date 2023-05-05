<?php

class ReviewFAQ
{
    const CSS = [
        'review-faq' => LegalMain::LEGAL_URL . '/assets/css/review/review-faq.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    const JS = [
        'review-faq' => LegalMain::LEGAL_URL . '/assets/js/review/review-faq.js',
    ];

    public static function register_script()
    {
        foreach ( self::JS as $name => $path ) {
            wp_register_script( $name, $path, [], false, true );

            wp_enqueue_script( $name );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    // const FIELD = 'review-faq';

    // const ITEM_TITLE = 'item-title';

    // const ITEM_CONTENT = 'item-content';

    // public static function get()
    // {
    //     $faqs = get_field( self::FIELD );
        
    //     if ( $faqs ) {
	// 		foreach( $faqs as $key => $faq ) {
	// 			$args[] = [
	// 				'title' => $faq[ self::ITEM_TITLE ],

	// 				'content' => $faq[ self::ITEM_CONTENT ],
	// 			];
	// 		}

	// 		return $args;
	// 	}

    //     return [];
    // }

    // const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-faq.php';

    // public static function render()
    // {
    //     ob_start();

    //     load_template( self::TEMPLATE, false, self::get() );

    //     $output = ob_get_clean();

    //     return $output;
    // }

    public static function schema()
    {
        return [
            "@type" => "FAQPage",

            "mainEntity" => self::get_schema_data(),

            // "mainEntity" => [
            //     [
            //         "@type" => "Question",

            //         "name" => "What's the best betting site in Nigeria in 2022?",

            //         "acceptedAnswer" => [
            //             "@type" => "Answer",

            //             "text" => "Every bookmaker has advantages compared to the competitors: high odds, a wide range of markets, good bonus offers, e-sports betting, fast withdrawal and so on. On this page we have highlighted the best betting sites and reputable bookies based on the most important criteria. Still it`s up to you to decide which aspects are more important and which bookmaker is the best.",
            //         ]
            //     ],
            // ],
        ];
    }
    
    const CSS_CLASS = [
        'base' => 'legal-faq',

        'title' => 'legal-faq-title',

        'description' => 'legal-faq-description',
    ];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		return $xpath->query( './/*[contains(@class, \'' . self::CSS_CLASS[ 'base' ] . '\')]' );
	}

    public static function get_schema_data()
	{
        if ( !ReviewMain::is_front() ) {
			return [];
		}

        $post = get_post();

        if ( empty( $post ) ) {
            return [];
        }

		$dom = LegalDOM::get_dom( $post->post_content );

        $nodes = self::get_nodes( $dom );

        LegalDebug::debug( [
            '$nodes' => $nodes,
        ] );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		$items = [];

		$last = $nodes->length - 1;

		foreach ( $nodes as $id => $node ) {
            $class = explode( ' ', $node->getAttribute( 'class' ) );

			$permission_title = ( in_array( self::CSS_CLASS[ 'title' ], $class ) );

			$permission_description = ( in_array( self::CSS_CLASS[ 'description' ], $class ) );

			$permission_last = ( $id == $last );

			if ( !empty( $item ) && $permission_description ) {
                // $item[ 'acceptedAnswer' ][ 'text' ] = [
                //     // '@type' => 'Answer',

                //     // 'text' =>  preg_replace( '/\s\s+/', '', ToolEncode::encode( $node->textContent ) ),
                    
                //     'text' =>  ToolEncode::encode( $dom->saveHTML( $node ) ),
                // ];

                $item[ 'acceptedAnswer' ][ 'text' ] += ToolEncode::encode( $dom->saveHTML( $node ) );
			}

			if ( !empty( $item ) && ( $permission_title || $permission_last ) ) {
                $items[] = $item;

                $item = null;
			}

			if ( $permission_title ) {
                $item = [
                    '@type' => 'Question',

                    'name' => ToolEncode::encode( $node->textContent ),

                    'acceptedAnswer' => [
                        '@type' => 'Answer',

                        'text' => '',
                    ]
                ];
			}
		}

		return $items;
	}

}

?>