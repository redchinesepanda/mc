<?php

class ReviewIcons
{
	const CSS = [
		// front icons style 

        'review-icons-style' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-icons.css',

            'ver'=> '1.0.0',
        ],

		// mc-icons style

        'review-icons-style-mc-icons' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/mc-icons/mc-icons.css',

			'ver' => '1.0.0',
		],

		// mc-icons font

		'review-icons-font-mc-icons' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons.css',

			'ver' => '1.0.0',
		],

		// mc-icons-sports style

        'review-icons-style-mc-icons-sports' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/mc-icons-sports/mc-icons-sports.css',

			'ver' => '1.0.0',
		],

		// mc-icons-sports font

		'review-icons-font-mc-icons-sports' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons-sports.css',

			'ver' => '1.0.0',
		],

		// mc-country style

		'review-icons-style-mc-icons-country' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/mc-icons-country/mc-icons-country.css',

			'ver' => '1.0.0',
		],

		// mc-payment style

        'review-icons-style-mc-icons-payment' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/mc-icons-payment/mc-icons-payment.css',

			'ver' => '1.0.0',
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