<?php

class ReviewTitle
{
	const CSS = [
        'review-title' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-title.css',

            'ver' => '1.0.2',
        ],
    ];

	public static function register_style( $styles = [] )
    {
        ReviewMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_header' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_header_date' ] );
    }

	public static function style_formats_header( $settings )
	{
		return self::style_formats_check( $settings, [
			[
				'title' => 'Title with Image',

				'items' => [
					[
						'title' => 'H3 History',
						
						'selector' => 'h3',

						'classes' => 'legal-header-3 legal-header-history',
					],

					[
						'title' => 'H3 Features',
						
						'selector' => 'h3',

						'classes' => 'legal-header-3 legal-header-features',
					],

					[
						'title' => 'H3 Football',
						
						'selector' => 'h3',

						'classes' => 'legal-header-3 legal-header-football',
					],

					[
						'title' => 'H3 Tennis',
						
						'selector' => 'h3',

						'classes' => 'legal-header-3 legal-header-tennis',
					],

					[
						'title' => 'H3 Basketball',
						
						'selector' => 'h3',

						'classes' => 'legal-header-3 legal-header-basketball',
					],

					[
						'title' => 'H3 Horceracing',
						
						'selector' => 'h3',

						'classes' => 'legal-header-3 legal-header-horceracing',
					],

					[
						'title' => 'H3 Deposit',
						
						'selector' => 'h3',

						'classes' => 'legal-header-3 legal-header-deposit',
					],

					[
						'title' => 'H3 Widthdraw',
						
						'selector' => 'h3',

						'classes' => 'legal-header-3 legal-header-widthdraw',
					],

					[
						'title' => 'H3 E-Sports',
						
						'selector' => 'h3',

						'classes' => 'legal-header-3 legal-header-esports',
					],
				],
			],
		] );
	}
	public static function style_formats_header_date( $settings )
	{
		return self::style_formats_check( $settings, [
			[
				'title' => 'Title other',

				'items' => [
					[
						'title' => 'H1-H2 Date',
						
						'selector' => 'h1,h2',

						'classes' => 'legal-header-date',
					],
				],
			],
		] );
	}
}

?>