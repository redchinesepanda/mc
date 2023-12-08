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

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_cut' ] );
	}

	const CLASSES = [
		'cut-item' => 'legal-cut-item',
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