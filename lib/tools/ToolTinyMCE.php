<?php

class ToolTinyMCE
{
    public static function register()
    {
        $handler = new self();

		add_filter('tiny_mce_before_init', [ $handler, 'table_classes' ] );
    }

	public static function table_classes( $settings )
	{
		$styles = [
			[
				'title' => 'По умолчанию',
				'value' => ''
			],
			[
				'title' => 'Ряд и Столбец',
				'value' => 'legal-raw-column',
			],
			[
				'title' => 'Ряд',
				'value' => 'legal-raw',
			],
		];

		$settings[ 'table_class_list' ] = json_encode( $styles );

		return $settings;
	}
}

?>