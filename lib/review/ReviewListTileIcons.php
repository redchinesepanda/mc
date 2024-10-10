<?php

class ReviewListTileIcons
{
	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_list_tile_icons' ] );
	}
	
	const CLASSES = [
		'default' => 'mc-list-tile-icons',
	];

	public static function style_formats_list_tile_icons( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Список Плитка с Иконками',

				'items' => [
					[
						'title' => 'Плитка с Иконками',
						
						'selector' => 'ul',

						'classes' => implode( ' ', [
							self::CLASSES[ 'default' ],
						] ),
					],
				],
			],
		] );
	}
}

?>