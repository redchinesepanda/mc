<?php

class ReviewAnchors
{
    const CSS = [
        'review-anchors' => LegalMain::LEGAL_URL . '/assets/css/review/review-anchors.css',
    ];

    public static function register_style()
    {
        if ( ReviewMain::check() ) {
            foreach ( self::CSS as $name => $path ) {
                wp_enqueue_style( $name, $path );
            }
        }
    }

    public static function register()
    {
        $handler = new self();

        // [legal-anchors]

        add_shortcode( 'legal-anchors', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( './/a[@id]' );

		return $nodes;
	}

    public static function get_labels()
    {
        return [
            'basic-information' => __( 'Basic facts', ToolLoco::TEXTDOMAIN ),

            'pros-and-cons' => __( 'Pros & cons', ToolLoco::TEXTDOMAIN ),

            'review' => __( 'Review', ToolLoco::TEXTDOMAIN ),

            'offers' => __( 'Offers', ToolLoco::TEXTDOMAIN ),

            'odds' => __( 'Odds', ToolLoco::TEXTDOMAIN ),

            'sports-and-markets' => __( 'Sports & Markets', ToolLoco::TEXTDOMAIN ),

            'in-play-betting' => __( 'In play betting', ToolLoco::TEXTDOMAIN ),

            'payment-methods' => __( 'Payment', ToolLoco::TEXTDOMAIN ),

            'app' => __( 'App', ToolLoco::TEXTDOMAIN ),

            'how-to-sign-up' => __( 'Sign up', ToolLoco::TEXTDOMAIN ),

            'how-to-bet' => __( 'How to bet', ToolLoco::TEXTDOMAIN ),

            'faqs' => __( 'FAQs', ToolLoco::TEXTDOMAIN ),
        ];
    }

    public static function get_data( $nodes )
    {
        $labels = self::get_labels();

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