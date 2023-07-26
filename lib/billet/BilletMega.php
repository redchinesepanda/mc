<?php

class BilletMega
{
	const CSS = [
        'billet-mega' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-mega.css',

            'ver'=> '1.0.7',
        ],
    ];

    public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        // [billet-mega id="269185" title-suffix="Greyhound Betting" title-tag="h4" review-label="Bonus" review-url="bonus" button-label="Play now" no-controls="1"][/billet-mega]

        add_shortcode( 'billet-mega', [ $handler, 'prepare' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_filter( 'the_content', [ $handler, 'remove_empty_paragraph_shortcode' ] );

		// add_filter( 'the_content', 'do_shortcode', 9 );
    }

	public static function remove_empty_paragraph_shortcode( $content ) {
		return strtr( $content, [
			'<p>['    => '[', 

			']</p>'   => ']', 

			']<br />' => ']',
		] );
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
			return $args;
		}

		$body = $dom->getElementsByTagName( 'body' )->item(0);

		foreach ( $nodes as $id => $node )
		{
			$args[ 'footer' ] .= ToolEncode::encode( $dom->saveHTML( $node ) );

			$body->removeChild( $node );
		}

		$args[ 'content' ] = ToolEncode::encode( $dom->saveHTML() );

		return $args;
	}

	const MODE = [
		'default' => 'default',

		'image' => 'image',

		'no-controls' => 'no-controls',

		'author' => 'author',
	];
	
	public static function get_iamge( $id )
	{
		$image = wp_get_attachment_image_src( $id, 'full' );

		if ( !$image )
		{
			return [];
		}
		
		return [
			'src' => $image[ 0 ],

			'width' => $image[ 1 ],
			
			'height' => $image[ 2 ],

			'class' => 'legal-image-' . $id,
		];
	}

	public static function prepare( $atts, $content = '' )
    {
		$pairs = [
			'id' => 0,

			'title-suffix' => '',

			'title-tag' => 'h3',

			'button-label' => __( 'Bet here', ToolLoco::TEXTDOMAIN ),

			'review-url' => '',

			'review-label' => __( 'Review', ToolLoco::TEXTDOMAIN ),

			'mode' => self::MODE[ 'default' ],
		];

		$atts = shortcode_atts( $pairs, $atts, 'billet-mega' );

		$no_controls = in_array( $atts[ 'mode' ], [ self::MODE[ 'no-controls' ], self::MODE[ 'image' ], self::MODE[ 'author' ] ] ) ? true : false;

		// LegalDebug::debug( [
		// 	'atts' => $atts,

		// 	'content' => $content,
		// ] );

		$url = BilletMain::get_url( $atts[ 'id' ] );

		$parts = self::get_parts( $content );

		$logo = '';

		$background = BilletMain::DEFAULT_COLOR;

		$title_text = '';

		if ( in_array( $atts[ 'mode' ], [ self::MODE[ 'default' ], self::MODE[ 'no-controls' ] ] ) )
		{
			$group = get_field( BilletMain::FIELD[ 'about' ], $atts[ 'id' ] );
	
			if ( $group )
			{
				$logo = $group[ BilletLogo::ABOUT[ 'logo' ] ];
	
				$title_text = $group[ BilletTitle::ABOUT[ 'title' ] ];
	
				$background = $group[ BilletMain::ABOUT[ 'background' ] ];
			}
		}

		if ( in_array( $atts[ 'mode' ], [ self::MODE[ 'image' ], self::MODE[ 'author' ] ] ) )
		{
			if ( !empty( $image = self::get_iamge( $atts[ 'id' ] ) ) )
			{
				$logo = $image[ 'src' ];
			}
		}

		if ( in_array( $atts[ 'mode' ], [ self::MODE[ 'author' ] ] ) )
		{
			$group = get_field( ReviewAuthor::FIELD[ 'author' ], $atts[ 'id' ] );
	
			if ( $group )
			{
				$name = $group[ ReviewAuthor::AUTHOR[ 'name' ] ];
	
				$post = $group[ ReviewAuthor::AUTHOR[ 'post' ] ];
	
				$items = $group[ ReviewAuthor::AUTHOR[ 'items' ] ];

				LegalDebug::debug( [
					'name' => $name,

					'post' => $post,

					'items' => $items,
				] );
			}
		}

		$args = [
			'id' => $atts[ 'id' ],
			
			'logo' => $logo,

			'background' => $background,

			'title' => [
				'href' => $url[ 'play' ],
				
				'text' => $title_text,

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

			'no-controls' => $no_controls,

			'mode' =>  $atts[ 'mode' ],
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