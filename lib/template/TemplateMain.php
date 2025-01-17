<?php

// require_once( 'TemplateBonus.php' );

// require_once( 'TemplateWiki.php' );

require_once( 'TemplateNotFound.php' );

require_once( 'TemplatePage.php' );

require_once( 'TemplateSingle.php' );

class TemplateMain
{
    // const CURRENT_LANGUAGE_PRODUCTION = [
    //     'br',

    //     'by',

    //     'ca',

    //     'co',

    //     'cz',

    //     'dk',

    //     'es',

    //     'kz',

    //     'mx',

    //     'ng',

    //     'ph',

    //     'pl',

    //     'pt',

    //     'ro',

    //     'rs',

    //     'se',
    // ];

    // const CURRENT_LANGUAGE_DEBUG = [
    //     'br',

    //     'by',

    //     'ca',

    //     'co',

    //     'cz',

    //     'dk',

    //     'es',

    //     'kz',

    //     'mx',

    //     'ng',

    //     'ph',

    //     'pl',
        
    //     'pt',

    //     'ro',

    //     'rs',

    //     'ru',

    //     'se',
    // ];

    public static function check_code()
    {
        // $current_language = self::CURRENT_LANGUAGE_DEBUG;

        // if ( LegalMain::check_host_production() )
        
      /*   if ( LegalHosts::check_host_production() )
        {
            $current_language = self::CURRENT_LANGUAGE_PRODUCTION;

            return in_array( WPMLMain::current_language(), $current_language );
        } */

        // return in_array( WPMLMain::current_language(), $current_language );

        return true;
    }

    // public static function check_new_get()
    // {
    //     if ( !LegalHosts::check_host_production() )
    //     {
    //         return !empty( $_GET[ 'new' ] );
    //     }

    //     return false;
    // }

    public static function check_new()
    {
        // return self::check() && self::check_code();
        
        // return ToolRestricted::check_domain_restricted()
            
        //     // || self::check() && self::check_code();
            
        //     || self::check_code();

        // return self::check_code() || self::check_new_get();
        
        // return self::check_code();

        return true;
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

        'thrive-template',

        'thrive-theme-logged-in-style',

        // 'tve_global_variables',
    ];

    const DEQUEUE_GUTENBERG = [
        'wp-block-library',

        'wp-block-library-theme',

        'wc-blocks-style',
    ];

    const DEQUEUE = [
        ...self::DEQUEUE_WP,
        
        ...self::DEQUEUE_WPML,

        ...self::DEQUEUE_THRIVE,
        
        ...self::DEQUEUE_GUTENBERG,
    ];

    public static function dequeue_style()
    {
        // if ( self::check_new() )
        // {
            // LegalDebug::debug( [
            //     'TemplateMain' => 'dequeue_style',

            //     'DEQUEUE' => self::DEQUEUE,
            // ] );

            ToolEnqueue::dequeue_style( self::DEQUEUE );
        // }
    }

    const CSS = [
        'legal-template-main' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-main.css',

			'ver' => '1.0.3',
		],

        // 'legal-template-fallback' => [
		// 	'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-fallback.css',

		// 	'ver' => '1.0.0',
		// ],

        'legal-template-font-source-sans-3' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-source-sans-3.css',

			'ver' => '1.0.1',
		],
    ];

    const CSS_NEW = [
        'legal-template-main-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-main-new.css',

			'ver' => '1.0.4',
		],

        'legal-template-font-main' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-main.css',

			'ver' => '1.0.1',
		],

        'legal-template-font-gotos-text' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-gotos-text.css',

			'ver' => '1.0.1',
		],

        'legal-template-font-mc-icons' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons.css',

			'ver' => '1.0.0',
		],
    ];

    const CSS_THRIVE = [
        'legal-template-thrive' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-thrive.css',

			'ver' => '1.0.2',
		],
    ];

    public static function register_style()
    {
        // if ( self::check() )
        // {
        //     if ( self::check_new() )
        //     {
        //         ToolEnqueue::register_style( self::CSS_NEW );
        //     }
        //     else
        //     {
        //         ToolEnqueue::register_style( self::CSS );
        //     }
        // }
        // else
        // {
        //     ToolEnqueue::register_style( self::CSS_THRIVE );
        // } 

        if ( self::check_new() )
        {
            ToolEnqueue::register_style( self::CSS_NEW );
        }
        else
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
		if ( !self::check() && MetrikaMain::check() )
        {
            ToolEnqueue::register_script( self::JS );
        }
    }

    const JS_DEQUEUE_THRIVE = [
        // 'jquery',

        // 'jquery-migrate',

        // 'jquery-masonry', 

        // 'tve_frontend',
    ];

    const JS_DEQUEUE_WPML = [
        'wpml-legacy-dropdown-click-0',
    ];

    const JS_DEQUEUE = [
        ...self::JS_DEQUEUE_THRIVE,

        ...self::JS_DEQUEUE_WPML,
    ];

    public static function dequeue_script()
    {
        if ( self::check_new() )
        {
            ToolEnqueue::dequeue_script( self::JS_DEQUEUE );
        }
    }

    public static function check()
    {
        return TemplatePage::check_page() || TemplateSingle::check_single();
    }

    public static function tcb_optimized_assets( $is_optimized, $post_id = 0 )
    {
        return !self::check();
    }

    // public static function disable_lightspeed_option( $value )
    // {
    //     return 0;
    // }

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

    public static function return_empty_array( $fonts_import )
    {
        return [];
    }

    public static function register_thrive()
    {
        $handler = new self();

		add_action( 'tcb_lightspeed_has_optimized_assets', [ $handler, 'tcb_optimized_assets' ] );

        add_filter( 'tcb_css_imports', [ $handler, 'return_empty_array' ] );

        // add_filter( 'tcb_global_colors_list', [ $handler, 'return_empty_array' ] );

        // add_filter( 'thrv_global_gradients', [ $handler, 'return_empty_array' ] );
    }

    public static function register_dequeue()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'dequeue_style' ], 99 );

        if ( self::check_new() )
        {
            self::register_wp();

            self::register_thrive();
        }

        add_action( 'wp_enqueue_scripts', [ $handler, 'dequeue_script' ], 99 ); 
    }

    public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_dequeue' ] );

        add_filter( 'the_content', [ $handler, 'modify_content' ] );

        // self::register_wp();

        // self::register_thrive();

        TemplatePage::register();

        TemplateSingle::register();
    }
    
    public static function modify_content( $content )
    {
        $content = self::change_strong_to_b( $content );

        $content = self::remove_data_attributes( $content );

        $content = self::change_inline_style( $content );

        $content = self::remove_empty_style( $content );

        return $content;
    }

    public static function change_strong_to_b( $content )
    {
        // return preg_replace('/<strong>(.*)<\/strong>/', '<b>$1</b>', $content);
        
        return preg_replace('/<strong>(.*?)<\/strong>/', '<b>$1</b>', $content);
    }

    public static function remove_data_attributes( $content )
    {
        // return preg_replace('/\s*data-(\d|[a-z])+=\"(\d|[a-z])+\"/', '', $content);
        
        // return preg_replace('/\s*data-(.*?)=\"(.*?)\"/', '', $content);
        
        return preg_replace( '/\sdata-(.*?)=\"(.*?)\"/', '', $content) ;
    }

    public static function change_inline_style( $content )
    {
        return str_replace( 'border-collapse: collapse;', '', $content );
    }

    public static function remove_empty_style( $content )
    {
        return str_replace( ' style=""', '', $content );
    }

    public static function render()
    {
        if ( !LegalMain::check_plugins() )
        {
            return 'TemplateMain::render';
        }

        return TemplateSingle::render();
    }
    
    public static function render_page()
    {
        if ( !LegalMain::check_plugins() )
        {
            return 'TemplateMain::render_page';
        }

        return TemplatePage::render();
    }

    public static function render_notfound()
    {
        if ( !LegalMain::check_plugins() )
        {
            return 'TemplateMain::render_notfound';
        }

		return TemplateNotFound::render();
    }

    const REPLACE = [
        'tve_global_variables',

        'thrive-default-styles',

        // 'tcb-style-template-thrive_template-2467980',
    ];

    public static function wp_head_replace_style( $output )
    {
        if ( self::check_new() )
        {
            foreach ( self::REPLACE as $id )
            {
                // $pattern = '/<style type=\"text\/css\" id=\"' . $id . '\">(.+?)<\/style>/i';
                
                $pattern = '/<style type=\"text\/css\" id=\"' . $id . '\"(.+?)<\/style>/i';

                $output = preg_replace( $pattern, '', $output );
            }
        }

        return $output;
    }

    const REPLACE_LINK = [
        // 'tcb-style-base-thrive_template-2467980',
    ];
    
    // <link rel="stylesheet" id="tcb-style-base-thrive_template-2467980" href="//cdn13118.templcdn.com/wp-content/uploads/thrive/tcb-base-css-2467980-1699872370.css" media="all">

    public static function wp_head_replace_link( $output )
    {
        // if ( self::check_new() )
        // {
            foreach ( self::REPLACE_LINK as $id )
            {
                $pattern = '/<link rel=\"stylesheet\" id=\"' . $id . '\" (.+?)>/i';

                $output = preg_replace( $pattern, '', $output );
            }
        // }

        return $output;
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

        $output = self::wp_head_replace_style( $output );

        // $output = self::wp_head_replace_link( $output );

        return $output;
    }

    const REPLACE_ELEMENT = [
        'tve_thrive_lightbox_',
    ];

    public static function wp_footer_replace_element( $output )
    {
        // if ( self::check_new() )
        // {
            foreach ( self::REPLACE_ELEMENT as $id )
            {
                // $pattern = '/<style type=\"text\/css\" id=\"' . $id . '\">(.+?)<\/style>/i';

                $pattern = '/<div id=\"' . $id . '(.+?)\">(.+?)<\/div>/i';

                $output = preg_replace( $pattern, '', $output );
            }
        // }

        return $output;
    }

    public static function wp_footer()
    {
		ob_start();
		
		wp_footer();

        $output = ob_get_clean();

        $output = self::wp_footer_replace_element( $output );

        return $output;
    }
}

?>