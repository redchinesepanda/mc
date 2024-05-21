<?php

class LegalTabsInfo
{
    const CSS = [
        'legal-tabs-info' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/tabs/legal-tabs-info.css',

			'ver' => '1.0.1',
		],
    ];

	public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
    }

	const SHORTCODE = [
		'info' => 'legal-tabs-info',
	];

	public static function register()
    {
        $handler = new self();

		// [legal-tabs-info]

        add_shortcode( self::SHORTCODE[ 'info' ], [ $handler, 'render' ] );

        if ( self::check_contains_choose_your_country() )
        {
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
        }
    }

	const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/tabs/legal-tabs-info.php',
    ];

	public static function render()
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'main' ], [] );
    }

    public static function check_contains_choose_your_country()
    {
        return LegalComponents::check_shortcode( self::SHORTCODE[ 'info' ] );
        
		// return LegalComponents::check_contains( self::SHORTCODE[ 'mega' ] );
    } 
}

?>