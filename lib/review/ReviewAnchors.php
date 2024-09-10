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

			'ver' => '1.0.0',
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
        // 'legal-swiper-lib' => [
        //     // 'path' => 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            
        //     'path' => LegalMain::LEGAL_URL . '/assets/js/review/swiper-bundle.min.js',

        //     'ver' => '1.0.0',
        // ],
        
        'legal-swiper-lib' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-swiper.js',

            'ver' => '1.0.0',
        ],

        'review-anchors-new' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-anchors-new.js',

            'ver' => '1.0.0',

            'deps' => 'legal-swiper-lib',
        ],
    ];


  /*   public static function register_script()
    {
        ReviewMain::register_script( self::JS );
    } */

    public static function register_script()
    {
		if ( TemplateMain::check_new() )
		{
			ReviewMain::register_script( self::JS_NEW );
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
    }

    public static function modify_content( $content )
	{
		$dom = LegalDOM::get_dom( $content ); 

		self::set_header_id( $dom );

		return $dom->saveHTML( $dom );
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
    
    const ANCHORS = [
        'id' => 'anchor-id',

        'label' => 'anchor-label',
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
                'href' => '#' . $node->getAttribute( 'id' ),

                'label' => $label,
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

    public static function get()
    {
        $nodes = self::get_anchors();

        $items = self::get_data( $nodes );

        return [
            'title' => __( ReviewMain::TEXT[ 'page-contents' ], ToolLoco::TEXTDOMAIN ) . ':',

            'items' => $items,
        ];
    }

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
        if ( !ReviewMain::check() )
        {
            return '';
        }

        // if ( self::check_contains() )
        // {
        //     return '';
        // }

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