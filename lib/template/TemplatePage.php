<?php

class TemplatePage
{
	const CSS = [
        'legal-template-page' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-page.css',

			'ver' => '1.0.0',
		],
    ];

	public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TEMPLATE = [
        'legal-template-page' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-page.php',
    ];

	public static function render()
    {
		// if ( !BonusMain::check() )
        // {
        //     return '';
        // }

        ob_start();
		
		load_template( self::TEMPLATE[ 'legal-template-page' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>