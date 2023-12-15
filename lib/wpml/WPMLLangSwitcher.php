<?php

class WPMLLangSwitcher
{
    const CSS = [
        'legal-wpml-lang-switcher' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/wpml/wpml-lang-switcher.css',
    
            'ver' => '1.0.1',
        ],
    ];

    public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
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

    public static function register() {
        $handler = new self();

        // [legal-lang-switcher]

        add_shortcode( 'legal-lang-switcher', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    private static function get_all() {
        return WPMLMain::get_all_languages();
    }

    private static function get_active( &$args )
    {
        $args_active = array_column( $args, 'active' );

        $key = array_search( 1, $args_active );

        $active = array_splice( $args, $key, 1 );

        return self::map( array_shift( $active ) );
    }

    private static function map( $args )
    {
        $mapped['id'] = $args['id'];

        $mapped['title'] = $args['native_name'];

        $mapped['href'] = $args['url'];

        $mapped['src'] = $args['country_flag_url'];

        $mapped['alt'] = $args['translated_name'] . '-flag';

        return $mapped;
    }

    // const EXCLUDE = [
    //     'pt_GB',

    //     'pt_ES',

    //     'sr_SR',

    //     'se_SE',

    //     'cs_CS',

    //     'en',

    //     'es',

    //     'ru',

    //     'dk_DA',

    //     'pt_BP',
    // ];

    public static function choises()
    {
        return self::get_all();
    }

    public static function exclude( $languages )
    {
        // return WPMLMain::exclude( $languages, self::EXCLUDE );
        
        return WPMLMain::exclude( $languages, WPMLMain::EXCLUDE );
    }

    public static function get_not_found()
    {
        $languages = self::get_all();

        // LegalDebug::debug( [
        //     'function' => 'WPMLLangSwitcher::get_not_found',

        //     'languages' => $languages,
        // ] );

        $languages = self::exclude( $languages );

        // LegalDebug::debug( [
        //     'function' => 'WPMLLangSwitcher::get_not_found',

		// 	'languages' => $languages,
		// ] );

        foreach ( $languages as $lang ) {
            $args['languages'][] = self::map( $lang );
        }

        return $args;
    }

    public static function get_data()
    {
        if ( TemplateMain::check_new() )
        {
            return [
                'suffix' => __( BaseMain::TEXT[ 'change-country' ], ToolLoco::TEXTDOMAIN ),
    
                'class' => 'legal-new',
            ];
        }

        return [
            'suffix' => '',

            'class' => '',
        ];
    }

    public static function get()
    {
        $languages = self::get_all();

        $args['active'] = array_merge( self::get_active( $languages ), self::get_data() );

        // $args['active'] = self::get_active( $languages );

        // $args['active'][ 'suffix' ] = self::get_suffix();

        // $args['active'][ 'class' ] = self::get_suffix();

        // $languages = WPMLMain::exclude( $languages );

        $languages = self::exclude( $languages );

        foreach ( $languages as $lang ) {
            $args['languages'][] = self::map( $lang );
        }

        return $args;
    }
    
    const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/wpml/wpml-lang-switcher-main.php',

        'style' => LegalMain::LEGAL_PATH . '/template-parts/wpml/wpml-lang-switcher-style.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'main' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

    public static function render_style()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'style' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>