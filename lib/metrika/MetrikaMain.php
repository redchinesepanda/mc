<?php

class MetrikaMain
{
	const JS = [
        'legal-metrika' => LegalMain::LEGAL_URL . '/assets/js/metrika/metrika.js',
    ];

    public static function register_script()
    {
		ToolEnqueue::register_script( self::JS );
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }
}

?>