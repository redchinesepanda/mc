<?php

class BilletMega
{
	const CSS = [
        'billet-mega' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-mega.css',

            'ver'=> '1.0.2',
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

		add_filter( 'the_content', [ $handler, 'tg_remove_empty_paragraph_tags_from_shortcodes_wordpress' ] );
    }

	public static function tg_remove_empty_paragraph_tags_from_shortcodes_wordpress( $content ) {
		$toFix = array( 
			'<p>['    => '[', 
			']</p>'   => ']', 
			']<br />' => ']'
		); 
		return strtr( $content, $toFix );
	}

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		return $xpath->query( '//body/*[contains(@class, \'' . ReviewProsCons::CSS_CLASS[ 'container' ] . '\')]' );
	}

	public static function get_parts( $content )
	{
		$args = [
			'content' => $content,

			'footer' => '',
		];

		$dom = LegalDOM::get_dom( $content );

		$nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		$body = $dom->getElementsByTagName( 'body' )->item(0);

		foreach ( $nodes as $id => $node )
		{
			$args[ 'footer' ] .= ToolEncode::encode( $dom->saveHTML( $node ) );

			$body->removeChild( $node );
		}

		$args[ 'content' ] = $dom->saveHTML();

		return $args;
	}
	
	public static function prepare( $atts, $content = '' )
    {
		$pairs = [
			'id' => 0,

			'title-suffix' => '',

			'title-tag' => 'h3',

			'button-label' => __( 'Bet here', ToolLoco::TEXTDOMAIN ),

			'review-label' => __( 'Review', ToolLoco::TEXTDOMAIN ),

			'review-url' => '',
		];

		$atts = shortcode_atts( $pairs, $atts, 'billet-mega' );

		// LegalDebug::debug( [
		// 	'atts' => $atts,

		// 	'content' => $content,
		// ] );

		$url = BilletMain::get_url( $atts[ 'id' ] );

		$parts = self::get_parts( $content );

		$args = [
			'id' => $atts[ 'id' ],

			'logo' => get_field( 'billet-logo-url', $atts[ 'id' ] ),

			'title' => [
				'href' => $url[ 'play' ],
				
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

			'content' => $parts[ 'content' ],

			'footer' => $parts[ 'footer' ],
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