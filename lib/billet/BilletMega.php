<?php

class BilletMega
{
	public static function register()
    {
        $handler = new self();

        // [billet-mega id="12345"][/billet-mega]

        add_shortcode( 'billet-mega', [ $handler, 'prepare' ] );
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

			'afillate' => [
				'href' => $url[ 'play' ],

				'text' => __( 'Afillate', ToolLoco::TEXTDOMAIN ),
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