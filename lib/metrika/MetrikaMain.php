<?php

class MetrikaMain
{
	const JS_MAIN = [
        'legal-metrika-lib' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika-lib.js',

            'ver' => '1.0.0',
        ],
    ];

	const JS_GUEST = [
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

        // 'legal-gtag-lib' => [
        //     'path' => 'https://www.googletagmanager.com/gtag/js?id=UA-224707123-1',

        //     'ver' => '1.0.0',
        // ],

        // 'legal-metrika-lib' => [
        //     'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika-lib.js',

        //     'ver' => '1.0.0',
        // ],

        'legal-gtag-lib' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika-gtag-lib.js',

            'ver' => '1.0.0',

            // 'deps' => [
            //     'legal-metrika-lib',
            // ],
        ],

        'legal-gtag-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika-gtag-main.js',

            'ver' => '1.0.0',
            
            // 'deps' => [
            //     'legal-gtag-lib',
            // ],
        ],

        'legal-gtag-launch' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika-gtag-launch.js',

            'ver' => '1.0.0',

            // 'deps' => [
            //     'legal-gtag-lib',
            // ],
        ],
    ]; 

	// public static function register_script( $scripts = [] )
	
    public static function register_script()
    {
		// if ( empty( $scripts ) ) {
		// 	$scripts = self::JS;
		// }

        if ( self::check_not_admin() )
        {
            ToolEnqueue::register_script( self::JS_MAIN );
        }

        if ( self::check_guest() )
        {
            // ToolEnqueue::register_script( $scripts );

            ToolEnqueue::register_script( self::JS_GUEST );
        }
    }

	public static function check_not_admin()
    {
        return !is_admin();
    }

	public static function check_not_logged_in()
    {
        return !is_user_logged_in();
    }

	public static function check_guest()
    {
        // $permission_admin = !is_admin();

        // $permission_loggedin = !is_user_logged_in();
        
        // return ( $permission_admin && $permission_loggedin );
        
        return self::check_not_admin()

            && self::check_not_logged_in();
    }

    public static function check()
    {
        return self::check_guest();
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