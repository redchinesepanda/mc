<?php

require_once( LegalMain::LEGAL_PATH . '/lib/billet/BilletMain.php' );

class CompilationMain
{
    const TEMPLATE = [
        'legal-compilation' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-main.php',
        
        'legal-attention' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-attention.php',
    ];

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
                    'image' => get_field( 'compilation-title-image', $id ),

                    'class' => ( !empty( get_field( 'compilation-title-image', $id ) ) ? 'legal-image' : '' ),

                    'text' => get_field( 'compilation-title-text', $id ),
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

            'list' => get_field( 'billet-list-type', $id ),

            'bonus' => get_field( 'billet-bonus-enabled', $id ),

            'mobile' => get_field( 'billet-mobile-enabled', $id ),

            'profit' => get_field( 'billet-profit-enabled', $id ),

            'spoiler' => get_field( 'billet-spoiler-enabled', $id ),

            'description' => get_field( 'billet-description-enabled', $id ),
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

    public static function render( $id = 0 )
    { 
        load_template( self::TEMPLATE[ 'legal-compilation' ], false, self::get( $id ) );
    }
    
    const POSITION = [
        'above' => 'legal-above-title',

        'below' => 'legal-below-title',

        'bottom' => 'legal-below'
    ];

    public static function render_attention( $attention, $position )
    {
        if ( !empty( $attention['text'] ) )
            if ( $position == $attention['position'] )
                load_template( self::TEMPLATE[ 'legal-attention' ], false, $attention );
    }
}

?>