<?php

class MetrikaMain
{
	const JS = [
        'legal-metrika' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika.js',
    ];

	public static function register_script( $scripts = [] )
    {
		if ( empty( $scripts ) ) {
			$scripts = self::JS;
		}

		// LegalDebug::debug( [
		// 	'check' => ( self::check() ? 'true' : 'false' ),
		// ] );

        if ( self::check() ) {
            ToolEnqueue::register_script( $scripts );
        }
    }

	public static function check()
    {
        $permission_admin = !is_admin();

        $permission_loggedin = !is_user_logged_in();

		LegalDebug::debug( [
			'is_admin' => ( is_admin() ? 'true' : 'false' ),

			'permission_admin' => ( $permission_admin ? 'true' : 'false' ),

			'is_user_logged_in' => ( is_user_logged_in() ? 'true' : 'false' ),

			'permission_loggedin' => ( $permission_loggedin ? 'true' : 'false' ),
		] );
        
        return ( $permission_admin && $permission_loggedin );
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }
}

?>