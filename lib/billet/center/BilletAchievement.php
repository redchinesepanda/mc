<?php

class BilletAchievement
{
    const HANDLE = [
        'main' => 'billet-main',

        'style' => 'billet-style',
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
    
    public static function get( $title )
    {
        // LegalDebug::debug( [
        //     'function' => 'BilletAchievement::get',

        //     'title' => $title,
        // ] );

        $args = [];

        $term = null;

        $feature_achievement = get_field( self::FIELD[ 'feture-achievement' ], $title[ 'id' ] );

        if ( $feature_achievement )
        {
            foreach ( $feature_achievement as $feature_achievement_item )
            {
                if ( in_array( $feature_achievement_item[ self::FETURE_ACHIEVEMENT[ 'feture-id' ] ], $title[ 'filter' ][ 'features' ] ) )
                {
                    $term = get_term( $feature_achievement_item[ self::FETURE_ACHIEVEMENT[ 'achievement-id' ] ] );
                }
            }
        }

        if ( empty( $term ) )
        {
            $terms = wp_get_post_terms( $title['id'], self::TAXONOMY, [ 'term_id', 'name', 'slug' ] );

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
                'class' => $title['achievement'],
            
                'selector' => 'achievement-' . $term->term_id,

                'name' => __( $term->name, ToolLoco::TEXTDOMAIN ),

                'color' => $color,

                'image' => get_field( 'achievement-image', self::TAXONOMY . '_' . $term->term_id ),
            ];
        }

        return $args;
    }

    const TEMPLATE = [
        self::HANDLE[ 'main' ] => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-achievement.php',
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

    public static function check_disabled( $title )
    {
        return $title[ 'achievement' ] == self::TYPE_DISABLED;
    }

    public static function render_achievement( $title )
    {
        if ( self::check_disabled( $title ) )
        {
            return '';
        }
        
        return self::render_main( self::TEMPLATE[ self::HANDLE[ 'main' ] ], self::get( $title ) );
    }

    public static function render_style( $billet )
    {
        $title = BilletTitle::get( $billet );

        LegalDebug::debug( [
            'function' => 'BilletAchievement::render_style',

            'title' => $title,
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