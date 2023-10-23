<?php

class ReviewAnchors
{
    const CSS = [
        'review-anchors' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-anchors.css',

            'ver' => '1.0.4',
        ],
    ];

    public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    }

    const JS = [
        'review-anchors' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-anchors.js',

            'ver' => '1.0.1',
        ],
    ];

    public static function register_script()
    {
        ReviewMain::register_script( self::JS );
    }

    public static function register_admin_script()
    {
        ToolEnqueue::register_inline_script( 'legal-anchors-data', self::anchors_data() );
    }

    public static function register_functions()
    {
        $handler = new self();

        add_action( 'admin_enqueue_scripts', [ $handler, 'register_admin_script' ] );
    }

    public static function register()
    {
        $handler = new self();

        // [legal-anchors]

        add_shortcode( 'legal-anchors', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
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

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );
		
        // $nodes = $xpath->query( ".//a[@id and not(contains(@id, 'legal-'))]" ); 
        
        $nodes = $xpath->query( "//a[@id and not(contains(@id, 'legal-'))]" ); 

		return $nodes;
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

        if ( !empty( $details ) && !is_wp_error( $details ) ) {
            $locale = $details[ 'locale' ];
        }

        $anchors = [];

        foreach ( self::TEXT_ANCHORS as $id => $label )
        {
            $anchors[ ToolTransiterate::replace(
                ToolLoco::__( $id, ToolLoco::TEXTDOMAIN, $locale )
            ) ] = ToolLoco::__( $label, ToolLoco::TEXTDOMAIN, $locale );
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

        foreach ( $nodes as $node ) {
            $label = '';

            if ( !empty( $labels[ $node->getAttribute( 'id' ) ] ) ) {
                $label = $labels[ $node->getAttribute( 'id' ) ];
            } else {
                $label = $node->parentNode->textContent;
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

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-anchors.php';

    public static function render()
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }
        
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>