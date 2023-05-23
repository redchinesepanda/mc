<?php

class OopsMain
{
    const CSS = [
        'legal-oops' => LegalMain::LEGAL_URL . '/assets/css/oops/oops.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    const JS = [
        'legal-oops' => LegalMain::LEGAL_URL . '/assets/js/oops/oops.js',
    ];

    public static function register_script()
    {
        foreach ( self::JS as $name => $path ) {
            wp_register_script( $name, $path, [], false, true );

            wp_enqueue_script( $name );
        }
    }

    public static function register()
    {
        $handler = new self();

        // [legal-oops]

        add_shortcode( 'legal-oops', [ $handler, 'render_check' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    public static function get_args()
    {
        return [
            'numberposts' => -1,
            
            'post_type' => 'affiliate-links',

            'suppress_filters' => 0,

            's' => ' ' . WPMLMain::current_language(),

            'sentence' => true,

            'meta_query' => [
                'oops_clause' => [
                    'key' => 'affilate-oops',

                    'value' => '1',
                ],
            ],

            'meta_key' => 'affilate-order'

            // 'orderby' => [ 'oops_clause' => 'ASC', 'title' => 'ASC' ],
            
            'orderby' => [ 'meta_value' => 'ASC' ],
        ];
    }

    public static function get()
    {
        $posts = self::get_posts();

        $args = [
            'title' => __( 'Ouch', ToolLoco::TEXTDOMAIN ) . '!',

            'description' => __( "This bookie doesn't pay for the referral program. But here are the offers of Match.Center partners", ToolLoco::TEXTDOMAIN ) . ':',

            'items' => [],
            
            'label' => __( 'Bet Now', ToolLoco::TEXTDOMAIN ),

        ];

        foreach ( $posts as $post ) {
            $src = get_field( 'affilate-logo', $post->ID );

            $args['items'][] = [
                'src' => ( !empty( $src ) ? $src : LegalMain::LEGAL_URL . '/assets/img/oops/mc.png' ),

                'href' => get_post_permalink( $post->ID ),
            ];

            LegalDebug::debug( [
                'affilate-order' => get_post_meta( $post->ID, 'affilate-order', true ),
            ] );
        }

        return $args;
    }

    public static function get_posts()
    {
        $query = new WP_Query( self::get_args() );
        
        return $query->posts;
    }

    public static function check_oops()
    {
        $query = new WP_Query( self::get_args() );
        
        return $query->found_posts;
    }

    const TEMPLATE = [
        'oops' => LegalMain::LEGAL_PATH . '/template-parts/oops/oops.php',
    ];

    public static function render_check()
    {
        if ( self::check_oops() ) {
            return self::render();
        }

        return '';
    }

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'oops' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>