<?php

require_once( 'OopsCookie.php' );

require_once( 'OopsAge.php' );

class OopsMain
{
    const CSS = [
        'legal-oops-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/oops/legal-oops-main.css',

            'ver' => '1.0.2',
        ],
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

    const JS = [
        'legal-oops-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/oops/legal-oops-main.js',

            'ver' => '1.0.0',
        ],
    ];

    public static function register_script( $scripts = [] )
    {
        if ( self::check() ) {
            if ( empty( $scripts ) ) {
                $scripts = self::JS;
            }

            ToolEnqueue::register_script( $scripts );
        }
    }

    public static function register()
    {
        $handler = new self();

        // [legal-oops]

        add_shortcode( 'legal-oops', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_filter( 'wp_query_search_exclusion_prefix', function( $prefix ) {
            return '!';
        } );

        OopsCookie::register();

        OopsAge::register();
    }

    const TAXONOMY = [
        'category' => 'affiliate-links-cat',

        'type' => 'page_type',
    ];

    const CATEGORY = [
        'casino' => 'ca',
    ];

    const TYPE = [
        'casino' => 'casino',
    ];

    public static function get_args( $prefix = ' ' )
    {
        $tax_query = [
            [
                'taxonomy' => self::TAXONOMY[ 'category' ],
                
                'field' => 'slug',

                'operator' => 'NOT EXISTS',
            ],
        ];

        $term = has_term( self::TYPE[ 'casino' ], self::TAXONOMY[ 'type' ] );

        if ( $term )
        {
            $tax_query = [
                [
                    'taxonomy' => self::TAXONOMY[ 'category' ],
                    
                    'field' => 'slug',
    
                    'terms' => self::CATEGORY[ 'casino' ],
    
                    'operator' => 'IN',
                ],
            ];
        }

        return [
            'numberposts' => -1,
            
            'post_type' => 'affiliate-links',

            'post_status' => 'publish',

            'suppress_filters' => 0,
            
            's' => '"' . $prefix . WPMLMain::current_language() . '"',

            'meta_query' =>
            [
                'oops_participate' =>
                [
                    'key' => self::FIELD[ 'oops' ],

                    'value' => '1',
                ],

                'oops_order' =>
                [
                    'key' => self::FIELD[ 'order' ],
                ],
            ],

            'tax_query' => $tax_query,
            
            'orderby' =>
            [
                'oops_order' => 'ASC',
                
                'modified' => 'DESC'
            ],
        ];
    }

    const FIELD = [
        'logo' => 'affilate-logo',

        'oops' => 'affilate-oops',

        'order' => 'affilate-order',

        'bonus-label' => 'affilate-bonus-label',
    ];

    public static function get()
    {
        $posts = array_merge( self::get_posts(), self::get_posts( '-' ) );

        $args = [
            'title' => __( BaseMain::TEXT[ 'ouch' ], ToolLoco::TEXTDOMAIN ) . '!',

            'description' => __( BaseMain::TEXT[ 'this-bookie' ], ToolLoco::TEXTDOMAIN ) . ':',

            'items' => [],
            
            'label' => __( BaseMain::TEXT[ 'bet-now' ], ToolLoco::TEXTDOMAIN ),

        ];

        foreach ( $posts as $post )
        {
            $src = get_field( self::FIELD[ 'logo' ], $post->ID );

            $bonus_label = get_field( self::FIELD[ 'bonus-label' ], $post->ID );

            $href = get_post_permalink( $post->ID );

            $href = ACFReview::format_afillate( $href, 0, '' );

            $args['items'][] = [
                'src' => ( $src ? $src[ 'url' ] : LegalMain::LEGAL_URL . '/assets/img/oops/mc.png' ),

                'href' => $href,
	
                'width' => ( $src ? $src[ 'width' ] : '88' ),
                
                'height' => ( $src ? $src[ 'height' ] : '29' ),

                'bonus-label' => $bonus_label,
            ];
        }

        return $args;
    }

    public static function get_posts( $prefix = ' ' )
    {
        $query = new WP_Query( self::get_args( $prefix ) );
        
        return $query->posts;
    }

    public static function check_oops()
    {
        $query1 = new WP_Query( self::get_args() );

        $query2 = new WP_Query( self::get_args( '-' ) );
        
        return ( $query1->found_posts || $query2->found_posts );
    }

    const TEMPLATE = [
        'legal-oops-main' => LegalMain::LEGAL_PATH . '/template-parts/oops/legal-oops-main.php',
    ];

    public static function render()
    {
        if ( !self::check() ) {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-oops-main' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

    public static function check()
    {
        return ReviewMain::check();
    }
}

?>