<?php

class WPMLLangSwitcher
{
    const CSS = [
        'legal-wpml-lang-switcher-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/wpml/wpml-lang-switcher-main.css',
    
            'ver' => '1.0.1',
        ],
    ];

    const CSS_NEW = [
        'legal-wpml-lang-switcher-new' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/wpml/wpml-lang-switcher-new.css',
    
            'ver' => '1.0.1',
        ],

        // 'legal-wpml-lang-switcher-selectors' => [
        //     'path' => LegalMain::LEGAL_URL . '/assets/css/wpml/wpml-lang-switcher-selectors.css',
    
        //     'ver' => '1.0.0',
        // ],
    ];

    public static function register_style()
    {
        if ( TemplateMain::check_new() )
		{
			ToolEnqueue::register_style( self::CSS_NEW );
		}
		else
		{
			ToolEnqueue::register_style( self::CSS );
		}  
    }

    public static function register_inline_style()
    {
		ToolEnqueue::register_inline_style( 'legal-wpml-lang-switcher', self::render_style() );
    }

    const JS = [
        'legal-wpml-lang-switcher' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/wpml/wpml-lang-switcher.js',

            'ver' => '1.0.0',
        ],
    ];

    public static function register_script()
    {
        ToolEnqueue::register_script( self::JS );
    }

    // public static function check_domain_not_restricted()
    // {
    //     return !ToolNotFound::check_domain_restricted();
    // }

    // public static function check_register()
    // {
    //     return self::check_domain_not_restricted();
    // }

    public static function register()
    {
        $handler = new self();

        // [legal-lang-switcher]

        add_shortcode( 'legal-lang-switcher', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        // if ( self::check_register() )
        // {
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
        // }
    }

    private static function get_all()
    {
        return WPMLMain::get_all_languages();
    }

    private static function get_active( &$args )
    {
        // LegalDebug::debug( [
        //     'WPMLLangSwitcher' => 'get_active',

        //     'args' => $args,
        // ] );

        if ( empty( $args ) )
        {
            return [];
        }

        // $args_active = array_column( $args, 'active' );

        // $key = array_search( 1, $args_active );

        $current_code = WPMLMain::current_language();
        
        $args_active = array_column( $args, 'code' );

        $key = array_search( $current_code, $args_active );

        $active = array_splice( $args, $key, 1 );

        // LegalDebug::debug( [
        //     'WPMLLangSwitcher' => 'get_active',

        //     'args_active' => $args_active,

        //     'key' => $key,

        //     'active' => $active,
        // ] );

        return self::map( array_shift( $active ) );
    }

    private static function map( $args )
    {
        if ( ! empty( $args ) )
        {
            return [
                'id' => $args['id'],

                'title' => $args['native_name'],

                'href' => $args['url'],

                'src' => $args['country_flag_url'],

                'alt' => $args['translated_name'] . '-flag',
            ];

            // return [
            //     'id' => 0,

            //     'title' => '',

            //     'href' => '#',

            //     'src' => '',

            //     'alt' => '',
            // ];
        }

        return [];

        // $mapped['id'] = $args['id'];

        // $mapped['title'] = $args['native_name'];

        // $mapped['href'] = $args['url'];

        // $mapped['src'] = $args['country_flag_url'];

        // $mapped['alt'] = $args['translated_name'] . '-flag';

        // return $mapped;
    }

    public static function choises()
    {
        return self::get_all();
    }

    public static function exclude( $languages )
    {
        return WPMLMain::exclude( $languages, WPMLMain::EXCLUDE );
    }

    public static function get_not_found()
    {
        $languages = self::get_all();

        $languages = self::exclude( $languages );

        $args = [];

        foreach ( $languages as $lang )
        {
            $args['languages'][] = self::map( $lang );
        }

        return $args;
    }

    public static function check_choose_your_country()
    {
        return TemplateMain::check_new()

            && MultisiteMain::check_multisite()

            && MultisiteBlog::check_main_domain();
    }

    public static function get_choose_your_country_href()
    {
        if ( MultisiteMain::check_multisite() )
        {
            $main_blog_id = MultisiteBlog::get_main_blog_id();

            $siteurl = MultisiteBlog::get_siteurl( $main_blog_id );

            return $siteurl . '/choose-your-country/';
        }

        return LegalMain::LEGAL_ROOT . '/choose-your-country/';
    }

    public static function get_choose_your_country()
    {
        // if ( TemplateMain::check_new() )
        
        if ( self::check_choose_your_country() )
        {
            return [
                'suffix' => __( BaseMain::TEXT[ 'change-country' ], ToolLoco::TEXTDOMAIN ),
    
                'class' => 'legal-new',

                // 'href' => LegalMain::LEGAL_ROOT . '/choose-your-country/',
                
                'href' => self::get_choose_your_country_href(),
            ];
        }

        return [];
    }

    public static function get()
    {
        $args = [];

        $languages = self::get_all();

        LegalDebug::debug( [
            'WPMLLangSwitcher' => 'get',

            'step' => 'get-1',
            
            'languages' => count( $languages ),

            // 'languages' => $languages,

            // 'check_wpml_off' => WPMLMain::check_wpml_off(),
        ] );

        // if ( WPMLMain::check_wpml_off() )
        
        if ( MultisiteMain::check_multisite() && MultisiteBlog::check_main_domain() && MultisiteBlog::check_not_main_blog() )
        {
            if ( empty( $languages ) )
            {
                $languages = WPMLDB::multisite_all_languages();
    
                LegalDebug::debug( [
                    'WPMLLangSwitcher' => 'get',

                    'step' => 'get-2',
                    
                    'languages' => count( $languages ),

                    // 'languages' => $languages,
    
                    // 'native_name' => array_column( $languages, 'native_name' ),
                    
                    // 'translated_name' => array_column( $languages, 'translated_name' ),
                ] );
            }
        }

        if ( MultisiteMain::check_multisite() )
        {
            // $multisite_languages = MultisiteSiteSwitcher::get_languages();

            // // $multisite_page_languages = MultisiteHreflang::prepare_languages();

            // LegalDebug::debug( [
            //     'WPMLLangSwitcher' => 'get',
                
            //     'multisite_languages-count' => count( $multisite_languages ),
    
            //     'multisite_languages' => $multisite_languages,

            //     // 'multisite_page_languages' => $multisite_page_languages,

            //     // 'empty-languages' => empty( $languages ),
            // ] );

            // if ( empty( $languages ) )
            // {
            //     // $languages = MultisiteSiteSwitcher::get_languages();
                
            //     $languages = $multisite_languages;
            // }
            // else
            // {
            //     $languages = MultisiteSiteSwitcher::get_combined_languages( $languages, $multisite_languages );
            // }

            if ( MultisiteBlog::check_main_domain() )
            {
                $page_languages = MultisiteHreflang::prepare_languages();

                $languages = MultisiteSiteSwitcher::get_combined_languages( $languages, $page_languages );

                // LegalDebug::debug( [
                //     'WPMLLangSwitcher' => 'get',
        
                //     'page_languages-count' => count( $page_languages ),

                //     'languages-count' => count( $languages ),

                //     // 'languages' => $languages,
                // ] );
            }
            else
            {
                $multisite_languages = MultisiteSiteSwitcher::get_languages();

                $languages = $multisite_languages;
    
                // LegalDebug::debug( [
                //     'WPMLLangSwitcher' => 'get',
                    
                //     'multisite_languages-count' => count( $multisite_languages ),
        
                //     // 'multisite_languages' => $multisite_languages,
        
                //     'languages' => count( $languages ),
                // ] );
            }
        }

        // LegalDebug::debug( [
        //     'WPMLLangSwitcher' => 'get',

        //     // 'check_multisite' => MultisiteMain::check_multisite(),

        //     // 'subsite_languages' => $subsite_languages,

        //     // 'languages' => $languages,

        //     'native_name' => array_column( $languages, 'native_name' ),

        //     'translated_name' => array_column( $languages, 'translated_name' ),
        // ] );

        // LegalDebug::debug( [
        //     'WPMLLangSwitcher' => 'get',

        //     // 'languages' => $languages,
            
        //     'languages' => $languages[ 'en' ],
        // ] );

        // $multisite_sites_list = MultisiteSiteswitcher::get_sites_list();

        // $post = get_post();

        // $items = MultisiteHreflang::get_group_items_all( $post->ID );

        // LegalDebug::debug( [
        //     'WPMLLangSwitcher' => 'get',

        //     'languages' => $languages,

        //     // 'items' => $items,

        //     // 'multisite_languages' => $multisite_languages,

        //     // 'multisite_sites_list' => $multisite_sites_list,
        // ] );

        // LegalDebug::debug( [
        //     'WPMLLangSwitcher' => 'get',

        //     'languages' => $languages,
        // ] );

        $active = self::get_active( $languages );

        if ( ! empty( $active ) )
        {
            // $args[ 'active' ] = array_merge( $active, self::get_data() );
            
            $args[ 'active' ] = $active;

            $args[ 'choose-your-country' ] = self::get_choose_your_country();
        }

        // $args['active'] = array_merge( self::get_active( $languages ), self::get_data() );

        $avaible = self::exclude( $languages );

        foreach ( $avaible as $lang )
        {
            $args[ 'languages' ][] = self::map( $lang );
        }

        // LegalDebug::debug( [
        //     'WPMLLangSwitcher' => 'get',

        //     'args' => $args,
        // ] );

        return $args;
    }
    
    const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/wpml/wpml-lang-switcher-main.php',

        'style' => LegalMain::LEGAL_PATH . '/template-parts/wpml/wpml-lang-switcher-style.php',
    ];

    public static function check_render()
    {
        return self::check_domain_not_restricted();
    }

    public static function render()
    {
        // if ( self::check_register() )
        // {
            return LegalComponents::render_main( self::TEMPLATE[ 'main' ], self::get() );
        // }

        // return '';
    }

    public static function render_style()
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'style' ], self::get() );
    }
}

?>