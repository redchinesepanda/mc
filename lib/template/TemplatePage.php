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
        'legal-template-page-review' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-page-review.php',

        'legal-template-page-compilation' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-page-compilation.php',

        'legal-template-page-thrive' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-page-thrive.php',
    ];

    public static function render_main( $template, $args = [] )
    {
        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }

    public static function render_review()
    {
		if ( !ReviewMain::check() )
        {
            return '';
        }

        return self::render_main( self::TEMPLATE[ 'legal-template-page-review' ] );
    }

    public static function render_review()
    {
		if ( !CompilationMain::check() )
        {
            return '';
        }

        return self::render_main( self::TEMPLATE[ 'legal-template-page-compilation' ] );
    }

    public static function render_wiki_thrive()
    {
		if ( !WikiMain::check_thrive() )
        {
            return '';
        }

        return self::render_main( self::TEMPLATE[ 'legal-template-wiki-thrive' ] );
    }
}

?>