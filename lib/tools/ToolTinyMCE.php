<?php

class ToolTinyMCE
{
    public static function register()
    {
        $handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'table_classes' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'table_cell_classes' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_overview' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_header' ] );
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

	public static function style_formats_overview( $settings )
	{
		$settings[ 'style_formats' ] = json_encode( [
			[
				'title' => 'Overview Start',
				
				'selector' => 'p',

				'classes' => 'legal-overview-start',
			],

			[
				'title' => 'Overview',
				
				'selector' => 'p',

				'classes' => 'legal-overview',
			],

			[
				'title' => 'Overview End',
				
				'selector' => 'p',

				'classes' => 'legal-overview-end',
			],
		] );

		return $settings;
	}

	public static function style_formats_header( $settings )
	{
		// $settings[ 'style_formats' ] = json_encode( [
		
		$style_formats_header = [
			[
				'title' => 'H3 History',
				
				'block' => 'h3',

				'classes' => 'legal-header-3 legal-header-history',
			],

			[
				'title' => 'H3 Features',
				
				'block' => 'h3',

				'classes' => 'legal-header-3 legal-header-features',
			],

			[
				'title' => 'H3 Football',
				
				'block' => 'h3',

				'classes' => 'legal-header-3 legal-header-football',
			],

			[
				'title' => 'H3 Tennis',
				
				'block' => 'h3',

				'classes' => 'legal-header-3 legal-header-tennis',
			],

			[
				'title' => 'H3 Basketball',
				
				'block' => 'h3',

				'classes' => 'legal-header-3 legal-header-basketball',
			],
		];

		// ] );

		$style_formats = [];

		if ( !empty( $settings[ 'style_formats' ] ) ) {
			$style_formats = json_decode( $settings[ 'style_formats' ] );
		}

		$settings[ 'style_formats' ] = json_encode( array_merge( $style_formats, $style_formats_header ) );

		return $settings;
	}
}

?>