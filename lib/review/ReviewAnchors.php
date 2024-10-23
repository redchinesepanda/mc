<?php

class ReviewAnchors
{
    const CSS = [
        'review-anchors' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-anchors.css',

            'ver' => '1.0.4',
        ],
    ];

    const CSS_NEW = [
        'review-anchors-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-anchors-new.css',

			'ver' => '1.0.1',
		],

        // подключение свайпера начало
        
        'review-swiper-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-swiper-new.css',

			'ver' => '1.0.0',
		],

        // подключение свайпера конец

        'review-anchors-to-top' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-anchors-to-top.css',

			'ver' => '1.0.0',
		],

    ];

/*     public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    } */

    public static function register_style()
    {
		if ( TemplateMain::check_new() )
		{
			ReviewMain::register_style( self::CSS_NEW );
		}
		else
		{
			ReviewMain::register_style( self::CSS );
		}
    }

    const JS = [
        'review-anchors' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-anchors.js',

            'ver' => '1.0.3',
        ],
    ];

    const JS_NEW = [
        'legal-swiper-lib' => [
            // 'path' => 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/swiper-bundle.min.js',

            'ver' => '1.0.1',
        ],
        
        // 'legal-swiper-lib' => [
        //     'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-swiper.js',

        //     'ver' => '1.0.0',
        // ],

        'review-anchors-new' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-anchors-new.js',

            'ver' => '1.0.2',

            'deps' => 'legal-swiper-lib',
        ],
    ];

    // public static function get_localize()
	// {
	// 	return [
	// 		'legal-swiper-lib' => [
	// 			'object_name' => 'mcSwiperLib',
	
	// 			'data' => [
	// 				'src' => LegalMain::LEGAL_URL . '/assets/js/review/swiper-bundle.min.js',
	// 			],
	// 		],
	// 	];
	// }


  /*   public static function register_script()
    {
        ReviewMain::register_script( self::JS );
    } */

    public static function register_script()
    {
		if ( TemplateMain::check_new() )
		{
			ReviewMain::register_script( self::JS_NEW );

            // ToolEnqueue::localize_script( self::get_localize() );
		}
		else
		{
			ReviewMain::register_script( self::JS );
		}
    }

    public static function register_admin_script()
    {
        ToolEnqueue::register_inline_script( 'legal-anchors-data', self::anchors_data() );
    }

    public static function register_functions()
    {
        if ( ACFMain::check_functions() )
        {
            $handler = new self();
    
            add_action( 'admin_enqueue_scripts', [ $handler, 'register_admin_script' ] );
        }
    }

    public static function register()
    {
        $handler = new self();

        // [legal-anchors]

        add_shortcode( 'legal-anchors', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_filter( 'the_content', [ $handler, 'modify_content' ] );

        // LegalDebug::debug( [
        //     'ReviewAnchors' => 'register-1',

        //     'get_args_auto' => self::get_args_auto(),
        // ] );
    }

    public static function modify_content( $content )
	{
		$dom = LegalDOM::get_dom( $content ); 

        $set_title_id_auto = false;

		$set_title_id_manual = self::set_header_id( $dom );

        // if ( ! $set_title_id_manual )
        // {
		//     $set_title_id_auto = self::set_titles_id_auto( $dom );
        // }

        // if ( $set_title_id_manual || $set_title_id_auto )
        
        if ( $set_title_id_manual )
        {
		    return $dom->saveHTML( $dom );
        }

        return $content;
	}

    public static function set_header_id( $dom )
	{
		$nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 )
		{
			return false;
		}

		foreach ( $nodes as $node )
		{
			if ( $node->parentNode )
            {
                $id = $node->getAttribute( 'id' );

                $node->removeAttribute( 'id' );

                $node->parentNode->setAttribute( 'id', $id );

                try
                {
                    $node->parentNode->removeChild( $node );
                }
                catch ( DOMException $e )
                {
                    LegalDebug::debug( [
                        'ReviewAnchors' => 'set_header_id',

                        'node' => substr( $node->textContent, 0, 30 ),

                        'message' => $e->getMessage(),
                    ] );
                }
            }
		}

		return true;
	}

	public static function anchors_data()
	{
		$labels = self::get_labels();

        $custom = self::get_custom();

        if ( !empty( $custom ) ) {
            $labels = array_merge( $labels, $custom );
        }

        $keys = array_keys( $labels );

        sort( $keys );

		return $keys;
	}

	// public static function get_nodes( $dom )
	// {
	// 	$xpath = new DOMXPath( $dom );
		
    //     // $nodes = $xpath->query( ".//a[@id and not(contains(@id, 'legal-'))]" ); 
        
    //     $nodes = $xpath->query( "//a[@id and not(contains(@id, 'legal-'))]" ); 

	// 	return $nodes;
	// }

	public static function remove_nodes_anchors( $dom )
	{
		$nodes = self::get_nodes_titles_auto( $dom );
		
        // $nodes = self::get_nodes( $dom );

        if ( $nodes->length == 0 )
		{
			return false;
		}

        foreach ( $nodes as $node )
        {
            $anchor = $node->getElementsByTagName( 'a' )->item( 0 );

            if ( $anchor )
            {
                $node->removeChild( $anchor );

                // $anchor->parentNode->removeChild( $anchor );
            }

            // LegalDebug::debug( [
            //     'ReviewAnchors' => 'remove_nodes_anchors-1',

            //     'id' => $anchor->getAttribute( 'id' ),

            //     'html' => $dom->saveHTML( $node ),
            // ] );
        }

        // LegalDebug::die( [
        //     'ReviewAnchors' => 'remove_nodes_anchors-1',
        // ] );

        return true;
	}

	public static function get_nodes( $dom )
	{
		return LegalDOM::get_nodes( $dom, "//a[@id and not(contains(@id, 'legal-'))]" );
	}

    const TEXT_ANCHORS = [
        'app' => 'App',

        'android' => 'Android',

        'basic-information' => 'Basic facts',

        'betting' => 'Betting',

        'bonuses' => 'Bonuses',

        'casino' => 'Casino',
        
        'common-problems' => 'Common problems',
        
        'compare' => 'Compare',

        'deposit' => 'Deposit',
        
        'faqs' => 'FAQs',
        
        'how-to-bet' => 'How to bet',
        
        'how-to-get' => 'How to get',
        
        'how-to-sign-up' => 'Sign up',
        
        'how-to-use' => 'How to use',
        
        'in-play-betting' => 'In play betting',

        'ios' => 'iOS',

        'key-features' => 'Key features',
        
        'odds' => 'Odds',
        
        'offers' => 'Offers',
        
        'other-bonuses' => 'Other bonuses',
        
        'payment-methods' => 'Payment',

        'place-a-bet' => 'Place a bet',
        
        'promotions' => 'Promotions',
        
        'pros-and-cons' => 'Pros & cons',
        
        'registration' => 'Registration',
        
        'review' => 'Review',
        
        'security' => 'Security',

        'sign-up-offer' => 'Sign up offer',
        
        'sports' => 'Sports',
        
        'sports-and-markets' => 'Sports & Markets',
        
        'tips-and-tricks' => 'Tips and tricks',
    ];

    public static function get_labels()
    {
        $locale = WPMLMain::get_locale();

        $details = WPMLMain::get_post_language_details();

        if ( !empty( $details ) && !is_wp_error( $details ) )
        {
            $locale = $details[ 'locale' ];
        }

        $anchors = self::TEXT_ANCHORS;

        foreach ( self::TEXT_ANCHORS as $id => $label )
        {
            $label_translated = ToolLoco::translate_locale( $label, $locale );

            if ( !empty( $label_translated ) )
            {
                $id_translated = ToolLoco::translate_locale( $id, $locale );
    
                $id_ready = ToolTransiterate::replace( $id_translated );
    
                $anchors[ $id_ready ] = $label_translated;
            }
        }

        return $anchors;
    }

    const FIELD = [
        'about' => 'review-about',

        'anchors' => 'review-anchors',
    ];

    const FIELD_KEY = [
        'anchors' => 'field_64818a563fb23',
    ];
    
    const ANCHORS = [
        'id' => 'anchor-id',

        'label' => 'anchor-label',
    ];

    const ANCHORS_KEY = [
        'id' => 'field_64818a723fb24',

        'label' => 'field_64818a8b3fb25',
    ];

    public static function get_custom()
    {
        $customs = get_field( self::FIELD[ 'anchors' ] );

        $items = [];

        if ( $customs ) {
            foreach ( $customs as $custom ) {
                $items[ $custom[ self::ANCHORS[ 'id' ] ] ] = $custom[ self::ANCHORS[ 'label' ] ];
            }
        }

        return $items;
    }

    public static function get_data( $nodes )
    {
        $labels = self::get_labels();

        $custom = self::get_custom();

        if ( !empty( $custom ) ) {
            $labels = array_merge( $labels, $custom );
        }

        $items = [];

        foreach ( $nodes as $node )
        {
            $label = '';

            if ( !empty( $labels[ $node->getAttribute( 'id' ) ] ) )
            {
                $label = $labels[ $node->getAttribute( 'id' ) ];
            }
            else
            {
                // $label = $node->parentNode->textContent;
                
                // $label = mb_substr( $node->parentNode->textContent, 0, 30 ); 
                
                // $label = mb_substr( $node->nextSibling->textContent, 0, 30 );

                if ( !empty( $node->nextSibling ) && $node->nextSibling->nodeType == XML_TEXT_NODE )
                {
                    $label = $node->nextSibling->textContent;
                }
            }

            $items[] = [
                'label' => $label,

                'href' => '#' . $node->getAttribute( 'id' ),
            ];
        }

        return $items;
    }

    public static function get_anchors()
    {
        $post = get_post();

		if ( empty( $post ) ) {
			return [];
		}

		$dom = LegalDOM::get_dom( $post->post_content );

        $nodes = self::get_nodes( $dom );

        return $nodes;
    }

    public static function get_items()
    {
        $nodes = self::get_anchors();

        $items = self::get_data( $nodes );

        // if ( empty( $items ) )
        // {
        //     $nodes = self::get_titles_auto();

        //     return self::get_titles_data( $nodes );
        // }

        return $items;
    }

    public static function get()
    {
        // $nodes = self::get_anchors();

        // $items = self::get_data( $nodes );

        // if ( empty( $items ) )
        // {
        //     $nodes = self::get_titles_auto();

        //     $items = self::get_titles_data( $nodes );
        // }

        $items = self::get_items();

        return [
            'title' => __( ReviewMain::TEXT[ 'page-contents' ], ToolLoco::TEXTDOMAIN ) . ':',

            'items' => $items,
        ];
    }

    // anchors auto start

    public static function set_titles_id_auto( $dom )
	{
        $nodes = self::get_nodes_titles_auto( $dom );

		if ( $nodes->length == 0 )
		{
			return false;
		}

		foreach ( $nodes as $index => $node )
		{
			if ( $node->parentNode )
            {
                $node_id = self::get_title_id_auto( $node, $index );

                $anchor = $dom->createElement( 'a' );

                // $node->setAttribute( 'id', $node_id );
                
                $anchor->setAttribute( 'id', $node_id );

                // LegalDebug::debug( [
                //     'ReviewAnchors' => 'set_titles_id_auto-1',

                //     'node' => $node,
                // ] );

                $node->insertBefore( $anchor, $node->firstChild );
            }
		}

		return true;
	}

    // const PATTERN = [
    //     'node-id' => 'anchor-%s-%s',
    // ];

    public static function get_title_id_auto( $node, $index = null )
    {
        $label = ReviewTitle::replace_placeholder( $node->textContent );

        $node_id = ToolTransiterate::replace( $label );

        $node_id = mb_strtolower( $node_id );

        $node_id = str_replace( ' ', '-', $node_id );

        if ( function_exists( 'cyr_to_lat' ) )
        {
            $node_id = cyr_to_lat()->transliterate( $node_id );
        }

        // LegalDebug::debug( [
        //     'ReviewAnchors' => 'get_title_id_auto-1',

        //     'node_id' => $node_id,
        // ] );

        $node_id = preg_replace( '/--+/', '-', $node_id );

        $node_id = trim( $node_id, '-' );

        // LegalDebug::debug( [
        //     'ReviewAnchors' => 'get_title_id_auto-2',

        //     'node_id' => $node_id,
        // ] );

        // if ( ! is_null( $index ) )
        // {
        //     // $node_id = 'anchor-' . $index . '-' . $node_id,
            
        //     $node_id = sprintf( self::PATTERN[ 'node-id' ], $index, $node_id );
        // }

        return $node_id;
    }

    public static function get_titles_data( $nodes )
    {
        $items = [];

        foreach ( $nodes as $index =>  $node )
        {
            $label = ReviewTitle::replace_placeholder( $node->textContent );

            $node_id = self::get_title_id_auto( $node, $index );

            // $node_id = $node->getAttribute( 'id' );

            // LegalDebug::debug( [
            //     'ReviewAnchors' => 'get_titles_data-1',
                
            //     'label' => $label,

            //     'node_id' => $node_id,
            // ] );

            $items[] = [
                'label' => $label,

                'href' => '#' . $node_id,
            ];
        }

        // LegalDebug::debug( [
        //     'ReviewAnchors' => 'get_titles_data-2',

        //     'items' => $items,
        // ] );

        return $items;
    }

	public static function get_nodes_titles_auto( $dom )
	{
		return LegalDOM::get_nodes( $dom, "//h2" );
	}
    
    public static function get_titles_auto( $post_id = null )
    {
        $post = get_post( $post_id );

		if ( empty( $post ) ) {
			return [];
		}

		$dom = LegalDOM::get_dom( $post->post_content );

        $nodes = self::get_nodes_titles_auto( $dom );

        return $nodes;
    }

    public static function get_items_auto( $post_id = null )
    {
        $titles_nodes = self::get_titles_auto( $post_id );

        return self::get_titles_data( $titles_nodes );
    }

    public static function get_args_auto( $post_id = null )
    {
        // $titles_nodes = self::get_titles_auto( $post_id );

        // $titles_data = self::get_titles_data( $titles_nodes );

        $items = self::get_items_auto( $post_id );

        return [
            'title' => __( ReviewMain::TEXT[ 'page-contents' ], ToolLoco::TEXTDOMAIN ) . ':',

            // 'items' => $titles_data,
           
            'items' => $items,
        ];
    }

    // anchors auto end

    const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/review/review-anchors.php',

        'block' => LegalMain::LEGAL_PATH . '/template-parts/review/review-anchors-block.php',
    ];

    public static function check_contains()
    {
        return CompilationTabs::check_contains_tabs() || BonusPreview::check_contains_bonus();
    }

    public static function render()
    {
        if ( ! ReviewMain::check() )
        {
            return '';
        }

        // if ( self::check_contains() )
        // {
        //     return '';
        // }

        // self::get_args_auto();

        return LegalComponents::render_main( self::TEMPLATE[ 'main' ], self::get() );
    }

    public static function render_section()
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }

        if ( self::check_contains() )
        {
            return '';
        }

        return LegalComponents::render_main( self::TEMPLATE[ 'main' ], self::get() );
    }

    public static function render_block()
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }

        return LegalComponents::render_main( self::TEMPLATE[ 'block' ], self::get() );
    }

    // public static function render()
    // {
    //     if ( !ReviewMain::check() )
    //     {
    //         return '';
    //     }
        
    //     ob_start();

    //     load_template( self::TEMPLATE[ 'new' ], false, self::get() );

    //     $output = ob_get_clean();

    //     return $output;
    // }
}

?>