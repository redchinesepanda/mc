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

        // [billet-mega id="12345"][/billet-mega]

        add_shortcode( 'billet-mega', [ $handler, 'prepare' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	public static function prepare( $atts, $content = '' )
    {
		$pairs = [
			'id' => 0,
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

			'title' => get_field( 'billet-bonus-title', $atts[ 'id' ] ),

			'afillate' => [
				'href' => $url[ 'play' ],

				'text' => __( 'Bet here', ToolLoco::TEXTDOMAIN ),
			],

			'review' => [
				'href' => $url[ 'review' ],

				'text' => __( 'Review', ToolLoco::TEXTDOMAIN ),
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