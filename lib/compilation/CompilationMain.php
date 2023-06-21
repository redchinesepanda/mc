<?php

// require_once( LegalMain::LEGAL_PATH . '/lib/billet/BilletMain.php' );

class CompilationMain
{
    const CSS = [
        'compilation-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-main.css',

            'ver' => '1.0.0',
        ],
    ];

    self::JS = [];

    public static function print()
    {
        BilletMain::print();

        ToolPrint::print_style( self::CSS );
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
        $permission = true;
        
        return $permission;
    }

    public static function register()
    {
        $handler = new self();

		// [legal-tabs]

        add_shortcode( 'legal-tabs', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    public static function get_billets( $posts, $filter )
    {
        $data = [];

        foreach ( $posts as $index => $post ) {
            $data[] = [
                'index' => ( $index + 1 ),

                'id' => $post->ID,
            
                'filter' => $filter,
            ];
        }

        return $data;
    }
    
    const ATTENTION = [
        'text' => 'compilation-attention-text',

        'position' => 'compilation-attention-position',

        'type' => 'compilation-attention-type',
    ];

    public static function get_settings( $id )
    {
        return [
            'id' => $id,

            'title' => [
                    'image' => get_field( self::COMPILATION[ 'title-image' ], $id ),

                    'class' => ( !empty( get_field( self::COMPILATION[ 'title-image' ], $id ) ) ? 'legal-image' : '' ),

                    'text' => get_field( self::COMPILATION[ 'title-text' ], $id ),
            ],

            'attention' => [
                'text' => get_field( self::ATTENTION[ 'text' ], $id ),

                'position' => get_field( self::ATTENTION[ 'position' ], $id ),

                'type' => get_field( self::ATTENTION[ 'type' ], $id ),
            ],
        ];
    }

    public static function check_id( $id = 0 ) {
        if ( $id == 0 ) {
            $post = get_post();
    
            if ( $post )
                return $post->ID;
        }

        return $id;
    }

    const COMPILATION = [
        'title-image' => 'compilation-title-image',

        'title-text' => 'compilation-title-text',

        'filter' => 'compilation-filter',

        'locale' => 'compilation-locale',

        'operator' => 'compilation-operator',

        'lang' => 'compilation-lang',

        'review-label' => 'compilation-review-label',

        'review-type' => 'compilation-review-type',

        'play-label' => 'compilation-play-label',
    ];

    const BILLET = [
        'order-type' => 'billet-order-type',

        'rating-enabled' => 'billet-rating-enabled',

        'achievement-type' => 'billet-achievement-type',

        'list-type' => 'billet-list-type',

        'bonus-enabled' => 'billet-bonus-enabled',

        'mobile-enabled' => 'billet-mobile-enabled',

        'profit-enabled' => 'billet-profit-enabled',

        'spoiler-enabled' => 'billet-spoiler-enabled',

        'description-enabled' => 'billet-description-enabled',
    ];

    public static function get_filter( $id )
    {
        return [
            'review' => [
                'label' => get_field( self::COMPILATION[ 'review-label' ], $id ),

                'type' => get_field( self::COMPILATION[ 'review-type' ], $id ),
            ],

            'play' => [
                'label' => get_field( self::COMPILATION[ 'play-label' ], $id ),
            ],

            'features' => get_field( self::COMPILATION[ 'filter' ], $id ),

            'order' => get_field( self::BILLET[ 'order-type' ], $id ),

            'rating' => get_field( self::BILLET[ 'rating-enabled' ], $id ),

            'achievement' => get_field( self::BILLET[ 'achievement-type' ], $id ),

            'list' => get_field( self::BILLET[ 'list-type' ], $id ),

            'bonus' => get_field( self::BILLET[ 'bonus-enabled' ], $id ),

            'mobile' => get_field( self::BILLET[ 'mobile-enabled' ], $id ),

            'profit' => get_field( self::BILLET[ 'profit-enabled' ], $id ),

            'spoiler' => get_field( self::BILLET[ 'spoiler-enabled' ], $id ),

            'description' => get_field( self::BILLET[ 'description-enabled' ], $id ),
        ];
    }

    public static function get_args( $id )
    {
        return [
            'numberposts' => -1,

            'post_type' => 'legal_billet',

            'suppress_filters' => get_field( self::COMPILATION[ 'locale' ], $id ),

            'tax_query' => [
                [
                    'taxonomy' => 'billet_feature',

                    'field' => 'term_id',

                    'terms' => get_field( self::COMPILATION[ 'filter' ], $id ),

                    'operator' => get_field( self::COMPILATION[ 'operator' ], $id ),
                ]
            ],

            'orderby' => 'menu_order',

            'order' => 'ASC',
        ];
    }

    public static function get( $id )
    {
        $id = self::check_id( $id );

        $new_lang = get_field( self::COMPILATION[ 'lang' ], $id );

        $switch_lang = ( !empty( $new_lang ) );

        if ( $switch_lang ) {
            global $sitepress;

            $current_lang = $sitepress->get_current_language();

            $sitepress->switch_lang( $new_lang );
        }

        $posts = get_posts( self::get_args( $id ) );

        if ( $switch_lang ) {
            $sitepress->switch_lang( $current_lang );
        }

        return [
            'billets' => self::get_billets( $posts, self::get_filter( $id ) ),

            'settings' => self::get_settings( $id ),
        ];
    }

    const TEMPLATE = [
        'legal-compilation' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-main.php',
        
        'legal-attention' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-attention.php',
    ];

    public static function render(  $id = 0  )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'legal-compilation' ], false, self::get( $id ) );

        $output = ob_get_clean();

        return $output;
    }
    
    const POSITION = [
        'above' => 'legal-above-title',

        'below' => 'legal-below-title',

        'bottom' => 'legal-below',
    ];

    public static function render_attention( $attention, $position )
    {
        if ( !empty( $attention[ 'text' ] ) )
            if ( $position == $attention[ 'position' ] )
                load_template( self::TEMPLATE[ 'legal-attention' ], false, $attention );
    }
}

?>