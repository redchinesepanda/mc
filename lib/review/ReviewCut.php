<?php

class ReviewCut
{
	const CSS = [
        'review-cut' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-cut.css',

			'ver' => '1.0.0',
		],
    ];

    public static function register_style()
    {
		ReviewMain::register_style( self::CSS );
    }

	public static function register_functions()
	{
		$handler = new self();

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_cut' ] );
	}

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_filter( 'the_content', [ $handler, 'modify_content' ] );
    }

	// public static function get_cut_items( $dom )
	// {
	// 	return self::get_nodes(
	// 		$dom,

	// 		'//*[contains(@class, \'' . self::CLASSES[ 'cut-item' ] . '\')]'
	// 	);
	// }

	public static function get_cut_items( $dom )
	{
		return self::get_nodes(
			$dom,

			// '//*[contains(@class, \'' . self::CLASSES[ 'cut-item' ] . '\')]'

			// '//*[contains(concat(" ",normalize-space(@class)," ")," legal-cut-item ")]'

			'//*[contains(concat(" ",normalize-space(@class)," ")," legal-cut-item ")]/following-sibling::*[1]/self::*[contains(concat(" ",normalize-space(@class)," ")," legal-cut-item ")]'
			
			// '//*[contains(concat(" ",normalize-space(@class)," ")," legal-cut-item ")]/following-sibling::*[1]/self::*[not(//*[contains(concat(" ",normalize-space(@class)," ")," legal-cut-item ")] )]'
		);
	}

	public static function get_nodes( $dom, $query )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( $query );

		return $nodes;
	}

	public static function set_cut( $dom )
	{
		$nodes = self::get_cut_items( $dom );

		LegalDebug::debug( [
			'function' => 'set_cut',

			'$nodes->length' => $nodes->length,
		] ); 

		if ( $nodes->length == 0 )
		{
			return null;
		}
	}

	public static function modify_content( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

		self::set_cut( $dom );

		return $dom->saveHTML( $dom );
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

					[
						'title' => 'Cut Control',
						
						'selector' => 'p,hr',

						'classes' => self::CLASSES[ 'cut-control' ],
					],
				],
			],
		] );
	}
}

?>