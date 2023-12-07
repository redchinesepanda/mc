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

    const DEQUEUE_WP = [
        'classic-theme-styles',

        'global-styles',
    ];

    const DEQUEUE_WPML = [
        'wpml-legacy-dropdown-click-0',

        'wpml-legacy-horizontal-list-0',

        'wpml-legacy-horizontal-list-0-inline',

        'wpml-menu-item-0',
    ];

    const DEQUEUE_THRIVE = [
        'thrive-theme-styles',

        'thrive-theme',

        'child-style',

        'parent-style',

        'tve-logged-in-style',

        'tve_style_family_tve_flt',
    ];

    const DEQUEUE_GUTENBERG = [
        'wp-block-library',

        'wp-block-library-theme',

        'wc-blocks-style',
    ];

    const DEQUEUE = [
        ...self::DEQUEUE_THRIVE,
        
        ...self::DEQUEUE_GUTENBERG,
        
        ...self::DEQUEUE_WPML,

        ...self::DEQUEUE_WP,
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

    public static function register_emoji()
    {
        remove_action( 'admin_print_styles', 'print_emoji_styles' );

        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

        remove_action( 'wp_print_styles', 'print_emoji_styles' );

        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );

        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

        add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
    }

    public static function register_wp()
    {
        self::register_emoji();
    }

    public static function register_thrive()
    {
        $handler = new self();

		add_action( 'tcb_lightspeed_has_optimized_assets', [ $handler, 'tcb_optimized_assets' ] );

        // remove_action( 'wp_head', [ '\TCB\Lightspeed\Hooks', 'insert_optimization_script' ], - 24 );

        // if ( class_exists( '\TCB\Lightspeed\Main' ) )
        // {
        //     $option = \TCB\Lightspeed\Main::ENABLE_LIGHTSPEED_OPTION;
            
        //     add_filter( "pre_option_{$option}", [ $handler, 'disable_lightspeed_option' ] );

        //     $value = get_option( $option );

        //     LegalDebug::debug( [
        //         'function' => 'TemplateMain::register',

        //         'option' => $option,

        //         'value' => $value,
        //     ] );

        //     add_filter( "option_{$option}", [ $handler, 'disable_lightspeed_option' ] ); 

        //     $value = get_option( $option );

        //     LegalDebug::debug( [
        //         'function' => 'TemplateMain::register',

        //         'option' => $option,

        //         'value' => $value,
        //     ] );
        // }
    }

    // public static function register_functions()
    // {
    //     $handler = new self();

    //     add_action( 'after_setup_theme', [ $handler, 'register_thrive' ] );
    // }

    public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'dequeue_style' ], 99 );

        self::register_wp();

        self::register_thrive();

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