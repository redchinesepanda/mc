<?php

class ToolTinyMCE
{
	const JS = [
        'tool-tinymce' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/tools/tool-tinymce.js',

			'ver' => '1.0.1',
		],
    ];

    public static function register_script()
    {
		ToolEnqueue::register_script( self::JS );
    }

    public static function register()
    {
        $handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'table_classes' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'table_cell_classes' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_overview' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_contextbox' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_column' ] );

		add_action( 'after_setup_theme', [ $handler, 'editor_styles' ] );

		add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );
    }

	const CSS = [
        'legal-tinymce-main' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-main.css',

        'legal-tinymce-overview' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-overview.css',

        'legal-tinymce-table' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-table.css',

        'legal-tinymce-pros' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-pros.css',

        'legal-tinymce-header' => LegalMain::LEGAL_URL . '/assets/css/tools/tool-tinymce-header.css',
    ];

	public static function editor_styles() {
		foreach ( self::CSS as $style ) {
			add_editor_style( $style );
		}
	}

	public static function table_classes( $settings )
	{
		$styles = [
			[
				'title' => 'По умолчанию',
				'value' => '',
			],

			[
				'title' => 'Ряд и Столбец',
				'value' => 'legal-raw-column',
			],

			[
				'title' => 'Ряд',
				'value' => 'legal-raw',
			],

			[
				'title' => 'Галка',
				'value' => 'legal-check',
			],

			// [
			// 	'title' => 'Колонка 50%',
			// 	'value' => 'legal-column',
			// ],

			// [
			// 	'title' => 'Колонка 33.333%',
			// 	'value' => 'legal-column-3',
			// ],

			[
				'title' => 'Статистика',
				'value' => 'legal-stats',
			],

			[
				'title' => 'Счетчик',
				'value' => ReviewCounter::CLASSES[ 'base' ],
			],
		];

		$settings[ 'table_class_list' ] = json_encode( $styles );

		return $settings;
	}

	public static function table_cell_classes( $settings )
	{
		$settings[ 'table_cell_class_list' ] = json_encode( [
			[
				'title' => 'По умолчанию',
				'value' => '',
			],

			[
				'title' => 'Крест',
				'value' => 'legal-cross',
			],
		] );

		return $settings;
	}

	public static function style_formats_check( $settings, $style_new )
	{
		$style_formats = [];

		if ( !empty( $settings[ 'style_formats' ] ) ) {
			$style_formats = json_decode( $settings[ 'style_formats' ] );
		}

		$settings[ 'style_formats' ] = json_encode( array_merge( $style_formats, $style_new ) );

		return $settings;
	}

	public static function style_formats_column( $settings )
	{
		return self::style_formats_check( $settings, [
			[
				'title' => 'Overview',

				'items' => [
					[
						'title' => 'Колонка 50%',
						
						'selector' => 'table',

						'classes' => 'legal-column',
					],

					[
						'title' => 'Колонка 33.333%',
						
						'selector' => 'table',

						'classes' => 'legal-column-3',
					],
				],
			],
		] );
	}

	public static function style_formats_contextbox( $settings )
	{
		return self::style_formats_check( $settings, [
			[
				'title' => 'Contextboxes',

				'items' => [
					[
						'title' => 'Contextbox',
						
						'selector' => 'p',
		
						'classes' => 'legal-contextbox',
					],
					[
						'title' => 'Attention',
						
						'selector' => 'p',
		
						'classes' => 'legal-attention',
					],
					[
						'title' => 'Highlight',
						
						'selector' => 'p,ul',
		
						'classes' => 'legal-highlight',
					],
				],
			],
		] );
	}

	public static function style_formats_contextbox( $settings )
	{
		return self::style_formats_check( $settings, [
			[
				'title' => 'Column',

				'items' => [
					[
						'title' => 'Contextbox',
						
						'selector' => 'p',
		
						'classes' => 'legal-contextbox',
					],
					[
						'title' => 'Attention',
						
						'selector' => 'p',
		
						'classes' => 'legal-attention',
					],
					[
						'title' => 'Highlight',
						
						'selector' => 'p,ul',
		
						'classes' => 'legal-highlight',
					],
				],
			],
		] );
	}
}

?>