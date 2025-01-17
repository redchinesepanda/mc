<?php

class CompilationAbout
{
	const CLASSES = [
		'title' => 'section-content-title',

		'content' => 'section-content-text',

		'button' => 'section-content-button',

		'swiper-slide' => 'swiper-slide',
	];

	const CSS = [
        'compilation-about' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-about.css',

            'ver'=> '1.0.0',
        ],
    ];

	public static function check_contains_about()
    {
        return LegalComponents::check_contains( self::CLASSES[ 'title' ] );
    }

    public static function register_style()
    {
		if ( self::check_contains_about() )
		{
			ToolEnqueue::register_style( self::CSS );
		}
    }

	const JS_NEW = [
        'compilation-about' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/compilation/compilation-about.js',

			'ver' => '1.0.0',
		],

    ]; 

    public static function register_script()
    {
		if ( TemplateMain::check_new() )
		{
			ToolEnqueue::register_script( self::JS_NEW );
		}
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

	public static function register_functions()
	{
		$handler = new self();

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_compilation_about' ], 10, 1 );
	}

	public static function get_nodes( $dom, $query, $node = null )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( $query, $node );

		return $nodes;
	}

	public static function get_nodes_title( $dom )
	{
		return self::get_nodes(
			$dom,
			
			'//h1[contains(@class, \'' . self::CLASSES[ 'title' ] . '\')]'
		);
	}

	public static function get_nodes_content( $dom )
	{
		return self::get_nodes(
			$dom,
			
			'//p[contains(@class, \'' . self::CLASSES[ 'content' ] . '\')]'
			
			// '//p[contains(@class, \'' . self::CLASSES[ 'content' ] . '\')]|//*[contains(@class, \'' . ReviewCut::CLASSES[ 'cut-control' ] . '\')]'

			// '//p[contains(concat(" ",normalize-space(@class)," ")," section-content-text ")]|//span[contains(concat(" ",normalize-space(@class)," ")," legal-cut-control ")]'
		);
	}

	public static function get_nodes_buttons( $dom )
	{
		return self::get_nodes(
			$dom,
			
			'//a[contains(@class, \'' . self::CLASSES[ 'button' ] . '\')]'
		);
	}

	public static function get_title( $dom )
	{
		$nodes = self::get_nodes_title( $dom );

		if ( $nodes->length == 0 )
		{
			return '';
		}

		// return $nodes->item( 0 )->textContent;

		$node = $nodes->item( 0 );

		return self::parse_node( $dom, $node );
	}
	
	public static function set_swiper_item( $nodes )
	{
		foreach ( $nodes as $node )
		{
			$class = explode( ' ',  $node->getAttribute( 'class' ) );

			$class[] = self::CLASSES[ 'swiper-slide' ];

			$node->setAttribute( 'class', implode( ' ', $class ) );
		}
	}

	public static function get_buttons( $dom )
	{
		$nodes = self::get_nodes_buttons( $dom );

		if ( $nodes->length == 0 )
		{
			return []; 
		}

		self::set_swiper_item( $nodes );

		return self::parse_content( $dom, $nodes );
	}

	public static function parse_node( $dom, $node )
	{
		$html = $dom->saveHTML( $node );

		$html = ReviewTitle::modify_content( $html );

		// LegalDebug::debug( [
		// 	'CompilationAbout' => 'parse_node',

		// 	'modify_content' => ReviewTitle::modify_content( $dom->saveHTML( $node ) ),
		// ] );

		return [
			'class' => $node->getAttribute( 'class' ),

			// 'html' => $dom->saveHTML( $node ),
			
			'html' => $html,
		];
	}

	public static function parse_content( $dom, $nodes )
	{
		$items = [];

		foreach ( $nodes as $node )
		{
			$items[] = self::parse_node( $dom, $node );
		}

		return $items;
	}
	
	public static function get_content( $dom )
	{
		$nodes = self::get_nodes_content( $dom );

		if ( $nodes->length == 0 )
		{
			return []; 
		}

		return self::parse_content( $dom, $nodes );
	}

	public static function has_read_more( $item )
    {
        return str_contains( $item, ReviewCut::CLASSES[ 'cut-item' ] );
    }

    public static function check_read_more( $items )
    {
        $handler = new self();

        return !empty( array_filter( array_column( $items, 'class' ), [ $handler, 'has_read_more' ] ) );
    }

	const TAXONOMY = [
		'page-type' => 'page_type',
	];

	const PAGE_TYPE = [
		'casino' => 'casino',
	];

	public static function check_front_page()
	{
		return is_front_page();
	}

	public static function get_image()
	{
		// LegalDebug::debug( [
		// 	'CompilationAbout' => 'get_image',

		// 	'is_front_page' => is_front_page(),

		// 	'is_home' => is_home(),
		// ] );

		if ( self::check_front_page() )
		{
			return null;
		}

		$src = LegalMain::LEGAL_URL . '/assets/img/compilation/compilation-bookmaker.svg';

		if ( has_term( self::PAGE_TYPE[ 'casino' ], self::TAXONOMY[ 'page-type' ] ) )
		{
			$src = LegalMain::LEGAL_URL . '/assets/img/compilation/compilation-casino.svg';
	  	}

		return [
			'src' => $src,

			// 'width' => 400,
			'width' => 350,

			// 'height' => 320,
			'height' => 246,
		];
	}

	public static function get()
	{
		// LegalDebug::debug( [
		// 	'CompilationAbout' => 'get',
		// ] );

		$post = get_post();

		if ( empty( $post ) )
		{
			return [];
		}

		$dom = LegalDOM::get_dom( $post->post_content );

		return [
			'title' => self::get_title( $dom ),

			'content' => self::get_content( $dom ),

			'buttons' => self::get_buttons( $dom ),

			'read-more' => self::check_read_more( self::get_content( $dom ) ),

			'cut-control' => [
				'label' => ToolLoco::translate( BilletMain::TEXT[ 'read-more' ] ),

				'default' => ToolLoco::translate( BilletMain::TEXT[ 'read-more' ] ),

				'active' => ToolLoco::translate( BilletMain::TEXT[ 'hide' ] ),
			],

			'image' => self::get_image(),
		];
	}

	public static function remove_items( $dom )
	{
		$nodes = self::get_nodes_title( $dom );

		if ( $nodes->length != 0 )
		{
			$dom->removeChild( $nodes->item( 0 ) );
		}

		$nodes = self::get_nodes_content( $dom );

		if ( $nodes->length != 0 )
		{
			foreach ( $nodes as $node )
			{
				try
				{
					// $dom->removeChild( $node );

					$node->parentNode->removeChild( $node );
				}
				catch ( DOMException $e )
				{
					LegalDebug::debug( [
						'CompilationAbout' => 'remove_items',
		
						'node' => substr( $node->textContent, 0, 30 ),
		
						'message' => $e->getMessage(),
					] );
				}
			}
		}

		$nodes = self::get_nodes_buttons( $dom );
		
		// LegalDebug::debug( [
		// 	'CompilationAbout' => 'remove_items',

		// 	'length' => $nodes->length,
		// ] );

		if ( $nodes->length != 0 )
		{
			foreach ( $nodes as $node )
			{
				try
				{
					// $dom->removeChild( $node );

					// $parent = $node->parentNode;

					$node->parentNode->removeChild( $node );

					// $parent->parentNode->removeChild( $parent );
				}
				catch ( DOMException $e )
				{
					LegalDebug::debug( [
						'CompilationAbout' => 'remove_items',
		
						'node' => substr( $node->textContent, 0, 30 ),
		
						'message' => $e->getMessage(),
					] );
				}
			}
		}
	}

	public static function remove_compilation_about_content( $content )
	{
		$dom = LegalDOM::get_dom( $content );

		self::remove_items( $dom );

		return $dom->saveHTML( $dom );
	}

	const TEMPLATE = [
        'compilation-about' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-about.php',
    ];

	public static function check_render()
	{
		return TemplateMain::check_new();
	}

	public static function render()
    {
		if ( self::check_render() )
		{
			return LegalComponents::render_main( self::TEMPLATE[ 'compilation-about' ], self::get() );
		}

		return '';
    }

	public static function style_formats_compilation_about( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Compilation About',

				'items' => [
					[
						'title' => 'Compilation About Title',
						
						'selector' => 'h1',

						'classes' => self::CLASSES[ 'title' ],
					],

					[
						'title' => 'Compilation About Content',
						
						'selector' => 'p',

						'classes' => self::CLASSES[ 'content' ],
					],

					[
						'title' => 'Compilation About Button',
						
						'selector' => 'a',

						'classes' => self::CLASSES[ 'button' ],
					],
				],
			],
		] );
	}
}

?>