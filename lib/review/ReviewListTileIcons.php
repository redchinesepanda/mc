<?php

class ReviewListTileIcons
{
	const CLASSES = [
		'default' => 'mc-list-tile-icons',
	];

	const CSS = [
        'review-list-tile-icons' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-list-tile-icons.css',

            'ver'=> '1.0.1',
        ],
    ];

	public static function check_contains_list_tile_icons()
    {
        return LegalComponents::check_contains( self::CLASSES[ 'default' ] );
    } 

	public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
    }

	public static function register()
    {
        if ( self::check_contains_list_tile_icons() )
        {
            $handler = new self();
    
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
        }
    }

	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_list_tile_icons' ] );
	}

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