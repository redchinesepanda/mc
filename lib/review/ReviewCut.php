<?php

class ReviewCut
{
	const CSS = [
        'review-cut' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-cut.css',

			'ver' => '1.0.0',
		],
    ];

	const CSS_NEW = [
        'review-cut-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-cut-new.css',

			'ver' => '1.0.0',
		],
    ];

 /*    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    } */

	public static function register_style()
    {
		if ( TemplateMain::check_new() )
		{
			ReviewMain::register_style( self::CSS_NEW );
		}
		else
		{
			ReviewMain::register_style( self::CSS );
		}
    }

	const JS = [
        'review-cut' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-cut.js',

			'ver' => '1.0.0',
		],  
    ];

	const JS_NEW = [
        'review-cut' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-cut.js',

			'ver' => '1.0.0',

			'deps' => [ 'legal-header-cut' ],
		],  
    ];

    public static function register_script()
    {
		if ( TemplateMain::check_new() )
		{
			ReviewMain::register_script( self::JS_NEW );
		}
		else
		{
			ReviewMain::register_script( self::JS );
		}
    }

	public static function register()
    {
		if ( self::check_сut() )
		{
			$handler = new self();
	
			add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
	
			add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
	
			add_filter( 'the_content', [ $handler, 'modify_content' ], 9, 1 );
		}
    }

	public static function check_сut()
	{
		return TemplateMain::check_new() || self::check_contains_сut();
	}

	public static function check_contains_сut()
    {
        return LegalComponents::check_contains( self::CLASSES[ 'cut-item' ] );
    }

	public static function get_cut_items( $dom )
	{
		return self::get_nodes(
			$dom,

			'//*[contains(@class, "' . self::CLASSES[ 'cut-item' ] . '")]/following-sibling::*[1]/self::*[not(self::node()[contains(@class, "' . self::CLASSES[ 'cut-item' ] . '")])]'
		);
	}

	public static function get_nodes( $dom, $query )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( $query );

		return $nodes;
	}

	public static function get_control( $dom, $class = '' )
	{
		// $element = $dom->createElement( 'span' );
		
		$element = $dom->createElement( 'p' );

		$element->setAttribute( 'data-content-default', __( ReviewMain::TEXT[ 'open' ], ToolLoco::TEXTDOMAIN ) );

		$element->setAttribute( 'data-content-active', __( ReviewMain::TEXT[ 'close' ], ToolLoco::TEXTDOMAIN ) );

		$element->setAttribute( 'class', self::CLASSES[ 'cut-control' ] . ' ' . $class );

		return $element;
	}

	public static function set_cut( $dom )
	{
		$nodes = self::get_cut_items( $dom );

		if ( $nodes->length == 0 )
		{
			return false;
		}

		foreach ( $nodes as $node )
		{

			$class = $node->getAttribute( 'class' );

			LegalDebug::debug( [
				'ReviewCut' => 'set_cut',

				'class' => $class,
			] );

			if ( !str_contains( $class, CompilationAbout::CLASSES[ 'content' ] ) )
			{
				$class = '';
			}

			$control = self::get_control( $dom );

			$node->parentNode->insertBefore( $control, $node );
		}

		return true;
	}

	public static function modify_content( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		// $dom = LegalDOM::get_dom( $content );
		
		$dom = LegalDOM::get_dom( CompilationAbout::remove_compilation_about_content( $content ) ); 

		self::set_cut( $dom );

		return $dom->saveHTML( $dom );
	}

	public static function register_functions()
	{
		$handler = new self();

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_cut' ] );
	}

	const CLASSES = [
		'cut-item' => 'legal-cut-item',

		'cut-control' => 'legal-cut-control',
	];

	public static function style_formats_cut( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Cut',

				'items' => [
					[
						'title' => 'Cut Item',
						
						'selector' => 'h2,h3,p,ul,ol,table',

						'classes' => self::CLASSES[ 'cut-item' ],
					],
				],
			],
		] );
	}
}

?>