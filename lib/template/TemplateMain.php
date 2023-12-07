<?php

// require_once( 'TemplateBonus.php' );

// require_once( 'TemplateWiki.php' );

require_once( 'TemplateNotFound.php' );

require_once( 'TemplatePage.php' );

require_once( 'TemplateSingle.php' );

class TemplateMain
{
    const CURRENT_LANGUAGE = [
        'pt',

        'kz',
    ];

    public static function check_code()
    {
        return in_array( WPMLMain::current_language(), self::CURRENT_LANGUAGE );
    }

    const DEQUEUE = [
        'thrive-theme-styles',

        'thrive-theme',

        'child-style',

        'parent-style',

        // 'global-styles-inline',

        'tve-logged-in-style',

        'wpml-legacy-dropdown-click-0',

        'wpml-legacy-horizontal-list-0',

        'wpml-legacy-horizontal-list-0-inline',

        'wpml-menu-item-0',
    ];

    const CSS = [
        'legal-template-main' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-main.css',

			'ver' => '1.0.2',
		],
    ];

    public static function register_style()
    {
        if ( self::check() )
        {
            ToolEnqueue::register_style( self::CSS );
        }
    }

    const JS = [
        'legal-template-thrive-oops' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/template/template-thrive-oops.js',

            'ver' => '1.0.0',
        ],

        'legal-template-thrive-title' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/template/template-thrive-title.js',

            'ver' => '1.0.0',
        ],
    ];

    public static function register_script()
    {
		if ( !self::check() )
        {
            ToolEnqueue::register_script( self::JS );
        }
    }

    public static function dequeue_style()
    {
        if ( self::check_dequeue() )
        {
            ToolEnqueue::dequeue_style( TemplateMain::DEQUEUE );
        }
    }

    public static function check_dequeue()
    {
        return self::check() && self::check_code();
    }

    public static function check()
    {
        return TemplatePage::check_page() || TemplateSingle::check_single();
    }

    public static function tcb_optimized_assets( $is_optimized, $post_id = 0 )
    {
        return !self::check();
    }

    public static function disable_lightspeed_option( $value )
    {
        return 0;
    }

    public static function register_thrive()
    {
        $handler = new self();

        // remove_action( 'wp_head', [ '\TCB\Lightspeed\Hooks', 'insert_optimization_script' ], - 24 );

        if ( class_exists( '\TCB\Lightspeed\Main' ) )
        {
            $option = \TCB\Lightspeed\Main::ENABLE_LIGHTSPEED_OPTION;

            $value = get_option( $option );

            LegalDebug::debug( [
                'function' => 'TemplateMain::register',

                'option' => $option,

                'value' => $value,
            ] );

            add_filter( "option_{$option}", [ $handler, 'disable_lightspeed_option' ] ); 

            $value = get_option( $option );

            LegalDebug::debug( [
                'function' => 'TemplateMain::register',

                'option' => $option,

                'value' => $value,
            ] );
        }
    }

    public static function register_function()
    {
        $handler = new self();

        add_action( 'init', [ $handler, 'register_thrive' ] );
    }
    public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'dequeue_style' ], 99 );

		add_action( 'tcb_lightspeed_has_optimized_assets', [ $handler, 'tcb_optimized_assets' ] );

        TemplatePage::register();

        TemplateSingle::register();
    }

    public static function render()
    {
        return TemplateSingle::render();
    }
    
    public static function render_page()
    {
        return TemplatePage::render();
    }

    public static function render_notfound()
    {
		return TemplateNotFound::render();
    }

    public static function wp_head()
    {
		ob_start();
		
		wp_head();

        $output = ob_get_clean();

        $output = str_replace(
			" />",

			">",

			$output
		);

        $output = str_replace(
			" type='text/css'",

			"",

			$output
		);

        $output = str_replace(
			" type='text/javascript'",

			"",

			$output
		);

        return $output;
    }
}

?>