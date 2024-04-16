<?php

class CompilationAbout
{
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

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	public static function register_functions()
	{
		$handler = new self();

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_compilation_about' ] );
	}

	public static function get_nodes( $dom, $query )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( $query );

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
		);
	}

	public static function get_title( $dom )
	{
		$nodes = self::get_nodes_title( $dom );

		if ( $nodes->length == 0 )
		{
			return '';
		}

		return $nodes->item( 0 )->textContent;
	}

	public static function parse_node( $dom, $node )
	{
		return [
			'html' => $dom->saveHTML( $node ),
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

	public static function get()
	{
		$post = get_post();

		if ( empty( $post ) )
		{
			return [];
		}

		$dom = LegalDOM::get_dom( $post->post_content );

		return [
			'title' => self::get_title( $dom ),

			'content' => self::get_content( $dom ),

			'read-more' => self::check_read_more( self::get_content( $dom ) ),

			'image' => [
				'src' => LegalMain::LEGAL_URL . '/assets/img/compilation/about-default.webp',

				'width' => 400,

				'height' => 320,
			],
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
				$dom->removeChild( $node );
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

	const CLASSES = [
		'title' => 'section-content-title',

		'content' => 'section-content-text',
	];

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
				],
			],
		] );
	}
}

?>