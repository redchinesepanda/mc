<?php

class OopsMain
{
    const CSS = [
        'legal-oops' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/oops/oops.css',

            'ver' => '1.0.1',
        ],
    ];

    public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            ToolEnqueue::register_style( $styles );
        }
    }

    const JS = [
        'legal-oops' => LegalMain::LEGAL_URL . '/assets/js/oops/oops.js',
    ];

    public static function register_script( $scripts = [] )
    {
        if ( self::check() ) {
            ToolEnqueue::register_script( $scripts );
        }
    }

    public static function register()
    {
        $handler = new self();

        // [legal-oops]

        add_shortcode( 'legal-oops', [ $handler, 'render_check' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        add_filter( 'wp_query_search_exclusion_prefix', function( $prefix ) {
            return '!';
        } );
    }

    public static function get_args( $prefix = ' ' )
    {
        return [
            'numberposts' => -1,
            
            'post_type' => 'affiliate-links',

            'suppress_filters' => 0,

            // 's' => '-' . WPMLMain::current_language(),

            // 's' => ' ' . WPMLMain::current_language(),
            
            // 's' => '' . WPMLMain::current_language(),
            
            // 's' => '" ' . WPMLMain::current_language() . '" "-' . WPMLMain::current_language() . '" ng',
            
            's' => '"' . $prefix . WPMLMain::current_language() . '"',

            // 'sentence' => true,

            // 'meta_query' => [
            //     'oops_clause' => [
            //         'key' => 'affilate-oops',

            //         'value' => '1',
            //     ],
            // ],

            // 'meta_key' => 'affilate-order',

            // 'orderby' => [ 'meta_value' => 'ASC', 'title' => 'ASC' ],
            
            // 'orderby' => [ 'meta_value' => 'ASC' ],
        ];
    }

    public static function get()
    {
        $posts = array_merge( self::get_posts(), self::get_posts( '-' ) );

        $args = [
            'title' => __( 'Ouch', ToolLoco::TEXTDOMAIN ) . '!',

            'description' => __( "This bookie doesn't pay for the referral program. But here are the offers of Match.Center partners", ToolLoco::TEXTDOMAIN ) . ':',

            'items' => [],
            
            'label' => __( 'Bet Now', ToolLoco::TEXTDOMAIN ),

        ];

        foreach ( $posts as $post ) {
            $src = get_field( 'affilate-logo', $post->ID );

            // $image = wp_get_attachment_image_src( $post->ID, 'full' );

            // LegalDebug::debug( [
            //     'src' => $src,

            //     'ID' => $post->ID,

            //     'image' => $image,
            // ] );

            $args['items'][] = [
                'src' => ( $src ? $src[ 'url' ] : LegalMain::LEGAL_URL . '/assets/img/oops/mc.png' ),

                'href' => get_post_permalink( $post->ID ),
	
                'width' => ( $src ? $src[ 'width' ] : '88' ),
                
                'height' => ( $src ? $src[ 'height' ] : '29' ),
            ];

            // LegalDebug::debug( [
            //     'post_title' => $post->post_title,

            //     'affilate-order' => get_post_meta( $post->ID, 'affilate-order', true ),

            //     'affilate-oops' => get_post_meta( $post->ID, 'affilate-oops', true ),
            // ] );
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

        // LegalDebug::debug( [
        //     'found_posts1' => $query1->found_posts,

        //     'found_posts2' => $query2->found_posts,

        //     'result' => ( $query1->found_posts || $query2->found_posts ? 'true' : 'false' ),

        //     // 'get_args' => self::get_args(),
        // ] );
        
        return ( $query1->found_posts || $query2->found_posts );
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

    public static function check()
    {
        return ReviewMain::check();
    }
}

?>