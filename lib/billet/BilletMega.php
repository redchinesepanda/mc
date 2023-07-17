<?php

class BilletMega
{
	const CSS = [
        'billet-mega' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-mega.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        // [billet-mega id="269185" title-suffix="Greyhound Betting" title-tag="h4" review-label="Bonus" review-url="bonus" button-label="Play now"][/billet-mega]

        add_shortcode( 'billet-mega', [ $handler, 'prepare' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	public static function prepare( $atts, $content = '' )
    {
		$pairs = [
			'id' => 0,

			'title-suffix' => '',

			'title-tag' => 'h3',

			'button-label' => __( 'Bet here', ToolLoco::TEXTDOMAIN )

			'review-label' => __( 'Review', ToolLoco::TEXTDOMAIN ),

			'review-url' => '',
		];

		$atts = shortcode_atts( $pairs, $atts, 'billet-mega' );

		// LegalDebug::debug( [
		// 	'atts' => $atts,

		// 	'content' => $content,
		// ] );

		$url = BilletMain::get_url( $atts[ 'id' ] );

		$args = [
			'id' => $atts[ 'id' ],

			'logo' => get_field( 'billet-logo-url', $atts[ 'id' ] ),

			'title' => [
				'text' => get_field( 'billet-title-text', $atts[ 'id' ] ),

				'tag' => $atts[ 'title-tag' ],
			],

			'afillate' => [
				'href' => $url[ 'play' ],

				'text' => $atts[ 'button-label' ],
			],

			'review' => [
				'href' => $url[ 'review' ],

				'text' => $atts[ 'review-label' ],
			],

			'content' => $content,

			'footer' => '',
		];

        return self::render( $args );
    }

	const TEMPLATE = [
        'billet-mega' => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-mega.php',
    ];

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'billet-mega' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>