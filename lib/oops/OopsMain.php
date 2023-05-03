<?php

class OopsMain
{
    public static function get_args()
    {
        return [
            'numberposts' => -1,
            
            'post_type' => 'affiliate-links',

            'suppress_filters' => 0,

            's' => ' ' . WPMLMain::current_language(),

            'sentence' => true,
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
            $args['items'][] = [
                'src' => '',

                'href' => get_post_permalink( $post->ID ),
            ];
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
            self::render();
        }
    }

    public static function render()
    {

        LegalDebug::debug( [
            'function' => 'render',

            'self::get()' => self::get(),
        ] );

        ob_start();

        load_template( self::TEMPLATE[ 'oops' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

    public static function register()
    {
        $handler = new self();

        // [legal-oops]

        add_shortcode( 'legal-oops', [ $handler, 'render_check' ] );

        // add_action( 'edit_form_before_permalink', [ $handler, 'wp_kama_edit_form_before_permalink_action' ] );
    }

    // public static function wp_kama_edit_form_before_permalink_action( $post ){
    //     LegalDebug::debug( [
    //         'get_post_meta' => get_post_meta( $post->ID ),
    //     ] );
    // }
}

?>