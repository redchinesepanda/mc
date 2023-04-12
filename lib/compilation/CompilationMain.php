<?php

require_once( LegalMain::LEGAL_PATH . '/lib/billet/BilletMain.php' );

class CompilationMain
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-main.php';

    const TEMPLATE_ATTENTION = LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-attention.php';

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
    
    const ATTENTION_TEXT = 'compilation-attention-text';

    const ATTENTION_POSITION = 'compilation-attention-position';

    const ATTENTION_TYPE = 'compilation-attention-type';

    public static function get_settings( $id )
    {
        return [
            'id' => $id,

            'title' => [
                    'image' => get_field( 'compilation-title-image', $id ),

                    'class' => ( !empty( get_field( 'compilation-title-image', $id ) ) ? 'legal-image' : '' ),

                    'text' => get_field( 'compilation-title-text', $id ),
            ],

            'attention' => [
                'text' => get_field( self::ATTENTION_TEXT, $id ),

                'position' => get_field( self::ATTENTION_POSITION, $id ),

                'type' => get_field( self::ATTENTION_TYPE, $id ),
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

    const COMPILATION_FILTER = 'compilation-filter';

    public static function get_filter( $id )
    {
        return [
            'review' => [
                'label' => get_field( 'compilation-review-label', $id ),

                'type' => get_field( 'compilation-review-type', $id ),
            ],

            'play' => [
                'label' => get_field( 'compilation-play-label', $id ),
            ],

            'features' => get_field( self::COMPILATION_FILTER, $id ),

            'order' => get_field( 'billet-order-type', $id ),

            'rating' => get_field( 'billet-rating-enabled', $id ),

            'achievement' => get_field( 'billet-achievement-type', $id ),

            'list' => get_field( 'billet-list-type', $id ),

            'bonus' => get_field( 'billet-bonus-enabled', $id ),

            'mobile' => get_field( 'billet-mobile-enabled', $id ),

            'profit' => get_field( 'billet-profit-enabled', $id ),

            'spoiler' => get_field( 'billet-spoiler-enabled', $id ),

            'description' => get_field( 'billet-description-enabled', $id ),
        ];
    }

    public static function get( $id )
    {
        $id = self::check_id( $id );

        $new_lang = get_field( 'compilation-lang', $id );

        $switch_lang = ( !empty( $new_lang ) );

        if ( $switch_lang ) {
            global $sitepress;

            $current_lang = $sitepress->get_current_language();

            $sitepress->switch_lang( $new_lang );
        }

        $args = [
            'numberposts' => -1,

            'post_type' => 'legal_billet',

            'suppress_filters' => get_field( 'compilation-locale', $id ),

            'tax_query' => [
                [
                    'taxonomy' => 'billet_feature',

                    'field' => 'term_id',

                    'terms' => get_field( self::COMPILATION_FILTER, $id ),

                    'operator' => get_field( 'compilation-operator', $id ),
                ]
            ],

            'orderby' => 'menu_order',

            'order' => 'ASC',
        ];

        $posts = get_posts( $args );

        if ( $switch_lang ) {
            $sitepress->switch_lang( $current_lang );
        }

        return [
            'billets' => self::get_billets( $posts, self::get_filter( $id ) ),

            'settings' => self::get_settings( $id ),
        ];
    }

    public static function render( $id = 0 )
    { 
        load_template( self::TEMPLATE, false, self::get( $id ) );
    }
    
    const POSITION_ABOVE = 'legal-above-title';

    const POSITION_BELOW = 'legal-below-title';

    const POSITION_BOTTOM = 'legal-below';

    public static function render_attention( $attention, $position )
    {
        if ( !empty( $attention['text'] ) )
            if ( $position == $attention['position'] )
                load_template( self::TEMPLATE_ATTENTION, false, $attention );
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>