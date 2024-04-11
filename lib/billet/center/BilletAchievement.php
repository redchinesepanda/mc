<?php

class BilletAchievement
{
    const HANDLE = [
        'main' => 'achievement-main',

        'style' => 'achievement-style',
    ];

    // const TAXONOMY = 'billet_achievement';

    // self::TAXONOMY[ 'achievement' ]
    
    const TAXONOMY = [
        'achievement' => 'billet_achievement'
    ];

    const TYPE_DISABLED = 'legal-disabled';

    const TYPE_IMAGE = 'legal-image';

    const TYPE_BACKGROUND = 'legal-background';

    // const TYPE = [
    //     'about' => 'legal-about',
    // ];

    const FIELD = [
        'feture-achievement' => 'billet-feture-achievement',
    ];
    const FIELD_ACHIEVEMENT = [
        'image' => 'achievement-image',

        'color' => 'achievement-color',

        'tooltip' => 'achievement-tooltip',
    ];

    const FETURE_ACHIEVEMENT = [
        'feture-id' => 'billet-feture-id',

        'achievement-id' => 'billet-achievement-id',
    ];
    
    public static function get_achievement_class( $filter )
    {
        if ( !empty( $filter[ 'achievement' ] ) )
        {
            return $filter[ 'achievement' ];
        }

        return BilletAchievement::TYPE_IMAGE;
    }
    
    public static function get( $title )
    {
        return self::get_achievement( $title[ 'id' ], $title[ 'filter' ] );
    }

    public static function get_feature_achievement( $id, $filter )
    {
        if ( !empty( $filter[ 'features' ] ) )
        {
            $feature_achievements = get_field( self::FIELD[ 'feture-achievement' ], $id );
    
            if ( $feature_achievements )
            {
                foreach ( $feature_achievements as $feature_achievement )
                {
                    if ( in_array( $feature_achievement[ self::FETURE_ACHIEVEMENT[ 'feture-id' ] ], $filter[ 'features' ] ) )
                    {
                        $term = get_term( $feature_achievement[ self::FETURE_ACHIEVEMENT[ 'achievement-id' ] ] );
                    }
                }
            }
        }

        return [];
    }

    public static function get_default_achievements( $id )
    {
        return self::get_default_achievement( $id, self::MODE[ 'all' ] );
    }

    const MODE = [
        'default' => 'default',

        'all' => 'all',
    ];

    public static function get_default_achievement( $id, $mode = self::MODE[ 'default' ] )
    {
        $terms = wp_get_post_terms( $id, self::TAXONOMY[ 'achievement' ], [ 'term_id', 'name', 'slug' ] );

        if ( !is_wp_error( $terms ) && !empty( $terms ) )
        {
            if ( $mode == self::MODE[ 'default' ] )
            {
                return array_shift( $terms );
            }
            else
            {
                return $terms;
            }
        }

        return [];
    }

    const COLOR = [
        'default' => 'rgba(237, 239, 244, 1)',
    ];

    public static function get_achievement_color( $term )
    {
        if ( $color = get_field( self::FIELD_ACHIEVEMENT[ 'color' ], self::TAXONOMY[ 'achievement' ] . '_' . $term->term_id ) )
        {
            return $color;
        }

        return self::COLOR[ 'default' ];
    }

    public static function get_achievement_image( $term )
    {
        if ( $image = get_field( self::FIELD_ACHIEVEMENT[ 'image' ], self::TAXONOMY[ 'achievement' ] . '_' . $term->term_id ) )
        {
            return $image;
        }

        return '';
    }
    
    public static function get_achievement_item( $term, $filter )
    {
        if ( !empty( $term ) )
        {
            return [
                'class' => self::get_achievement_class( $filter ),
            
                'selector' => 'achievement-' . $term->term_id,

                'name' => ToolLoco::translate( $term->name ),
                
                'color' => self::get_achievement_color( $term ),
                
                'image' => self::get_achievement_image( $term ),
            ];
        }

        return [];
    }

    public static function get_achievement( $id, $filter )
    {
        if ( self::check_disabled( $filter ) )
        {
            return [];
        }

        $term = self::get_feature_achievement( $id, $filter );
        
        if ( empty( $term ) )
        {
            $term = self::get_default_achievement( $id );
        }

        if ( !empty( $term ) )
        {
            return self::get_achievement_item( $term, $filter );
        }

        return [];
    }

    const TEMPLATE = [
        self::HANDLE[ 'main' ] => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-achievement-main.php',

        self::HANDLE[ 'style' ] => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-achievement-style.php',
    ];

    public static function check_disabled( $filter )
    {
        if ( !empty( $filter[ 'achievement' ] ) )
        {
            return $filter[ 'achievement' ] == self::TYPE_DISABLED;
        }
        
        return false;
    }

    public static function render( $achievement )
    {
        return LegalComponents::render_main( self::TEMPLATE[ self::HANDLE[ 'main' ] ], $achievement );
    }

    public static function render_achievement( $title )
    {
        return LegalComponents::render_main( self::TEMPLATE[ self::HANDLE[ 'main' ] ], self::get( $title ) );
    }

    public static function render_style( $args )
    {
        $billet = BilletMain::get( $args );

        $title = BilletTitle::get( $billet ); 

        if ( self::check_disabled( $title[ 'filter' ] ) )
        {
            return '';
        }

        return LegalComponents::render_main( self::TEMPLATE[ self::HANDLE[ 'style' ] ], self::get( $title ) );
    }
}

?>