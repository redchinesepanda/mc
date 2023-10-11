<?php

class CompilationTabs
{
    const HANDLE = [
        'main' => 'tabs-main',

        'style' => 'tabs-style',
    ];

    const CSS = [
        self::HANDLE[ 'main' ] => LegalMain::LEGAL_URL . '/assets/css/tabs/tabs-main.css',
    ];

	public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            if ( empty( $styles ) ) {
                $styles = self::CSS;
            }

            ToolEnqueue::register_style( $styles );
        }
    }

    public static function register_inline_style()
    {
        ToolEnqueue::register_inline_style( self::HANDLE[ 'style' ], self::get_inline_style() );
    }

    public static function get_inline_style()
    {
        $output = [];

        $args = self::get();

        if ( !empty( $args['tabs'] ) )
        {
            foreach ( $args['tabs'] as $tab )
            {
                foreach ( $tab['compilations'] as $compilation_id )
                {
                    $output[] = CompilationMain::render_style( $compilation_id );
                }
            }
        }

        return implode( PHP_EOL, $output );
    }

    const JS = [
        self::HANDLE[ 'main' ] => LegalMain::LEGAL_URL . '/assets/js/tabs/tabs-main.js',
    ];

    public static function print()
    {
        ToolPrint::print_style( self::CSS );

        ToolPrint::print_script( self::JS );

        CompilationMain::print();
    }

    public static function register_script( $scripts = [] )
    {
        if ( self::check() ) {
            if ( empty( $scripts ) ) {
                $scripts = self::JS;
            }

            ToolEnqueue::register_script( $scripts );
        }
    }

	public static function check()
    {
        return LegalComponents::check();
    }

    public static function register()
    {
        $handler = new self();

		// [legal-tabs]

        add_shortcode( 'legal-tabs', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    const TABS = [
        'text' => 'tabs-title-text',

        'items' => 'tabs-items',
        
        'description' => 'tabs-description-text',

        'link-text' => 'tabs-link-text',

        'link-url' => 'tabs-link-url',
    ];

    const TAB = [
        'text' => 'tab-title-text',

        'image' => 'tab-title-image',

        'compilations' => 'tab-compilations',
    ];

    public static function get_date( $compilations )
    {
        $date = [];
        foreach( $compilations as $compilation )
        {
            $date[] = CompilationMain::get_date( $compilation );
        }

        return implode( ' ', $date );
    }

    public static function get()
    {
        $post = get_post();

        $args = [
            'text' => get_field( self::TABS[ 'text' ], $post->ID ),

            'description' => get_field( self::TABS[ 'description' ], $post->ID ),
            
            'link' => [
                'text' => get_field( self::TABS[ 'link-text' ], $post->ID ),

                'url' => get_field( self::TABS[ 'link-url' ], $post->ID ),
            ],
        ];

        $args['tabs'] = [];

        $tabs = get_field( self::TABS[ 'items' ], $post->ID );

        if( $tabs ) {
            foreach( $tabs as $key => $tab ) {
                $compilations = ( !empty( $tab[ self::TAB[ 'compilations' ] ] ) ? $tab[ self::TAB[ 'compilations' ] ] : [] );

                // $date = self::get_date( $compilations );

                $args['tabs'][] = [
                    'text' => $tab[ self::TAB[ 'text' ] ],

                    'image' => $tab[ self::TAB[ 'image' ] ],

                    'compilations' => $compilations,

                    // 'date' => $date,

                    'active' => ( $key == 0 ? 'legal-active' : '' ),

                    'class' => ( !empty( $tab[ self::TAB[ 'image' ] ] ) ? 'tab-image-' . $key : '' ),
                ];
            }
        } else {
            $args['empty'] = __( BilletMain::TEXT[ 'there-are-no-tabs' ], ToolLoco::TEXTDOMAIN );
        }

        return $args;
    }

    const TEMPLATE = [
        self::HANDLE[ 'main' ] => LegalMain::LEGAL_PATH . '/template-parts/tabs/part-tabs.php',
    ];

    public static function render()
    {
        $args = self::get();

        $output = [];

        if ( count( $args['tabs'] ) == 1 ) {
            $tab = array_shift( $args['tabs'] );

            foreach ( $tab['compilations'] as $compilation) {
                $output[] = CompilationMain::render_compilation( $compilation );
            }
        } else {
            $output[] = self::render_tabs( $args );
        }

        return implode( '', $output );
    }

    public static function render_tabs( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ self::HANDLE[ 'main' ] ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>