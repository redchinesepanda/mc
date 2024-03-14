<?php

class MetrikaMain
{
	const JS = [
        'legal-metrika-ya-lib' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika-ya-lib.js',

            'ver' => '1.0.0',
        ],

        'legal-metrika-ya-go' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika-ya-go.js',

            'ver' => '1.0.0',

            'deps' => [
                'legal-metrika-ya-lib',
            ],
        ],

        'legal-metrika-ya-oops' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika-ya-oops.js',

            'ver' => '1.0.0',
        ],

        'legal-gtag-lib' => [
            'path' => 'https://www.googletagmanager.com/gtag/js?id=UA-224707123-1',

            'ver' => '1.0.0',
        ],

        'legal-gtag-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika-gtag-main.js',

            'ver' => '1.0.0',
            
            'deps' => [
                'legal-gtag-lib',
            ],
        ],

        'legal-gtag-launch' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika-gtag-launch.js',

            'ver' => '1.0.0',

            'deps' => [
                'legal-gtag-lib',
            ],
        ],
    ]; 

	public static function register_script( $scripts = [] )
    {
		if ( empty( $scripts ) ) {
			$scripts = self::JS;
		}

        if ( self::check() ) {
            ToolEnqueue::register_script( $scripts );
        }
    }

	public static function check()
    {
        $permission_admin = !is_admin();

        $permission_loggedin = !is_user_logged_in();
        
        return ( $permission_admin && $permission_loggedin );
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_action( 'wp_body_open', [ $handler, 'body_open_counter' ] );
    }

    public static function body_open_counter()
    {
        echo self::render_counter();
    }

    const TEMPLATE = [
        'counter' => LegalMain::LEGAL_PATH . '/template-parts/metrika/legal-metrika-counter.php',
    ];

    public static function render_counter()
    {
		ob_start();

        load_template( self::TEMPLATE[ 'counter' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>