<?php

require_once( LegalMain::LEGAL_PATH . '/lib/billet/BilletMain.php' );

class CompilationMain
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-main.php';

    const CSS = [
        'compilation-main' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-main.css',
    ];

    public static function print()
    {
        BilletMain::print();

        foreach ( self::CSS as $key => $url ) {
            echo '<link id="' . $key . '" href="' . $url . '" rel="stylesheet" />';
        }
    }

    public static function get_billets( $posts, $compilation )
    {
        $data = [];

        foreach ( $posts as $index => $post ) {
            $data[$index]['index'] = $index + 1;

            $data[$index]['id'] = $post->ID;
            
            $data[$index]['compilation'] = $compilation;
        }

        return $data;
    }
    
    public static function get_settings( $id )
    {
        return [
            'id' => $id,

            'title' => [
                    'image' => get_field( 'compilation-title-image', $id ),

                    'text' => get_field( 'compilation-title-text', $id ),
            ],

            'attention' => [
                'text' => get_field( 'compilation-attention-text', $id ),

                'position' => get_field( 'compilation-attention-position', $id ),
            ],
        ];
    }

    public static function check_id( $id = 0 ) {
        if ( $id == 0 ) {
            $post = get_post();
    
            return $post->ID;
        }

        return $id;
    }

    public static function get_compilation( $id )
    {
        return [
            'id' => $id,

            'review' => [
                'label' => get_field( 'compilation-review-label', $id ),

                'type' => get_field( 'compilation-review-type', $id ),
            ],

            'play' => [
                'label' => get_field( 'compilation-play-label', $id ),
            ],

            'order' => get_field( 'billet-order-type', $id ),

            'rating' => get_field( 'billet-rating-enabled', $id ),

            'achievement' => get_field( 'billet-achievement-type', $id ),

            'list' => get_field( 'billet-list-type', $id ),

            'bonus' => get_field( 'billet-bonus-enabled', $id ),

            'mobile' => get_field( 'billet-mobile-enabled', $id ),

            'profit' => get_field( 'billet-profit-enabled', $id ),

            'spoiler' => get_field( 'billet-spoiler-enabled', $id ),
        ];
    }

    public static function get( $id )
    {
        $id = self::check_id( $id );

        $args = [
            'numberposts' => -1,

            'post_type' => 'legal_billet',

            'suppress_filters' => 0,

            'tax_query' => [
                [
                    'taxonomy' => 'billet_feature',

                    'field' => 'term_id',

                    'terms' => get_field( 'compilation-filter', $id ),

                    'operator' => 'AND'
                ]
            ]
        ];

        return [
            'billets' => self::get_billets( get_posts( $args ), self::get_compilation( $id ) ),

            'settings' => self::get_settings( $id ),

            'achievement' => 'to_do',
        ];
    }

    public static function render( $id = 0 )
    { 
        load_template( self::TEMPLATE, false, self::get( $id ) );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>