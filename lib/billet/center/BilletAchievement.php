<?php

class BilletAchievement
{
    const HANDLE = [
        'main' => 'achievement-main',

        'style' => 'achievement-style',
    ];

    const TAXONOMY = 'billet_achievement';

    const TYPE_DISABLED = 'legal-disabled';

    const TYPE_IMAGE = 'legal-image';

    const TYPE_BACKGROUND = 'legal-background';

    const TYPE = [
        'about' => 'legal-about',
    ];

    const FIELD = [
        'feture-achievement' => 'billet-feture-achievement',
    ];

    const FETURE_ACHIEVEMENT = [
        'feture-id' => 'billet-feture-id',

        'achievement-id' => 'billet-achievement-id',
    ];
    
    public static function get_achievement_class( $achievement_class )
    {
        return !empty( $achievement_class ) ? $achievement_class : BilletAchievement::TYPE_IMAGE;
    }

    // public static function get( $title )
    
    public static function get( $title )
    {
        // $title[ 'id' ]

        // $title[ 'filter' ]

        // $title['achievement']

        return self::get_achievement( $title[ 'id' ], $title[ 'filter' ] );
    }
    
    public static function get_achievement( $id, $filter )
    {
        // LegalDebug::debug( [
        //     'function' => 'BilletAchievement::get',

        //     'title' => $title,
        // ] );

        if ( self::check_disabled( $filter ) )
        {
            return [];
        }

        $args = [];

        $term = null;

        $feature_achievement = get_field( self::FIELD[ 'feture-achievement' ], $id );

        if ( $feature_achievement )
        {
            foreach ( $feature_achievement as $feature_achievement_item )
            {
                if ( in_array( $feature_achievement_item[ self::FETURE_ACHIEVEMENT[ 'feture-id' ] ], $filter[ 'features' ] ) )
                {
                    $term = get_term( $feature_achievement_item[ self::FETURE_ACHIEVEMENT[ 'achievement-id' ] ] );
                }
            }
        }

        if ( empty( $term ) )
        {
            $terms = wp_get_post_terms( $id, self::TAXONOMY, [ 'term_id', 'name', 'slug' ] );

            if ( !empty( $terms ) && !is_wp_error( $terms ) )
            {
                $term = array_shift( $terms );
            }
        }

        if ( !empty( $term ) )
        {
            $color = get_field( 'achievement-color', self::TAXONOMY . '_' . $term->term_id );

            if ( empty( $color ) )
            {
                $color = 'rgba(237, 239, 244, 1)';
            }

            $args = [
                // 'class' => $title['achievement'],
                
                'class' => self::get_achievement_class( $filter[ 'achievement' ] ),
            
                'selector' => 'achievement-' . $term->term_id,

                'name' => __( $term->name, ToolLoco::TEXTDOMAIN ),

                'color' => $color,

                'image' => get_field( 'achievement-image', self::TAXONOMY . '_' . $term->term_id ),
            ];
        }

        return $args;
    }

    const TEMPLATE = [
        self::HANDLE[ 'main' ] => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-achievement-main.php',

        self::HANDLE[ 'style' ] => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-achievement-style.php',
    ];

    // public static function render( $title )
    // {
    //     // LegalDebug::debug( [
    //     //     'function' => 'BilletAchievement::render',

    //     //     'title' => $title,
    //     // ] );

    //     if ( $title['achievement'] != self::TYPE_DISABLED ) {
    //         $args = self::get( $title );
    
    //         if ( !empty( $args ) ) {
    //             load_template( self::TEMPLATE, false, $args );
    //         }
    //     }
    // }

    // public static function check_disabled( $title )
    
    public static function check_disabled( $filter )
    {
        // return $title[ 'achievement' ] == self::TYPE_DISABLED;

        // LegalDebug::debug( [
        //     'BilletAchievemnet' => 'check_disabled',

        //     '$filter' => $filter,
        // ] );
        
        return $filter[ 'achievement' ] == self::TYPE_DISABLED;
    }

    public static function render( $achievement )
    {
        // if ( self::check_disabled( $title ) )
        // {
        //     return '';
        // }
        
        return self::render_main( self::TEMPLATE[ self::HANDLE[ 'main' ] ], $achievement );
    }

    public static function render_achievement( $title )
    {
        // if ( self::check_disabled( $title ) )
        // {
        //     return '';
        // }
        
        return self::render_main( self::TEMPLATE[ self::HANDLE[ 'main' ] ], self::get( $title ) );
    }

    public static function render_style( $args )
    {
        $billet = BilletMain::get( $args );

        $title = BilletTitle::get( $billet ); 

        LegalDebug::debug( [
            'BilletAchievement' => 'render_style',

            '$args' => $args,

            '$billet' => $billet,
        ] );

        if ( self::check_disabled( $title ) )
        {
            return '';
        }

        return self::render_main( self::TEMPLATE[ self::HANDLE[ 'style' ] ], self::get( $title ) );
    }

    public static function render_main( $template, $args )
    {
		ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>