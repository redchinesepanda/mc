<?php

class WPMLChooseYourCountry
{
    const CSS = [
        'wpml-choose-your-country' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/wpml/wpml-choose-your-country.css',

			'ver' => '1.0.1',
		],
    ];

    const CSS_NEW = [
        'wpml-choose-your-country' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/wpml/wpml-choose-your-country-new.css',

			'ver' => '1.0.0',
		],
    ];

	/* public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
    } */

    public static function register_style()
    {
		if ( TemplateMain::check_new() )
		{
			ToolEnqueue::register_style( self::CSS_NEW );
		}
		else
		{
			ToolEnqueue::register_style( self::CSS );
		}
    }

	const SHORTCODE = [
		'chose' => 'legal-choose-your-country',
	];

	public static function register()
    {
        $handler = new self();

		// [legal-choose-your-country]

        add_shortcode( self::SHORTCODE[ 'chose' ], [ $handler, 'render' ] );

        if ( self::check_contains_choose_your_country() )
        {
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
        }
    }

	const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/wpml/wpml-choose-your-country.php',
    ];

	public static function render()
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'main' ], [] );
    }

    public static function check_contains_choose_your_country()
    {
        return LegalComponents::check_shortcode( self::SHORTCODE[ 'chose' ] );
        
		// return LegalComponents::check_contains( self::SHORTCODE[ 'mega' ] );
    } 
}

?>