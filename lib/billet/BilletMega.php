<?php

class BilletMega
{
	const CSS = [
        'billet-mega' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-mega.css',

            'ver'=> '1.1.7',
        ],
    ];

	const CSS_NEW = [
        'billet-mega' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-mega-new.css',

            'ver'=> '1.0.0',
        ],
    ];

	public static function check_contains_billet_mega()
    {
        // return LegalComponents::check_shortcode( self::SHORTCODE[ 'mega' ] );
        
		return LegalComponents::check_contains( self::SHORTCODE[ 'mega' ] );
    } 

    public static function register_style()
    {
		if ( TemplateMain::check_new() )
		{
			if ( self::check_contains_billet_mega() )
			{
				ToolEnqueue::register_style( self::CSS_NEW );
			}
		}
		else
		{
			ToolEnqueue::register_style( self::CSS );
		}
    }

	const JS = [
        'billet-mega-tnc' => [
            // 'path' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-mega-tnc.js',

			'path' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-footer.js',

            'ver' => '1.0.0',
        ],
    ];

	public static function register_script()
    {
        ReviewMain::register_script( self::JS );
    }

	public static function register_functions()
	{
		$handler = new self();
		
		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_mega_billet' ] );
	}

	const SHORTCODE = [
		'mega' => 'billet-mega',
	];

	public static function register()
    {
		if ( self::check_contains_billet_mega() )
		{
			$handler = new self();
	
			// [billet-mega id="269185" title-label="Custom Title Label" title-suffix="Custom Title Sufix" title-tag="h4" review-label="Custom Review Label" review-url="bonus" button-label="Custom Button Label" no-controls="1"][/billet-mega]
	
			add_shortcode( self::SHORTCODE[ 'mega' ], [ $handler, 'prepare' ] );
	
			add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

			// add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
	
			add_filter( 'the_content', [ $handler, 'remove_empty_paragraph_shortcode' ] );
		}
    }

	public static function remove_empty_paragraph_shortcode( $content ) {
		return strtr( $content, [
			'<p>['    => '[', 

			']</p>'   => ']', 

			']<br />' => ']',

			// '>[' => '[',

			// '}">[' => '[',

			// ']</span>' => ']',
		] );
	}

	public static function get_nodes_license( $dom )
	{
		return LegalDOM::get_nodes( $dom, '//*[contains(@class, \'' . self::CLASSES[ 'license' ] . '\')]' );
	}

	public static function get_nodes( $dom )
	{
		return LegalDOM::get_nodes( $dom, '//*[contains(@class, \'' . ReviewProsCons::CSS_CLASS[ 'container' ] . '\')]' );
	}

	public static function get_nodes_tnc( $dom )
	{
		return LegalDOM::get_nodes( $dom, '//*[contains(@class, \'' . self::CLASSES[ 'tnc' ] . '\')]' );
	}

	public static function get_parts( $content )
	{
		$dom = LegalDOM::get_dom( do_shortcode( $content ) );

		return [
			'license' => self::get_license( $dom ),

			'footer' => self::get_footer( $dom ),

			'tnc' => self::get_tnc( $dom ),

			'content' => $dom->saveHTML( $dom ),
		];
	}

	public static function modify_license( $value )
	{
		return str_replace(  ':', '', $value );
	}

	public static function get_license( $dom )
	{
		if ( !TemplateMain::check_new() )
		{
			return '';
		}

		$nodes = self::get_nodes_license( $dom );

		if ( $nodes->length == 0 )
		{
			return '';
		}

		$node = $nodes->item( 0 );

		LegalDOM::remove_child( $dom, $node );

		return self::modify_license( $dom->saveHTML( $node ) );
	}

	public static function get_footer( $dom )
	{
		$nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 )
		{
			return '';
		}

		$footer = [];

		foreach ( $nodes as $id => $node )
		{
			$footer[] = ToolEncode::encode( $dom->saveHTML( $node ) );

			LegalDOM::remove_child( $dom, $node );
		}

		return implode( '', $footer );
	}

	public static function get_tnc( $dom )
	{
		$nodes = self::get_nodes_tnc( $dom );

		// LegalDebug::debug( [
		// 	'BilletMega' => 'get_tnc',

		// 	'nodes' => $nodes,
		// ] );

		if ( $nodes->length == 0 )
		{
			return '';
		}

		$tnc = [];

		foreach ( $nodes as $node )
		{
			// $tnc[] = ToolEncode::encode( $dom->saveHTML( $node ) );

			$text_content = ToolEncode::encode( $node->textContent );

			$text_content = strip_tags( $text_content );

			$text_content = htmlspecialchars( $text_content );
			
			$tnc[] = $text_content;

			LegalDOM::remove_child( $dom, $node );
		}

		// LegalDebug::debug( [
		// 	'BilletMega' => 'get_tnc',

		// 	'tnc' => implode( '', $tnc ),
		// ] );

		return implode( ' ', $tnc );
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

					'class' => 'social-' . $link[ ReviewAuthor::LINK_ITEM[ 'image' ] ],
				];
			}
		}

		return $items;
	}

	const FIELD = [
		'name' => 'media-name',
	];

	const TAXONOMY = [
		'billet-feature' => 'billet_feature',
	];

	public static function get_complete_tnc( $id, $billet_feature, $tnc )
	{
		$filter = [
			// 'description' => true,
			
			'description' => false,
	
			'features' => [],
		];

		// $filter = [];

		$term = get_term_by( 'slug', $billet_feature, self::TAXONOMY[ 'billet-feature' ] );

		if ( $term )
		{
			$filter = [
				'description' => true,
	
				'features' => [ $term->term_id ],
			];
		}
		
		// LegalDebug::debug( [
		// 	'id' => $id,

		// 	'billet_feature' => $billet_feature,

		// 	'term' => $term,

		// 	'filter' => $filter,
		// ] );

		$description = BilletMain::get_main_description( $id, $filter );

		$description = strip_tags( $description );

		$description = htmlspecialchars( $description );

		return $tnc . $description;
	}

	public static function prepare( $atts, $content = '' )
    {
		// LegalDebug::debug( [
		// 	'atts' => $atts,

		// 	'content' => $content,
		// ] );

		$pairs = [
			'id' => 0,

			'title-label' => '',

			'title-suffix' => '',

			'title-tag' => 'h3',

			'button-label' => __( BilletMain::TEXT[ 'bet-here' ], ToolLoco::TEXTDOMAIN ),

			'review-url' => '',

			'review-label' => __( BilletMain::TEXT[ 'review' ], ToolLoco::TEXTDOMAIN ),

			'mode' => self::MODE[ 'default' ],

			'billet-feature' => '',

			'button-read-tnc' => __( BilletMain::TEXT[ 'read-more' ], ToolLoco::TEXTDOMAIN ),

			'title-tnc' => __( BilletMain::TEXT[ 'full-tnc' ], ToolLoco::TEXTDOMAIN ),
		];

		$atts = shortcode_atts( $pairs, $atts, 'billet-mega' );

		$no_controls = in_array( $atts[ 'mode' ], [ self::MODE[ 'no-controls' ], self::MODE[ 'image' ], self::MODE[ 'author' ], self::MODE[ 'horizontal' ] ] ) ? true : false;

		// LegalDebug::debug( [
		// 	'atts' => $atts,

		// 	'content' => $content,
		// ] );

		$url = BilletMain::get_url( $atts[ 'id' ] );

		// LegalDebug::debug( [
		// 	'function' => 'BilletMega::prepare',

		// 	'url' => $url,
		// ] );

		$parts = self::get_parts( $content );

		// $billet_feature = $atts[ 'billet-feature' ];

		$parts[ 'tnc' ] = self::get_complete_tnc( $atts[ 'id' ], $atts[ 'billet-feature' ], $parts[ 'tnc' ] );

		// $filter = [];

		// $term = get_term_by( 'slug', 'bonusy-bonus', $billet_feature );

		// if ( $term )
		// {
		// 	$filter = [
		// 		'description' => true,
	
		// 		'features' => [ $term->term_id ],
		// 	];
		// }

		// $description = BilletMain::get_main_description( $atts[ 'id' ], $filter );

		// $parts[ 'tnc' ] .= $description;

		// LegalDebug::debug( [
		// 	'BilletMega' => 'prepare',

		// 	'description' => $description,

		// 	'tnc' => $parts[ 'tnc' ],
		// ] );

		$logo = '';

		$background = BilletMain::DEFAULT_COLOR;

		$name = '';

		$title_text = '';

		$author = [];

		if ( in_array( $atts[ 'mode' ], [ self::MODE[ 'default' ], self::MODE[ 'no-controls' ], self::MODE[ 'horizontal' ] ] ) )
		{
			$group = get_field( BilletMain::FIELD[ 'about' ], $atts[ 'id' ] );
	
			if ( $group )
			{
				// LegalDebug::debug( [
				// 	'BilletMega' => 'prepare',

				// 	'get_logo_megabillet' => BrandMain::get_logo_megabillet( $atts[ 'id' ] ),
				// ] );

				if ( $brand_src = BrandMain::get_logo_megabillet( $atts[ 'id' ] ) )
				{
					$logo = $brand_src;
				}
				else
				{
					$logo = $group[ BilletLogo::ABOUT[ 'logo' ] ];

					if ( !empty( $group[ BilletLogo::ABOUT[ 'mega' ] ] ) )
					{
						$logo = $group[ BilletLogo::ABOUT[ 'mega' ] ];
					}
				}
	
				$name = $group[ BilletTitle::ABOUT[ 'title' ] ];

				// $title_text = $group[ BilletTitle::ABOUT[ 'title' ] ];
				
				$title_text = '';

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

		if ( in_array( $atts[ 'mode' ], [ self::MODE[ 'image' ] ] ) )
		{
			$field = get_field( self::FIELD[ 'name' ], $atts[ 'id' ] );
	
			if ( $field )
			{
				$name = $field;
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

			'name' => $name,

			'title' => [
				'href' => $url[ 'play' ],

				'nofollow' => $url[ 'play-nofollow' ],
				
				'text' => $title_text,

				'tag' => $atts[ 'title-tag' ],
			],

			'afillate' => [
				'href' => $url[ 'play' ],

				'nofollow' => $url[ 'play-nofollow' ],

				'text' => $atts[ 'button-label' ],
			],

			'review' => [
				'href' => $url[ 'review' ],

				'text' => $atts[ 'review-label' ],
			],

			'license' => $parts[ 'license' ],

			'content' => $parts[ 'content' ],

			'footer' => $parts[ 'footer' ],

			'tnc' => $parts[ 'tnc' ],

			'tnc-class' => BilletBonus::get_tnc_class(),

			'button-read-tnc' => $atts[ 'button-read-tnc' ],

			'title-tnc' => $atts[ 'title-tnc' ],

			'no-controls' => $no_controls,

			'mode' =>  $atts[ 'mode' ],

			'author' => $author,
		];

		return self::render( $args );
    }

	const TEMPLATE = [
        'billet-mega' => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-mega.php',

        'billet-mega-new' => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-mega-new.php',
    ];

    // public static function render( $args )
    // {
    //     ob_start();

    //     load_template( self::TEMPLATE[ 'billet-mega' ], false, $args );

    //     $output = ob_get_clean();

    //     return $output;
    // }
    
	public static function render( $args )
    {
        if ( TemplateMain::check_new() )
		{
			return self::render_main( self::TEMPLATE[ 'billet-mega-new' ], $args );
		}

		return self::render_main( self::TEMPLATE[ 'billet-mega' ], $args );
    }
	
    public static function render_main( $template, $args )
    {
        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }

	const CLASSES = [
		'license' => 'legal-license',

		'button' => 'legal-button',

		'tnc' => 'legal-tnc',
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

					[
						'title' => 'Terms and conditions',
						
						'selector' => 'a,p',

						'classes' => self::CLASSES[ 'tnc' ],
					],
				],
			],
		] );
	}
}

?>