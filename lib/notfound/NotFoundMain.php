<?php

class NotFoundMain
{
	const CSS = [
        'legal-notfound' => LegalMain::LEGAL_URL . '/assets/css/notfound/notfound.css',
    ];

    public static function register_style()
    {
		if ( self::check() ) {
			ToolEnqueue::register_style( self::CSS );
		}
    }

	public static function check()
    {
        return is_404();
    }

	public static function register()
    {
        $handler = new self();

		// [legal-notfound]

        add_shortcode( 'legal-notfound', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	public static function get()
	{
		return  [
			'title' => __( "Oops! Page Not Found", ToolLoco::TEXTDOMAIN ),
			
			'description' => __( "You must have picked the wrong door because I haven't been able to lay my eye on the page you've been searching for.", ToolLoco::TEXTDOMAIN ),

			'languages' => WPMLLangSwitcher::get(),
		];
	}

	const TEMPLATE = [
        'notfound' => LegalMain::LEGAL_PATH . '/template-parts/notfound/part-notfound-main.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'notfound' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>