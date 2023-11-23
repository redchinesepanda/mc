<?php

class TemplatePage
{
	const CSS = [
        'legal-template-page' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-page.css',

			'ver' => '1.0.0',
		],

        // 'legal-template-page-review' => [
		// 	'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-page-review.css',

		// 	'ver' => '1.0.0',
		// ],

        // 'legal-template-page-compilation' => [
		// 	'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-page-compilation.css',

		// 	'ver' => '1.0.0',
		// ],
    ];

	public static function register_style_thrive()
    {
        if ( !self::check_page() )
        {
            TemplateMain::register_style_thrive();
        }
    }
	public static function register_style()
    {
        if ( self::check_page() )
        {
            ToolEnqueue::register_style( self::CSS );
        }

        // if ( self::check_review() )
        // {
        //     ToolEnqueue::register_style( [ 'legal-template-page-review' => self::CSS[ 'legal-template-page-review' ] ] );
        // }

        // if ( self::check_compilation() )
        // {
        //     ToolEnqueue::register_style( [ self::CSS[ 'legal-template-page-compilation' ] ] );
        // }
    }

    // const DEQUEUE = [
    //     'thrive-theme-styles',

    //     'parent-style',

    //     'thrive-theme',
    // ];

	public static function dequeue_style()
    {
        if ( self::check_page() )
        {
            ToolEnqueue::dequeue_style( self::DEQUEUE );

            LegalDebug::debug( [
                'function' => 'TemplatePage::dequeue_style',
            ] );
        }
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style_thrive' ] );

        // add_action( 'wp_enqueue_scripts', [ $handler, 'dequeue_style' ], 99 );
    }

    public static function check_review()
    {
        return LegalComponents::check_taxonomy( LegalComponents::TERMS_REVIEW )

            && LegalComponents::check_not_admin()
            
            || LegalComponents::check_not_found();
    }

    public static function check_compilation()
    {
        return LegalComponents::check_taxonomy( LegalComponents::TERMS_COMPILATION )

            && LegalComponents::check_not_admin();
    }

    public static function check_page()
    {
        return self::check_review() || self::check_compilation();
    }

	const TEMPLATE = [
        'legal-template-page-review' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-page-review.php',

        'legal-template-page-compilation' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-page-compilation.php',

        'legal-template-page-thrive' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-page-thrive.php',
    ];

    public static function render()
    {
        if ( self::check_review() )
        {
            return self::render_review();
        }

        if ( self::check_compilation() )
        {
            return self::render_compilation();
        }

        return self::render_thrive();
    }

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

    public static function render_compilation()
    {
		if ( !CompilationMain::check() )
        {
            return '';
        }

        return self::render_main( self::TEMPLATE[ 'legal-template-page-compilation' ] );
    }

    public static function render_thrive()
    {
		return self::render_main( self::TEMPLATE[ 'legal-template-page-thrive' ] );
    }
}

?>