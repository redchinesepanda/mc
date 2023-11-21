<?php

class CompilationTemplatePage
{
    const CSS = [
        'compilation-page' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-page.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        CompilationMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TEMPLATE = [
        'legal-compilation-page' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-page.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'legal-compilation-page' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>