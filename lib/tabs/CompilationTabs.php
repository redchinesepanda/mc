<?php

class CompilationTabs
{
    const CSS = [
        'tabs-main' => LegalMain::LEGAL_URL . '/assets/css/tabs/tabs-main.css',

        'tabs-mini' => LegalMain::LEGAL_URL . '/assets/css/tabs/tabs-mini.css',
    ];

    const JS = [
        'tabs-main' => LegalMain::LEGAL_URL . '/assets/js/tabs/tabs-main.js',
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

	public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            if ( empty( $styles ) ) {
                $styles = self::CSS;
            }

            ToolEnqueue::register_style( $styles );
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

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        // [legal-tabs-mini id='269090' profit="true"]

        add_shortcode( 'legal-tabs-mini', [ $handler, 'prepare' ] );
    }

    const PAIRS = [
		'id' => 0,

		'profit' => false,
	];

    const FIELD = [
        'title' => 'tabs-mini-title',

        'image' => 'tabs-mini-image',

        'description' => 'tabs-mini-description',

        'label' => 'tabs-mini-label',
    ];

    public static function prepare_tab_mini( $id )
    {
		$profit = self::get_filter_profit( $id );

        $class = $profit ? 'legal-profit' : 'legal-default';

        return [
            'id' => $id,

            'title' => get_field( self::FIELD[ 'title' ], $id ),

            'url' => get_field( self::FIELD[ 'image' ], $id ),

            'description' => get_field( self::FIELD[ 'description' ], $id ),

			'items' => self::get_items_mini( $id, $profit ),

            'button' => [
                'label' => get_field( self::FIELD[ 'label' ], $id ),

                'href' => get_post_permalink( $id ),
            ],

            'class' => $class,
		];
	}

    public static function filter_space( $string )
    {
        return preg_replace(
            '/\s*,\s*/',
            
            ',',
            
            filter_var( $string, FILTER_SANITIZE_STRING )
        );
    }

    public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, 'legal-tabs-mini' );

        $atts[ 'profit' ] = wp_validate_boolean( $atts[ 'profit' ] );

        $pages = explode( ',', self::filter_space( $atts[ 'id' ] ) );

        $args = [];

        foreach ( $pages as $page )
        {
            $args[] = self::prepare_tab_mini( $page );
        }

		return self::render_tabs_mini( $args );
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
    
    public static function get_filter_profit( $id )
    {
        $items = [];
        
        $tabs = get_field( self::TABS[ 'items' ], $id );

        $profit = true;

        if ( $tabs )
        {
            $sets = [];

            $limit = 3;

            foreach ( $tabs as $tab )
            {
                $compilations = ( !empty( $tab[ self::TAB[ 'compilations' ] ] ) ? $tab[ self::TAB[ 'compilations' ] ] : [] );

                foreach ( $compilations as $compilation )
                {
                    $compilation_profit = CompilationMain::get_filter_profit( $compilation );

                    $profit = $profit && $compilation_profit;
                }
            }
        }

        return $profit;
    }

    public static function get_items_mini( $id, $profit = false )
    {
        $items = [];
        
        $tabs = get_field( self::TABS[ 'items' ], $id );

        if ( $tabs )
        {
            $sets = [];

            // $limit = 3;
            
            $limit = $profit ? -1 : 3;

            foreach ( $tabs as $tab )
            {
                $compilations = ( !empty( $tab[ self::TAB[ 'compilations' ] ] ) ? $tab[ self::TAB[ 'compilations' ] ] : [] );

                foreach ( $compilations as $compilation )
                {
                    $ids = CompilationMain::get_ids( $compilation, $limit );

                    $amount = count( $ids );

                    $rest = $limit - $amount;

                    if ( $rest >= 0 )
                    {
                        $limit = $rest;
                    }

                    $sets[] = $ids;

                    if ( $limit == 0 )
                    {
                        break 2;
                    }
                }

                if ( $limit == 0 )
                {
                    break;
                }
            }

            $billets = array_unique( call_user_func_array( 'array_merge' , $sets ) );

            foreach ( $billets as $billet )
            {
                $items[] = BilletMain::get_mini( $billet, $profit );
            }
        }

        return $items;
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
        'tabs' => LegalMain::LEGAL_PATH . '/template-parts/tabs/part-tabs.php',

        'mini' => LegalMain::LEGAL_PATH . '/template-parts/tabs/part-tabs-mini.php',
    ];

    public static function render()
    {
        $args = self::get();

        $output = [];

        if ( count( $args['tabs'] ) == 1 ) {
            $tab = array_shift( $args['tabs'] );

            foreach ( $tab['compilations'] as $compilation) {
                $output[] = CompilationMain::render( $compilation );
            }
        } else {
            $output[] = self::render_tabs( $args );
        }

        return implode( '', $output );
    }

    public static function render_tabs( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'tabs' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }

    public static function render_tabs_mini( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'mini' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>