<?php

class OopsMain
{
    public static function check_oops()
    {
        $args = [
            'numberposts' => -1,

            // 'post_type' => 'legal_billet',
            
            'post_type' => 'affiliate-links',

            'suppress_filters' => 0,

            'meta_query' => [
                [
                    'key' => 'billet-referal',

                    'value' => '',

                    'meta_compare' => '!=',
                ],
            ]
        ];

        $posts = new WP_Query( $args );
        
        return $posts->found_posts;
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'edit_form_before_permalink', [ $handler, 'wp_kama_edit_form_before_permalink_action' ] );
    }

    public static function wp_kama_edit_form_before_permalink_action( $post ){
        LegalDebug::debug( [
            'get_post_meta' => get_post_meta( $post->ID ),
        ] );
    }
}

?>