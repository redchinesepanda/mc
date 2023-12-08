<?php

class ReviewCut
{
	public static function register_functions()
	{
		$handler = new self();

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