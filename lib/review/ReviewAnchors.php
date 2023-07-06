<?php

class ReviewAnchors
{
    const CSS = [
        'review-anchors' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-anchors.css',

            'ver' => '1.0.3',
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

    public static function register()
    {
        $handler = new self();

        // [legal-anchors]

        add_shortcode( 'legal-anchors', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_action( 'admin_enqueue_scripts', [ $handler, 'register_admin_script' ] );
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

		$nodes = $xpath->query( './/a[@id]' );

		return $nodes;
	}

    public static function get_labels()
    {
        $locale = WPMLMain::get_locale();

        $details = WPMLMain::get_post_language_details();

        if ( !empty( $details ) && !is_wp_error( $details ) ) {
            $locale = $details[ 'locale' ];
        }

        return [
            ToolTransiterate::replace(
                ToolLoco::__( 'basic-information', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Basic facts', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace( 
                ToolLoco::__( 'pros-and-cons', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Pros & cons', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace( 
                ToolLoco::__( 'review', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Review', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'offers', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Offers', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace( 
                ToolLoco::__( 'odds', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Odds', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'sports-and-markets', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Sports & Markets', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'in-play-betting', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'In play betting', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'payment-methods', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Payment', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'app', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'App', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'how-to-sign-up', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Sign up', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'how-to-bet', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'How to bet', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'faqs', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'FAQs', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'security', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Security', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'registration', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Registration', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'tips-and-tricks', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Tips and tricks', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'bonuses', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Bonuses', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'promotions', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Promotions', ToolLoco::TEXTDOMAIN, $locale ),

            ToolTransiterate::replace(
                ToolLoco::__( 'sports', ToolLoco::TEXTDOMAIN, $locale )
            ) => ToolLoco::__( 'Sports', ToolLoco::TEXTDOMAIN, $locale ),
        ];
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
            'title' => __( 'Page contents', ToolLoco::TEXTDOMAIN ) . ':',

            'items' => $items,
        ];
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-anchors.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>