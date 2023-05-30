<?php

class BaseFooter
{
	const CSS = [
        'legal-footer' => LegalMain::LEGAL_URL . '/assets/css/base/footer.css',
    ];

    public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'init', [ $handler, 'location' ] );

		// [legal-footer]

        add_shortcode( 'legal-footer', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		// add_filter( 'wp_nav_menu_objects', [ $handler, 'image' ], 10, 2 );
    }

	const LOCATION = 'legal-footer';

	public static function location()
	{
		register_nav_menu( self::LOCATION, __( 'Legal Review BK Footer', ToolLoco::TEXTDOMAIN ) );
	}

	public static function get()
	{
		$args = [];

		$menu_id_translated = BaseMain::get_menu_id( self::LOCATION );

		LegalDebug::debug( [
			'menu_id_translated' => $menu_id_translated,
		] );

		$args = [
			'copy' => [
				'year' => '2021-2023',
				
				'company' => 'Match.Center',
				
				'reserved' => 'All rights reserved'
			],

			'text' => [
				'Match.Center is not a gambling operator (we do not accept any bets). The content of this website is strictly for information purposes and does not constitute advice. We only review gambling operators who are licenced by their respective local and international regulators. We only claim information to be correct at the time of posting.',

				'Always gamble responsibly and never risk money that you can not afford to lose!'
			],
		]; 

		return $args;
	}

	const TEMPLATE = [
        'footer' => LegalMain::LEGAL_PATH . '/template-parts/base/part-footer.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'footer' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>