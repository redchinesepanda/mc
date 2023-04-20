<?php

class ToolTinyMCE
{
    public static function register()
    {
        $handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'table_classes' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'table_cell_classes' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats' ] );
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

	public static function style_formats( $settings )
	{
		$settings[ 'style_formats' ] = json_encode( [
			[
				'title' => 'Overview',
				
				'selector' => 'p',

				'classes' => 'legal-overview',
			],
		] );

		return $settings;
	}
}

?>