<?php

class MetrikaMain
{
	const JS = [
        'legal-metrika' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika.js',

            'ver' => '1.0.0',
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
    }
}

?>