<?php

class BilletBonus
{
    const FIELD = [
        'feture-bonus' => 'billet-feture-bonus',
    ];

    const FETURE_BONUS = [
        'feture-id' => 'billet-feture-id',

        'bonus-id' => 'billet-bonus-id',

        'bonus-title' => 'billet-bonus-title',

        'bonus-description' => 'billet-bonus-description',
    ];

    public static function get_feture_bonus( $id, $filter = [] )
    {
        $result = null;

        $feature_bonus_item = null;

        $feature_bonus = get_field( self::FIELD[ 'feture-bonus' ], $id );

        if ( $feature_bonus )
        {
            foreach ( $feature_bonus as $feature_bonus_item )
            {
                if ( in_array( $feature_bonus_item[ self::FETURE_BONUS[ 'feture-id' ] ], $filter[ 'features' ] ) )
                {
                    $result = null;
                }
            }
        }

        LegalDebug::debug( [
            'function' => 'BilletBonus::get_feture_bonus',

            'feature_bonus_item' => $feature_bonus_item,

            'result' => $result,

            'id' => $id,

            'filter' => $filter,
        ] );

        return $result;
    }

    private static function get_bonus( $billet )
    {
        $args = [];

        // $feature_bonus = get_field( self::FIELD[ 'feture-bonus' ], $billet[ 'id' ] );

        // if ( $feature_bonus )
        // {
        //     foreach ( $feature_bonus as $feature_bonus_item )
        //     {
        //         if ( in_array( $feature_bonus_item[ self::FETURE_BONUS[ 'feture-id' ] ], $billet[ 'filter' ][ 'features' ] ) )
        //         {
        //             // $href = get_post_permalink( $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-id' ] ] );

        //             // LegalDebug::debug( [
        //             //     'href' => $href,
        //             // ] );

        //             // $args = BilletMain::href( $href );

        //             $args = BilletMain::href( $billet[ 'url' ][ 'bonus' ] );

        //             $args[ 'title' ] = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-title' ] ];

        //             $args[ 'description' ] = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-description' ] ];
        //         }
        //     }
        // }

        $feature_bonus_item = self::get_feture_bonus( $billet[ 'id' ], $billet[ 'filter' ] );

        if ( empty( $feature_bonus_item ) )
        {
            $args = BilletMain::href( $billet[ 'url' ][ 'bonus' ] );

            $args[ 'title' ] = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-title' ] ];

            $args[ 'description' ] = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-description' ] ];
        }

        if ( empty( $args ) )
        {
            if ( !empty( $billet[ 'bonus' ] ) )
            {
                $args = BilletMain::href( $billet[ 'url' ][ 'bonus' ] );

                $args[ 'title' ] = $billet[ 'bonus' ][ 'title' ];

                $args[ 'description' ] = $billet[ 'bonus' ][ 'description' ];
            }
        }
        

        return $args;
    }

    public static function get( $billet )
    {
        // LegalDebug::debug( [
        //     'function' => 'BilletBonus::get',

        //     'billet' => $billet,
        // ] );

        $enabled = true;

        if ( !empty( $billet[ 'filter' ] ) ) {
            $enabled = $billet[ 'filter' ][ 'bonus' ];
        }

        if ( $enabled ) {
            return self::get_bonus( $billet );
        }

        return [];
    }

    const TEMPLATE = [
        'bonus' => LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-bonus.php',
    ];

    public static function render( $billet )
    {
        $args = self::get( $billet );

        if ( !empty( $args ) ) {
            load_template( self::TEMPLATE[ 'bonus' ], false, $args );
        }
    }
}

?>