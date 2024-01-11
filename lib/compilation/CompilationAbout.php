<?php

class CompilationAbout
{
	const CSS = [
        'compilation-about' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-about.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	const JS = [
        'compilation-start-screen-cut' => LegalMain::LEGAL_URL . '/assets/js/compilation/start-screen-cut.js',
    ];

    public static function register_script()
    {
        ToolEnqueue::register_script( self::JS );
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

	public static function parse_node( $node )
	{
		return [
			'text' => $node->textContent,

			'class' => $node->getAttribute( 'class' ),
		];
	}

	public static function parse_content( $nodes )
	{
		$items = [];

		foreach ( $nodes as $node )
		{
			$items[] = self::parse_node( $node );
		}

		return $items;
	} 
	
	public static function get_content( $dom )
	{
		$nodes = self::get_nodes_content( $dom );

		if ( $nodes->length == 0 )
		{
			return '';
		}

		// return array_column( iterator_to_array( $nodes ), 'textContent' );

		return self::parse_content( $nodes );
	}

	public static function check_read_more( $items )
	{
		$result = array_search( ReviewCut::CLASSES[ 'cut-item' ], array_column( $items, 'class' ) );

		LegalDebug::debug( [
			'result' => $result,
		] );
	}

	public static function get()
	{
		$post = get_post();

		if ( empty( $post ) )
		{
			return [];
		}

		$dom = LegalDOM::get_dom( $post->post_content );

		self::check_read_more( self::get_content( $dom ) );

		return [
			'title' => self::get_title( $dom ),

			'content' => self::get_content( $dom ),
		]; 
	}

	const TEMPLATE = [
        'compilation-about' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-about.php',
    ];

	public static function render()
    {
        return self::render_main( self::TEMPLATE[ 'compilation-about' ], self::get() );
    }

	public static function render_main( $template, $args )
    {
        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }

	const CLASSES = [
		'title' => 'compilation-about-title',

		'content' => 'compilation-about-content',
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