<?php

class BilletMega
{
	const CSS = [
        'billet-mega' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-mega.css',

            'ver'=> '1.1.6',
        ],
    ];

    public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	public static function register_functions()
	{
		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_mega_billet' ] );
	}

	public static function register()
    {
        $handler = new self();

        // [billet-mega id="269185" title-label="Custom Title Label" title-suffix="Custom Title Sufix" title-tag="h4" review-label="Custom Review Label" review-url="bonus" button-label="Custom Button Label" no-controls="1"][/billet-mega]

        add_shortcode( 'billet-mega', [ $handler, 'prepare' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_filter( 'the_content', [ $handler, 'remove_empty_paragraph_shortcode' ] );
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

		// return $xpath->query( '//body/*[contains(@class, \'' . ReviewProsCons::CSS_CLASS[ 'container' ] . '\')]' );
		
		return $xpath->query( '//*[contains(@class, \'' . ReviewProsCons::CSS_CLASS[ 'container' ] . '\')]' );
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

		// $body = $dom->getElementsByTagName( 'body' )->item(0);

		foreach ( $nodes as $id => $node )
		{
			$args[ 'footer' ] .= ToolEncode::encode( $dom->saveHTML( $node ) );

			// $body->removeChild( $node );

			try
			{
				$node->parentNode->removeChild( $node );
			}
			catch ( DOMException $e )
			{
				LegalDebug::debug( [
					'class' => 'BilletMega',

					'function' => 'get_parts,removeChild',

					'node' => substr( $node->textContent, 0, 30 ),

					'message' => $e->getMessage(),
				] );
			}
		}

		// $args[ 'content' ] = ToolEncode::encode( $dom->saveHTML( $dom ) );
		
		$args[ 'content' ] = $dom->saveHTML( $dom );

		return $args;
	}

	const MODE = [
		'default' => 'default',

		'image' => 'image',

		'no-controls' => 'no-controls',

		'author' => 'author',

		'horizontal' => 'horizontal',
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

	public static function prepare_links( $links )
	{
		$items = [];

		if ( !empty( $links ) )
		{
			foreach ( $links as $link )
			{
				$items[] = [
					'url' => $link[ ReviewAuthor::LINK_ITEM[ 'url' ] ],
	
					'image' => LegalMain::LEGAL_URL . '/assets/img/review/author/' . $link[ ReviewAuthor::LINK_ITEM[ 'image' ] ] . '.svg',
				];
			}
		}

		return $items;
	}

	public static function prepare( $atts, $content = '' )
    {
		$pairs = [
			'id' => 0,

			'title-label' => '',

			'title-suffix' => '',

			'title-tag' => 'h3',

			'button-label' => __( BilletMain::TEXT[ 'bet-here' ], ToolLoco::TEXTDOMAIN ),

			'review-url' => '',

			'review-label' => __( BilletMain::TEXT[ 'review' ], ToolLoco::TEXTDOMAIN ),

			'mode' => self::MODE[ 'default' ],
		];

		$atts = shortcode_atts( $pairs, $atts, 'billet-mega' );

		$no_controls = in_array( $atts[ 'mode' ], [ self::MODE[ 'no-controls' ], self::MODE[ 'image' ], self::MODE[ 'author' ], self::MODE[ 'horizontal' ] ] ) ? true : false;

		// LegalDebug::debug( [
		// 	'atts' => $atts,

		// 	'content' => $content,
		// ] );

		$url = BilletMain::get_url( $atts[ 'id' ] );

		$parts = self::get_parts( $content );

		$logo = '';

		$background = BilletMain::DEFAULT_COLOR;

		$title_text = '';

		$author = [];

		if ( in_array( $atts[ 'mode' ], [ self::MODE[ 'default' ], self::MODE[ 'no-controls' ], self::MODE[ 'horizontal' ] ] ) )
		{
			$group = get_field( BilletMain::FIELD[ 'about' ], $atts[ 'id' ] );
	
			if ( $group )
			{
				$logo = $group[ BilletLogo::ABOUT[ 'logo' ] ];

				if ( !empty( $group[ BilletLogo::ABOUT[ 'mega' ] ] ) )
				{
					$logo = $group[ BilletLogo::ABOUT[ 'mega' ] ];
				}
	
				$title_text = $group[ BilletTitle::ABOUT[ 'title' ] ];

				if ( !empty( $atts[ 'title-label' ] ) )
				{
					$title_text = $atts[ 'title-label' ];
				}

				if ( !empty( $atts[ 'title-suffix' ] ) )
				{
					$title_text .= ' ' . $atts[ 'title-suffix' ];
				}
	
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
				$author = [
					'name' => $group[ ReviewAuthor::AUTHOR[ 'name' ] ],

					'post' => $group[ ReviewAuthor::AUTHOR[ 'post' ] ],

					'prefix' => __( BilletMain::TEXT[ 'get-in-touch' ], ToolLoco::TEXTDOMAIN ),

					'items' => self::prepare_links( $group[ ReviewAuthor::AUTHOR[ 'items' ] ] ),
				];
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

			'author' => $author,
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

	const CLASSES = [
		'license' => 'legal-license',

		'button' => 'legal-button',
	];

	public static function style_formats_mega_billet( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Mega Billet',

				'items' => [
					[
						'title' => 'License',
						
						'selector' => 'p',

						'classes' => self::CLASSES[ 'license' ],
					],

					[
						'title' => 'Button',
						
						'selector' => 'a',

						'classes' => self::CLASSES[ 'button' ],
					],
				],
			],
		] );
	}
}

?>