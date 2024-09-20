<?php

class ReviewIcons
{
	const CSS = [
        'review-icons' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-icons.css',

            'ver'=> '1.0.0',
        ],

        'front-tinymce-iconpicker-icons' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons-sports.css',

			'ver' => '1.0.0',
		],

		'front-tinymce-iconpicker-font-mc-icons-sports' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-main.css',

			'ver' => '1.0.1',
		],
    ];

	public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
    }

	public static function check_contains_mc_icons_sports()
	{
		return LegalComponents::check_contains( '<i class="mc-icons-sports' );
	}

	public static function register()
    {
        // if ( self::check_contains_mc_icons_sports() )
        // {
            $handler = new self();

			add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
        // }
    }
}

?>