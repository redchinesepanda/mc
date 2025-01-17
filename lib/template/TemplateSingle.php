<?php

class TemplateSingle
{
	const CSS = [
        'legal-template-single' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-single.css',

			'ver' => '1.0.0',
		],

        // 'legal-template-single-bonus' => [
		// 	'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-single-bonus.css',

		// 	'ver' => '1.0.7',
		// ],

        // 'legal-template-single-wiki' => [
		// 	'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-single-wiki.css',

		// 	'ver' => '1.0.7',
		// ],
    ];

	public static function register_style()
    {
        if ( self::check_single() )
        {
            ToolEnqueue::register_style( self::CSS );
        }
        // else
        // {
        //     TemplateMain::register_style_thrive();
        // }

        // if ( self::check_bonus() )
        // {
        //     ToolEnqueue::register_style( [ 'legal-template-single-bonus' => self::CSS[ 'legal-template-single-bonus' ] ] );
        // }

        // if ( self::check_wiki() )
        // {
        //     ToolEnqueue::register_style( [ 'legal-template-single-wiki' => self::CSS[ 'legal-template-single-wiki' ] ] );
        // }
    }

	// public static function dequeue_style()
    // {
    //     if ( self::check_single() )
    //     {
    //         ToolEnqueue::dequeue_style( TemplateMain::DEQUEUE );
    //     }
    // }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        // add_action( 'wp_enqueue_scripts', [ $handler, 'dequeue_style' ], 99 );
    }

    public static function check_bonus()
    {
        return LegalComponents::check_category( LegalComponents::TERMS_BONUS )
            
            && LegalComponents::check_not_admin();
    }

    public static function check_wiki()
    {
        return LegalComponents::check_taxonomy( LegalComponents::TERMS_WIKI )
            
            && LegalComponents::check_not_admin();
    }

    public static function check_single()
    {
        return self::check_bonus() || self::check_wiki();
    }

	const TEMPLATE = [
        'single-bonus' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-single-bonus.php',

        'single-wiki' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-single-wiki.php',

        'single-thrive' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-single-thrive.php',
    ];

    public static function render()
    {
        if ( self::check_bonus() )
        {
            return self::render_bonus();
        }

        if ( self::check_wiki() )
        {
            return self::render_wiki();
        }

        return self::render_thrive();
    }

    public static function render_bonus()
    {
		return self::render_main( self::TEMPLATE[ 'single-bonus' ] );
    }

    public static function render_wiki()
    {
		return self::render_main( self::TEMPLATE[ 'single-wiki' ] );
    }

    public static function render_thrive()
    {
		return self::render_main( self::TEMPLATE[ 'single-thrive' ] );
    }

    public static function render_main( $template, $args = [] )
    {
        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>