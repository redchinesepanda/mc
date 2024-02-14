<?php

class CompilationPage
{
    const CSS = [
        'compilation-page' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-page.css',

            'ver'=> '1.0.0',
        ],
    ];

    const CSS_NEW = [
        'compilation-page' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-page-new.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        if ( TemplateMain::check_new() )
        {
            CompilationMain::register_style( self::CSS_NEW );
        }
        else
        {
            CompilationMain::register_style( self::CSS );
        }
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-page.php',

        'new' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-page-new.php',
    ];

    public static function render()
    {
        if ( TemplateMain::check_new() )
        {
            return self::render_main( self::TEMPLATE[ 'new' ], [] );
        }

        return self::render_main( self::TEMPLATE[ 'main' ], [] );
    }

    public static function render_main( $template, $args )
    {
        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>